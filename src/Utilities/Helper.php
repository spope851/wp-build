<?php

namespace Spenpo\WpBuild\Utilities;

/**
 * Helper Utilities
 * 
 * Common utility functions for your WordPress project.
 */
class Helper
{
    /**
     * Get the current page type
     */
    public static function get_page_type()
    {
        if (is_home()) return 'home';
        if (is_single()) return 'single';
        if (is_page()) return 'page';
        if (is_archive()) return 'archive';
        if (is_search()) return 'search';
        if (is_404()) return '404';
        return 'unknown';
    }

    /**
     * Check if we're in development mode
     */
    public static function is_dev()
    {
        return defined('WP_DEBUG') && WP_DEBUG;
    }

    /**
     * Log a message to debug log
     */
    public static function log($message)
    {
        if (self::is_dev()) {
            error_log('[WpBuild] ' . $message);
        }
    }

    /**
     * Get asset URL with version for cache busting
     */
    public static function get_asset_url($path)
    {
        $version = self::is_dev() ? time() : '1.0.0';
        return get_template_directory_uri() . '/assets/' . $path . '?v=' . $version;
    }
} 