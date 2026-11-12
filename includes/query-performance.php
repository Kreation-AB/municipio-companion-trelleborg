<?php
if (!defined('ABSPATH')) {
    exit;
}

const MUNICIPIO_COMPANION_TRELLEBORG_POSTS_MODULE_QUERY_VAR = 'municipio_companion_trelleborg_posts_module';

// Mark a query as originating from the Posts module so that duplicate meta query clauses can be removed.
function municipio_companion_trelleborg_mark_posts_module_query($args) {
    $args[MUNICIPIO_COMPANION_TRELLEBORG_POSTS_MODULE_QUERY_VAR] = true;
    return $args;
}

// Remove duplicate meta query clauses from Posts module queries.
function municipio_companion_trelleborg_remove_duplicate_meta_query_clauses($query) {
    // Only proceed if this query is marked as originating from the Posts module.
    if (!$query->get(MUNICIPIO_COMPANION_TRELLEBORG_POSTS_MODULE_QUERY_VAR)) {
        return;
    }

    $metaQuery = $query->get('meta_query');

    if (!is_array($metaQuery)) {
        return;
    }

    $uniqueMetaQuery = [];

    // Iterate through the meta query clauses and keep only unique ones.
    foreach ($metaQuery as $key => $clause) {
        // Named clauses can be referenced by orderby, so only unnamed clauses are removed.
        if (is_int($key) && in_array($clause, $uniqueMetaQuery, true)) {
            continue;
        }

        $uniqueMetaQuery[$key] = $clause;
    }

    // If no duplicates were found, there's no need to update the query.
    if (count($uniqueMetaQuery) === count($metaQuery)) {
        return;
    }

    $query->set('meta_query', $uniqueMetaQuery);
}

add_filter('Modularity/Module/Posts/GetPosts/Args', 'municipio_companion_trelleborg_mark_posts_module_query');
add_action('pre_get_posts', 'municipio_companion_trelleborg_remove_duplicate_meta_query_clauses', 2);
