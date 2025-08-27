<?php
// Get the site URL
$site_url = '';
exec('wp eval "echo home_url();" --path=' . escapeshellarg($argv[1]), $output, $return_code);
if ($return_code === 0 && !empty($output)) {
    $site_url = trim($output[0]);
}

// Build the serialized data array
$dflip_data = array(
    'source_type' => 'pdf',
    'pdf_source' => $site_url.'/wp-content/uploads/2024/11/DfS-Djembe-Buyers-Guide-Version2-18-11-2024-13_14_06_071.pdf',
    'pdf_thumb' => $site_url.'/wp-content/uploads/2025/07/buyer-thumb-scaled-1.jpg',
    'pages' => array(
        array(
            'url' => '',
            'hotspots' => array()
        )
    ),
    'viewerType' => 'global',
    'webgl' => 'global',
    'hard' => 'global',
    'bg_color' => '',
    'bg_image' => '',
    'duration' => '',
    'height' => '',
    'texture_size' => 'global',
    'auto_sound' => 'global',
    'enable_download' => 'global',
    'page_mode' => 'global',
    'single_page_mode' => 'global',
    'controls_position' => 'global',
    'direction' => '1',
    'autoplay' => 'global',
    'autoplay_duration' => '',
    'autoplay_start' => 'global',
    'page_size' => '0',
    'auto_outline' => 'false',
    'auto_thumbnail' => 'false',
    'overwrite_outline' => 'false',
    'outline' => array(),
    'title' => 'Buyers Flipbook',
    'slug' => 'buyers-flipbook',
    'status' => 'publish'
);

// Serialize the data
$serialized_data = serialize($dflip_data);

// Escape the serialized data for SQL
$serialized_data = addslashes($serialized_data);

// Read the SQL template and replace placeholders
$sql = file_get_contents(__DIR__ . '/set-djembe-dilemmas-template.sql');
$sql = str_replace('--serialized_data--', $serialized_data, $sql);
$sql = str_replace('--site_url--', $site_url, $sql);

echo $sql;