<?php

/**
 * Get Label for taxonomy.
 */
function get_label_for_taxonomy(string $singular_name = '', string $plural_name = ''): array {
  return [
    'name' => __($plural_name, 'woo-theme'),
    'singular_name' => __($singular_name, 'woo-theme'),
    'search_items' => __('Search ' . $plural_name, 'woo-theme'),
    'all_items' => __('All ' . $plural_name, 'woo-theme'),
    'parent_item' => __('Parent ' . $singular_name, 'woo-theme'),
    'parent_item_colon' => __('Parent ' . $singular_name, 'woo-theme'),
    'edit_item' => __('Edit ' . $singular_name, 'woo-theme'),
    'update_item' => __('Update ' . $singular_name, 'woo-theme'),
    'add_new_item' => __('Add New ' . $singular_name, 'woo-theme'),
    'new_item_name' => __('New ' . $singular_name . 'Name', 'woo-theme'),
    'menu_name' => __($plural_name, 'woo-theme'),
  ];
}

add_action('init', 'woo_theme_taxonomies_init', 0);
function woo_theme_taxonomies_init() {
    $taxonomies = array(
        'category_faqs' => [
            'labels' => get_label_for_taxonomy('Category', 'Categories'),
            'posts'  => ['faqs'],
        ],

        // Some else ...
    );

    foreach ($taxonomies as $taxonomy_name => $val ) {
        $args = array(
            'hierarchical'      => TRUE,
            'labels'            => $val['labels'],
            'public'            => TRUE,
            'show_ui'           => TRUE,
            'show_in_nav_menus' => TRUE,
            'show_admin_column' => TRUE,
            'query_var'         => FALSE,
            'rewrite'           => TRUE,
            'show_in_rest'      => TRUE,
        );
        register_taxonomy($taxonomy_name, $val['posts'], $args);
    }
}
