<?php

if (!defined('ABSPATH')) {
    exit;
}

// Multisite can produce http:// asset URLs (e.g. fonts) on https pages, which browsers block as mixed content.
add_action('wp_head', function () {
    echo '<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">';
}, 1);
