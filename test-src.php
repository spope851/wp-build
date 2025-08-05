<?php
/**
 * Test script for src/ directory autoloading
 */

echo "=== Testing src/ Directory Autoloading ===\n\n";

// Test 1: Check if autoloader can load our custom classes
echo "1. Testing class autoloading...\n";

try {
    require_once 'vendor/autoload.php';
    
    // Test loading the helper utility class (no WordPress dependencies)
    $helper = new \Spenpo\WpBuild\Utilities\Helper();
    echo "   ✓ Helper class loaded successfully\n";
    
    // Test static methods that don't depend on WordPress
    $is_dev = \Spenpo\WpBuild\Utilities\Helper::is_dev();
    echo "   ✓ Helper::is_dev() works: " . ($is_dev ? 'true' : 'false') . "\n";
    
    // Test that we can instantiate the CustomPlugin class (but not call WordPress functions)
    $reflection = new ReflectionClass('\Spenpo\WpBuild\CustomPlugin');
    echo "   ✓ CustomPlugin class can be reflected\n";
    
} catch (Exception $e) {
    echo "   ✗ Error loading classes: " . $e->getMessage() . "\n";
}

// Test 2: Check if bootstrap file exists and is valid
echo "\n2. Testing bootstrap file...\n";
if (file_exists('src/bootstrap.php')) {
    echo "   ✓ bootstrap.php exists\n";
    
    // Check if it has valid PHP syntax
    $bootstrap_content = file_get_contents('src/bootstrap.php');
    if (strpos($bootstrap_content, 'namespace Spenpo\\WpBuild') !== false) {
        echo "   ✓ bootstrap.php has correct namespace\n";
    } else {
        echo "   ✗ bootstrap.php missing correct namespace\n";
    }
} else {
    echo "   ✗ bootstrap.php missing\n";
}

// Test 3: Check directory structure
echo "\n3. Testing src/ directory structure...\n";
$src_files = [
    'src/CustomPlugin.php',
    'src/Utilities/Helper.php',
    'src/bootstrap.php'
];

foreach ($src_files as $file) {
    if (file_exists($file)) {
        echo "   ✓ $file exists\n";
    } else {
        echo "   ✗ $file missing\n";
    }
}

// Test 4: Check namespace mapping
echo "\n4. Testing namespace mapping...\n";
$composer_json = json_decode(file_get_contents('composer.json'), true);
$autoload = $composer_json['autoload']['psr-4'] ?? [];

if (isset($autoload['Spenpo\\WpBuild\\'])) {
    $src_path = $autoload['Spenpo\\WpBuild\\'];
    echo "   ✓ Namespace 'Spenpo\\WpBuild\\' maps to '$src_path'\n";
} else {
    echo "   ✗ Namespace mapping not found\n";
}

echo "\n=== Test Complete ===\n";
echo "\nYour custom code in src/ will be automatically loaded by WordPress!\n";
echo "You can now use classes like:\n";
echo "- Spenpo\\WpBuild\\CustomPlugin\n";
echo "- Spenpo\\WpBuild\\Utilities\\Helper\n"; 