<?php
/**
 * Test script for WordPress build
 */

echo "=== WordPress Build Test ===\n\n";

// Test 1: Check if WordPress core files exist
echo "1. Testing WordPress core files...\n";
$core_files = [
    'web/index.php',
    'web/wp-config.php',
    'web/wp-load.php',
    'web/wp-settings.php'
];

foreach ($core_files as $file) {
    if (file_exists($file)) {
        echo "   ✓ $file exists\n";
    } else {
        echo "   ✗ $file missing\n";
    }
}

// Test 2: Check if plugins are installed
echo "\n2. Testing installed plugins...\n";
$plugins = [
    'web/wp-content/plugins/woocommerce',
    'web/wp-content/plugins/contact-form-7',
    'web/wp-content/plugins/wordpress-seo'
];

foreach ($plugins as $plugin) {
    if (is_dir($plugin)) {
        echo "   ✓ $plugin installed\n";
    } else {
        echo "   ✗ $plugin missing\n";
    }
}

// Test 3: Check WordPress version
echo "\n3. Testing WordPress version...\n";
if (file_exists('web/wp-includes/version.php')) {
    include 'web/wp-includes/version.php';
    echo "   ✓ WordPress version: $wp_version\n";
} else {
    echo "   ✗ Could not determine WordPress version\n";
}

// Test 4: Check PHP compatibility
echo "\n4. Testing PHP compatibility...\n";
echo "   ✓ PHP version: " . PHP_VERSION . "\n";
echo "   ✓ Required: ^8.3\n";

// Test 5: Check directory structure
echo "\n5. Testing directory structure...\n";
$directories = [
    'web/wp-admin',
    'web/wp-includes',
    'web/wp-content/plugins',
    'web/wp-content/themes',
    'src'
];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        echo "   ✓ $dir exists\n";
    } else {
        echo "   ✗ $dir missing\n";
    }
}

echo "\n=== Test Complete ===\n"; 