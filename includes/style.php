<?php

if (!defined('ABSPATH')) {
    exit;
}

// Load custom styles for Municipio adjustments
add_action('wp_enqueue_scripts', function () {
    $relativePath = 'assets/css/municipio-adjustments.css';

    wp_enqueue_style(
        'municipio-adjustments',
        plugin_dir_url(MUNICIPIO_COMPANION_TRELLEBORG_FILE) . $relativePath,
        [],
        (string) filemtime(plugin_dir_path(MUNICIPIO_COMPANION_TRELLEBORG_FILE) . $relativePath)
    );
}, PHP_INT_MAX);
