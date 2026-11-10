<?php

if (!defined('ABSPATH')) {
    exit;
}

// Projects are only used on Trelleborg Växer, whose existing project content lives in this site's tables.
const MUNICIPIO_COMPANION_TRELLEBORG_VAXER_BLOG_ID = 4;

function municipio_companion_trelleborg_is_vaxer_site() {
    return get_current_blog_id() === MUNICIPIO_COMPANION_TRELLEBORG_VAXER_BLOG_ID;
}

function municipio_companion_trelleborg_register_project_post_type() {
    if (!municipio_companion_trelleborg_is_vaxer_site()) {
        return;
    }

    register_post_type('project', [
        'label' => 'Projekt',
        'labels' => [
            'name' => 'Projekt',
            'singular_name' => 'Projekt',
            'menu_name' => 'Projekt',
            'name_admin_bar' => 'Projekt',
            'add_new' => 'Lägg till ny',
            'add_new_item' => 'Lägg till nytt projekt',
            'new_item' => 'Nytt projekt',
            'edit_item' => 'Redigera projekt',
            'view_item' => 'Visa projekt',
            'all_items' => 'Alla projekt',
            'search_items' => 'Sök projekt',
            'not_found' => 'Inga projekt hittades.',
            'not_found_in_trash' => 'Inga projekt hittades i papperskorgen.',
            'archives' => 'Projektarkiv',
        ],
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true,
        'show_in_graphql' => true,
        'query_var' => true,
        'rewrite' => [
            'slug' => 'projekt',
            'with_front' => false,
        ],
        'menu_icon' => 'dashicons-portfolio',
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 20,
        'supports' => ['title', 'editor', 'author', 'thumbnail', 'excerpt'],
        'taxonomies' => ['project_category', 'project_status'],
    ]);
}

function municipio_companion_trelleborg_register_project_taxonomies() {
    if (!municipio_companion_trelleborg_is_vaxer_site()) {
        return;
    }

    register_taxonomy('project_category', ['project'], [
        'hierarchical' => true,
        'label' => 'Projektkategorier',
        'labels' => [
            'name' => 'Projektkategorier',
            'singular_name' => 'Projektkategori',
            'menu_name' => 'Projektkategorier',
            'name_admin_bar' => 'Projektkategori',
            'add_new' => 'Lägg till ny',
            'add_new_item' => 'Lägg till ny projektkategori',
            'new_item' => 'Ny projektkategori',
            'edit_item' => 'Redigera projektkategori',
            'view_item' => 'Visa projektkategori',
            'all_items' => 'Alla projektkategorier',
            'search_items' => 'Sök projektkategorier',
            'parent_item_colon' => 'Överordnad projektkategori:',
            'not_found' => 'Inga projektkategorier hittades.',
            'not_found_in_trash' => 'Inga projektkategorier hittades i papperskorgen.',
            'archives' => 'Projektkategoriarkiv',
        ],
        'rewrite' => [
            'slug' => 'project-categories',
        ],
        'show_in_graphql' => true,
        'graphql_single_name' => 'projectCategory',
        'graphql_plural_name' => 'projectCategories',
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
    ]);

    register_taxonomy('project_status', ['project'], [
        'hierarchical' => true,
        'label' => 'Projektstatusar',
        'labels' => [
            'name' => 'Projektstatusar',
            'singular_name' => 'Projektstatus',
            'menu_name' => 'Projektstatusar',
            'name_admin_bar' => 'Projektstatus',
            'add_new' => 'Lägg till ny',
            'add_new_item' => 'Lägg till ny projektstatus',
            'new_item' => 'Ny projektstatus',
            'edit_item' => 'Redigera projektstatus',
            'view_item' => 'Visa projektstatus',
            'all_items' => 'Alla projektstatusar',
            'search_items' => 'Sök projektstatusar',
            'parent_item_colon' => 'Överordnad projektstatus:',
            'not_found' => 'Inga projektstatusar hittades.',
            'not_found_in_trash' => 'Inga projektstatusar hittades i papperskorgen.',
            'archives' => 'Projektstatusarkiv',
        ],
        'rewrite' => [
            'slug' => 'project-statuses',
        ],
        'show_in_graphql' => true,
        'graphql_single_name' => 'projectStatus',
        'graphql_plural_name' => 'projectStatuses',
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
    ]);
}

add_action('init', 'municipio_companion_trelleborg_register_project_post_type');
add_action('init', 'municipio_companion_trelleborg_register_project_taxonomies');
