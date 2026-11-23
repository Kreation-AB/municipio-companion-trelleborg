<?php

if (!defined('ABSPATH')) {
    exit;
}

// Posts are used as news. Municipio shows the post type label in the breadcrumb, so renaming it here also renames the breadcrumb.
function municipio_companion_trelleborg_rename_posts_to_news($labels) {
    $news_labels = [
        'name' => 'Nyheter',
        'singular_name' => 'Nyhet',
        'menu_name' => 'Nyheter',
        'name_admin_bar' => 'Nyhet',
        'add_new' => 'Lägg till ny',
        'add_new_item' => 'Lägg till nyhet',
        'edit_item' => 'Redigera nyhet',
        'new_item' => 'Ny nyhet',
        'view_item' => 'Visa nyhet',
        'view_items' => 'Visa nyheter',
        'search_items' => 'Sök nyheter',
        'not_found' => 'Inga nyheter hittades.',
        'not_found_in_trash' => 'Inga nyheter hittades i papperskorgen.',
        'all_items' => 'Alla nyheter',
        'archives' => 'Nyhetsarkiv',
        'attributes' => 'Egenskaper för nyhet',
        'insert_into_item' => 'Infoga i nyhet',
        'uploaded_to_this_item' => 'Uppladdad till denna nyhet',
        'filter_items_list' => 'Filtrera nyhetslistan',
        'items_list_navigation' => 'Navigering för nyhetslistan',
        'items_list' => 'Nyhetslista',
        'item_published' => 'Nyheten publicerades.',
        'item_published_privately' => 'Nyheten publicerades privat.',
        'item_reverted_to_draft' => 'Nyheten återställdes till utkast.',
        'item_trashed' => 'Nyheten flyttades till papperskorgen.',
        'item_scheduled' => 'Nyheten schemalades.',
        'item_updated' => 'Nyheten uppdaterades.',
        'item_link' => 'Nyhetslänk',
        'item_link_description' => 'En länk till en nyhet.',
    ];

    foreach ($news_labels as $key => $label) {
        $labels->$key = $label;
    }

    return $labels;
}

add_filter('post_type_labels_post', 'municipio_companion_trelleborg_rename_posts_to_news');
