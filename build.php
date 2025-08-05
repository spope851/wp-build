<?php
/**
 * WordPress Build Script
 * 
 * This script rebuilds the entire WordPress installation from Composer dependencies.
 * Run this after cloning the repository or when you need a fresh WordPress install.
 */

echo "=== WordPress Build Script ===\n\n";

// Step 1: Clean up existing installation
echo "1. Cleaning up existing WordPress installation...\n";
if (is_dir('web')) {
    echo "   Removing existing web/ directory...\n";
    system('rm -rf web');
}

if (is_dir('wordpress')) {
    echo "   Removing existing wordpress/ directory...\n";
    system('rm -rf wordpress');
}

if (is_dir('wp-content')) {
    echo "   Removing existing wp-content/ directory...\n";
    system('rm -rf wp-content');
}

if (is_dir('vendor')) {
    echo "   Removing existing vendor/ directory...\n";
    system('rm -rf vendor');
}

if (file_exists('composer.lock')) {
    echo "   Removing composer.lock...\n";
    unlink('composer.lock');
}

// Step 2: Install Composer dependencies
echo "\n2. Installing Composer dependencies...\n";
$composer_output = [];
$composer_return = 0;
exec('composer install', $composer_output, $composer_return);

if ($composer_return !== 0) {
    echo "   ✗ Composer install failed!\n";
    echo "   Output: " . implode("\n", $composer_output) . "\n";
    exit(1);
}

echo "   ✓ Composer dependencies installed successfully\n";

// Step 3: Create web directory and move WordPress files
echo "\n3. Setting up web directory...\n";
if (!is_dir('wordpress')) {
    echo "   ✗ wordpress/ directory not created by Composer\n";
    exit(1);
}

// Create web directory and move WordPress files
system('mkdir -p web');
system('mv wordpress/* web/');
system('mv wp-content web/');
system('rmdir wordpress');

echo "   ✓ WordPress files moved to web/ directory\n";

// Step 4: Create WordPress configuration
echo "\n4. Creating WordPress configuration...\n";

// Create wp-config.php from template
$wp_config_template = file_get_contents('web/wp-config-sample.php');
$wp_config_content = str_replace(
    [
        "define( 'DB_NAME', 'database_name_here' );",
        "define( 'DB_USER', 'username_here' );",
        "define( 'DB_PASSWORD', 'password_here' );",
        "define( 'DB_HOST', 'localhost' );",
        "define( 'AUTH_KEY',         'put your unique phrase here' );",
        "define( 'SECURE_AUTH_KEY',  'put your unique phrase here' );",
        "define( 'LOGGED_IN_KEY',    'put your unique phrase here' );",
        "define( 'NONCE_KEY',        'put your unique phrase here' );",
        "define( 'AUTH_SALT',        'put your unique phrase here' );",
        "define( 'SECURE_AUTH_SALT', 'put your unique phrase here' );",
        "define( 'LOGGED_IN_SALT',   'put your unique phrase here' );",
        "define( 'NONCE_SALT',       'put your unique phrase here' );"
    ],
    [
        "define( 'DB_NAME', 'wp_test' );",
        "define( 'DB_USER', 'root' );",
        "define( 'DB_PASSWORD', '' );",
        "define( 'DB_HOST', 'localhost' );",
        "define( 'AUTH_KEY',         '" . generate_random_string(64) . "' );",
        "define( 'SECURE_AUTH_KEY',  '" . generate_random_string(64) . "' );",
        "define( 'LOGGED_IN_KEY',    '" . generate_random_string(64) . "' );",
        "define( 'NONCE_KEY',        '" . generate_random_string(64) . "' );",
        "define( 'AUTH_SALT',        '" . generate_random_string(64) . "' );",
        "define( 'SECURE_AUTH_SALT', '" . generate_random_string(64) . "' );",
        "define( 'LOGGED_IN_SALT',   '" . generate_random_string(64) . "' );",
        "define( 'NONCE_SALT',       '" . generate_random_string(64) . "' );"
    ],
    $wp_config_template
);

// Add custom configuration
$custom_config = "\n// Custom configuration for development\n";
$custom_config .= "define( 'WP_DEBUG', true );\n";
$custom_config .= "define( 'WP_DEBUG_LOG', true );\n";
$custom_config .= "define( 'WP_DEBUG_DISPLAY', false );\n";
$custom_config .= "define( 'AUTOMATIC_UPDATER_DISABLED', true );\n";
$custom_config .= "define( 'DISALLOW_FILE_EDIT', true );\n";
$custom_config .= "define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );\n";
$custom_config .= "define( 'WP_CONTENT_URL', '/wp-content' );\n";
$custom_config .= "\n// Load custom code from src/ directory\n";
$custom_config .= "require_once __DIR__ . '/../vendor/autoload.php';\n";
$custom_config .= "require_once __DIR__ . '/../src/bootstrap.php';\n";

// Insert custom config before the final require
$wp_config_content = str_replace(
    "require_once ABSPATH . 'wp-settings.php';",
    $custom_config . "\nrequire_once ABSPATH . 'wp-settings.php';",
    $wp_config_content
);

file_put_contents('web/wp-config.php', $wp_config_content);
echo "   ✓ WordPress configuration created\n";

// Step 5: Create necessary directories
echo "\n5. Creating necessary directories...\n";
$directories = [
    'web/wp-content/uploads',
    'web/wp-content/cache',
    'web/wp-content/mu-plugins',
    'web/wp-content/themes'
];

foreach ($directories as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
        echo "   ✓ Created $dir\n";
    } else {
        echo "   ✓ $dir already exists\n";
    }
}

// Step 6: Set permissions
echo "\n6. Setting file permissions...\n";
system('chmod -R 755 web/');
echo "   ✓ File permissions set\n";

// Step 7: Verify installation
echo "\n7. Verifying installation...\n";
$required_files = [
    'web/index.php',
    'web/wp-config.php',
    'web/wp-content/plugins/woocommerce',
    'web/wp-content/plugins/contact-form-7',
    'web/wp-content/plugins/wordpress-seo'
];

$all_good = true;
foreach ($required_files as $file) {
    if (file_exists($file)) {
        echo "   ✓ $file exists\n";
    } else {
        echo "   ✗ $file missing\n";
        $all_good = false;
    }
}

if ($all_good) {
    echo "\n=== Build Complete! ===\n";
    echo "Your WordPress installation has been rebuilt successfully.\n";
    echo "You can now start the development server:\n";
    echo "  php -S localhost:8000 -t web/\n";
} else {
    echo "\n=== Build Failed! ===\n";
    echo "Some required files are missing. Please check the errors above.\n";
    exit(1);
}

/**
 * Generate a random string for WordPress security keys
 */
function generate_random_string($length = 64) {
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_+-=[]{}|;:,.<>?';
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $string;
} 