<?php

/**
 * Plugin Name: Municipio Companion Trelleborg
 * Description: Utility plugin with small fixes and adjustments for Municipio.
 * Version: 1.0.0
 * Text Domain: municipio-companion-trelleborg
 */

if (!defined('ABSPATH')) {
    exit;
}

define('MUNICIPIO_COMPANION_TRELLEBORG_FILE', __FILE__);

require_once __DIR__ . '/includes/style.php';
require_once __DIR__ . '/includes/multisite.php';
require_once __DIR__ . '/includes/projects.php';
require_once __DIR__ . '/includes/query-performance.php';
