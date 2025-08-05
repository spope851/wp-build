<?php

namespace Spenpo\WpBuild\Features;

/**
 * Custom Social Sharing Feature
 * 
 * This is an example of how you can create custom functionality
 * that's specific to your WordPress project.
 */
class SocialSharing
{
    private $platforms = ['facebook', 'twitter', 'linkedin'];
    
    public function __construct()
    {
        // Only add social sharing on single posts
        if (is_single()) {
            add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
            add_filter('the_content', [$this, 'add_social_buttons']);
        }
    }
    
    public function enqueue_scripts()
    {
        // Add custom CSS for social buttons
        wp_enqueue_style(
            'social-sharing', 
            \Spenpo\WpBuild\Utilities\Helper::get_asset_url('css/social-sharing.css')
        );
    }
    
    public function add_social_buttons($content)
    {
        if (!is_single()) {
            return $content;
        }
        
        $post_url = get_permalink();
        $post_title = get_the_title();
        
        $social_html = '<div class="social-sharing">
            <h4>Share this post:</h4>
            <div class="social-buttons">';
        
        foreach ($this->platforms as $platform) {
            $social_html .= $this->get_social_button($platform, $post_url, $post_title);
        }
        
        $social_html .= '</div></div>';
        
        return $content . $social_html;
    }
    
    private function get_social_button($platform, $url, $title)
    {
        $share_url = '';
        $icon = '';
        
        switch ($platform) {
            case 'facebook':
                $share_url = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($url);
                $icon = '📘';
                break;
            case 'twitter':
                $share_url = "https://twitter.com/intent/tweet?url=" . urlencode($url) . "&text=" . urlencode($title);
                $icon = '🐦';
                break;
            case 'linkedin':
                $share_url = "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($url);
                $icon = '💼';
                break;
        }
        
        return '<a href="' . esc_url($share_url) . '" 
                   class="social-button ' . $platform . '" 
                   target="_blank" 
                   rel="noopener noreferrer">
                   ' . $icon . ' Share on ' . ucfirst($platform) . '
                </a>';
    }
} 