-- Migration: Set page ID 7 to use custom-worksheet-landing.php template
-- This script sets the _wp_page_template meta field for page ID 7

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) 
VALUES (7, '_wp_page_template', 'custom-worksheet-landing.php')
ON DUPLICATE KEY UPDATE meta_value = 'custom-worksheet-landing.php';

INSERT INTO `wp_posts` (`ID`, `post_author`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_name`, `post_parent`, `guid`, `menu_order`, `post_type`)
VALUES ('68682', '88067', '', 'Buyers Flipbook', '', 'publish', 'closed', 'closed', 'buyers-flipbook', '0', '--site_url--/?post_type=dflip&#038;p=68682', '0', 'dflip');

INSERT INTO `wp_postmeta` (`meta_id`, `post_id`, `meta_key`, `meta_value`)
VALUES (NULL, '68682', '_dflip_data', '--serialized_data--');
