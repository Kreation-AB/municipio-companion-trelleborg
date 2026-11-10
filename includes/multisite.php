<?php

if (!defined('ABSPATH')) {
    exit;
}

// Multisite can produce http:// asset URLs (e.g. fonts) on https pages, which browsers block as mixed content.
function municipio_companion_trelleborg_print_upgrade_insecure_requests()
{
    echo '<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">';
}

add_action('wp_head', 'municipio_companion_trelleborg_print_upgrade_insecure_requests', 1);
// admin_head runs after the admin stylesheets are printed, so the tag must come before print_admin_styles (priority 20).
add_action('admin_print_styles', 'municipio_companion_trelleborg_print_upgrade_insecure_requests', 0);
