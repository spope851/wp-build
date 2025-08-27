<?php
/**
 * R2 Image Sync Script
 * 
 * This script syncs images between local uploads directory and Cloudflare R2 storage.
 * It can upload local images to R2 or download images from R2 to local.
 */

require_once 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class R2ImageSync {
    private $s3Client;
    private $bucket;
    private $localUploadsDir;
    private $buildUploadsDir;
    
    public function __construct() {
        // Load environment variables from .env file for local development
        if (file_exists('.env')) {
            $this->loadEnvFile('.env');
        }
        
        // Validate required environment variables
        $requiredVars = ['R2_ACCESS_KEY_ID', 'R2_SECRET_ACCESS_KEY', 'R2_ENDPOINT'];
        $missingVars = [];
        
        foreach ($requiredVars as $var) {
            if (!getenv($var)) {
                $missingVars[] = $var;
            }
        }
        
        if (!empty($missingVars)) {
            echo "❌ Missing required environment variables: " . implode(', ', $missingVars) . "\n";
            echo "   These should be set in your environment or in a .env file for local development.\n";
            echo "   For production builds, ensure these are set as environment variables.\n";
            exit(1);
        }
        
        $this->bucket = getenv('R2_BUCKET_NAME') ?: 'dealvault';
        $this->localUploadsDir = 'src/uploads';
        $this->buildUploadsDir = 'wordpress/wp-content/uploads';
                
        // Initialize S3 client for R2
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'auto',
            'endpoint' => getenv('R2_ENDPOINT'),
            'credentials' => [
                'key' => getenv('R2_ACCESS_KEY_ID'),
                'secret' => getenv('R2_SECRET_ACCESS_KEY'),
            ],
            'use_path_style_endpoint' => true,
        ]);
    }
    
    private function loadEnvFile($file) {
        if (!file_exists($file)) {
            return;
        }
        
        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Skip comments and empty lines
            if (empty($line) || strpos($line, '#') === 0) {
                continue;
            }
            
            if (strpos($line, '=') !== false) {
                list($key, $value) = explode('=', $line, 2);
                $key = trim($key);
                $value = trim($value, '"\'');
                
                // Only set if not already set in environment
                if (!getenv($key)) {
                    putenv("$key=$value");
                }
            }
        }
    }
    
    public function uploadToR2($dryRun = false) {
        echo "📤 Uploading local images to R2...\n";
        
        if (!is_dir($this->localUploadsDir)) {
            echo "❌ Local uploads directory not found: {$this->localUploadsDir}\n";
            return false;
        }
        
        $files = $this->scanDirectory($this->localUploadsDir);
        $uploaded = 0;
        
        foreach ($files as $file) {
            $relativePath = str_replace($this->localUploadsDir . '/', '', $file);
            $r2Key = 'uploads/' . $relativePath;
            
            if ($dryRun) {
                echo "   Would upload: $file -> $r2Key\n";
                continue;
            }
            
            try {
                $result = $this->s3Client->putObject([
                    'Bucket' => $this->bucket,
                    'Key' => $r2Key,
                    'SourceFile' => $file,
                    'ContentType' => $this->getMimeType($file),
                    'ACL' => 'public-read',
                ]);
                
                echo "   ✅ Uploaded: $relativePath\n";
                $uploaded++;
                
            } catch (AwsException $e) {
                echo "   ❌ Failed to upload $relativePath: " . $e->getMessage() . "\n";
            }
        }
        
        if ($dryRun) {
            echo "   🔍 Dry run complete. Would upload " . count($files) . " files.\n";
        } else {
            echo "   �� Upload complete: $uploaded uploaded\n";
        }
        
        return true;
    }
    
    public function downloadFromR2($dryRun = false) {
        echo "📥 Downloading images from R2 to local...\n";
        
        try {
            $objects = $this->s3Client->listObjects([
                'Bucket' => $this->bucket,
                'Prefix' => 'uploads/',
            ]);
            
            $downloaded = 0;
            
            foreach ($objects['Contents'] as $object) {
                $r2Key = $object['Key'];
                
                if (!str_starts_with($r2Key, 'uploads/')) {
                    continue;
                }
                
                $relativePath = str_replace('uploads/', '', $r2Key);
                $localPath = $this->buildUploadsDir . '/' . $relativePath;
                
                $localDir = dirname($localPath);
                if (!is_dir($localDir)) {
                    if (!$dryRun) {
                        mkdir($localDir, 0755, true);
                    }
                }
                
                if ($dryRun) {
                    echo "   Would download: $r2Key -> $localPath\n";
                    continue;
                }
                
                try {
                    $result = $this->s3Client->getObject([
                        'Bucket' => $this->bucket,
                        'Key' => $r2Key,
                        'SaveAs' => $localPath,
                    ]);
                    
                    echo "   ✅ Downloaded: $relativePath\n";
                    $downloaded++;
                    
                } catch (AwsException $e) {
                    echo "   ❌ Failed to download $relativePath: " . $e->getMessage() . "\n";
                }
            }
            
            if ($dryRun) {
                echo "   🔍 Dry run complete. Would download " . count($objects['Contents']) . " files.\n";
            } else {
                echo "   📊 Download complete: $downloaded downloaded\n";
            }
            
        } catch (AwsException $e) {
            echo "   ❌ Failed to list objects: " . $e->getMessage() . "\n";
            return false;
        }
        
        return true;
    }
    
    private function scanDirectory($dir) {
        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS)
        );
        
        foreach ($iterator as $file) {
            if ($file->isFile() && $this->isImageFile($file->getPathname())) {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
    
    private function isImageFile($file) {
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'ico'];
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        return in_array($extension, $imageExtensions);
    }
    
    private function getMimeType($file) {
        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'ico' => 'image/x-icon',
        ];
        
        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }
}

// CLI usage
if (php_sapi_name() === 'cli') {
    $sync = new R2ImageSync();
    
    $command = $argv[1] ?? 'help';
    $dryRun = in_array('--dry-run', $argv);
    
    switch ($command) {
        case 'upload':
            $sync->uploadToR2($dryRun);
            break;
        case 'download':
            $sync->downloadFromR2($dryRun);
            break;
        case 'help':
        default:
            echo "R2 Image Sync Tool\n\n";
            echo "Usage: php r2-sync.php <command> [options]\n\n";
            echo "Commands:\n";
            echo "  upload     - Upload all local images to R2\n";
            echo "  download   - Download all images from R2 to local\n";
            echo "  help       - Show this help message\n\n";
            echo "Options:\n";
            echo "  --dry-run  - Show what would be done without making changes\n\n";
            echo "Examples:\n";
            echo "  php r2-sync.php upload\n";
            echo "  php r2-sync.php download --dry-run\n";
            break;
    }
}
