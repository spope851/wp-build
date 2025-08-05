<?php

namespace Spenpo\WpBuild;

/**
 * Bootstrap file for custom WordPress functionality
 * 
 * This file gets loaded by WordPress and initializes your custom code.
 */

// Initialize custom plugin
new CustomPlugin();

// Initialize custom features
new Features\SocialSharing();

// You can add more initialization here
// new AnotherCustomClass();
// new Spenpo\WpBuild\Admin\AdminPanel();

// Example: Add a custom shortcode
add_shortcode('custom_info', function($atts) {
    $atts = shortcode_atts([
        'title' => 'Custom Info',
        'content' => 'This is custom content from your src/ directory!'
    ], $atts);
    
    return '<div class="custom-info">
        <h3>' . esc_html($atts['title']) . '</h3>
        <p>' . esc_html($atts['content']) . '</p>
    </div>';
});

// Example: Add custom admin menu
add_action('admin_menu', function() {
    add_menu_page(
        'Custom Settings',
        'Custom Settings',
        'manage_options',
        'custom-settings',
        function() {
            echo '<div class="wrap">
                <h1>Custom Settings</h1>
                <p>This is a custom admin page from your src/ directory!</p>
            </div>';
        }
    );
}); 