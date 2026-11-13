<?php

if (!defined('ABSPATH')) {
    exit;
}

// Pages lack excerpt support in WordPress core, and Municipio has no setting for built-in post types.
function municipio_companion_trelleborg_add_page_excerpt_support() {
    add_post_type_support('page', 'excerpt');
}

add_action('init', 'municipio_companion_trelleborg_add_page_excerpt_support');
