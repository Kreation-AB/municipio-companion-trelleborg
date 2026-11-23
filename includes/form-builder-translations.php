<?php

if (!defined('ABSPATH')) {
    exit;
}

// Workaround for Modularity Form Builder (4.0.16–4.0.30): it loads its textdomain on `init`, but its ACF import
// calls __() earlier on `plugins_loaded`. WordPress then caches the wrong translation directory and the plugin's
// Swedish strings (e.g. "I consent") are never used. Registering the path before the import (priority 10) fixes it.
// Remove when Form Builder loads its textdomain before the ACF import.
function municipio_companion_trelleborg_load_form_builder_translations() {
    load_plugin_textdomain('modularity-form-builder', false, 'modularity-form-builder/languages');
}

add_action('plugins_loaded', 'municipio_companion_trelleborg_load_form_builder_translations', 9);
