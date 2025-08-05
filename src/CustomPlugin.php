<?php

namespace Spenpo\WpBuild;

/**
 * Custom Plugin Example
 * 
 * This shows how you can create custom WordPress functionality
 * that gets automatically loaded by Composer.
 */
class CustomPlugin
{
    public function __construct()
    {
        // Hook into WordPress
        add_action('init', [$this, 'init']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_filter('the_title', [$this, 'modify_title']);
    }

    public function init()
    {
        // Your initialization code here
        // This runs when WordPress initializes
    }

    public function enqueue_scripts()
    {
        // Enqueue custom CSS/JS
        wp_enqueue_style('custom-styles', get_template_directory_uri() . '/assets/css/custom.css');
    }

    public function modify_title($title)
    {
        // Example: Add a prefix to all post titles
        return '📝 ' . $title;
    }
} 