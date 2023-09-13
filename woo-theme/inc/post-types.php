<?php

/**
 * Get labels array.
 */
function woo_get_labels(string $singular_name = '', string $plural_name = ''): array {
  return [
    'name' => __($plural_name, 'woo-theme'),
    'singular_name' => __($plural_name, 'woo-theme'),
    'add_new' => __('Add New ' . $singular_name, 'woo-theme'),
    'add_new_item' => __('Add New ' . $singular_name, 'woo-theme'),
    'edit_item' => __('Edit ' . $singular_name, 'woo-theme'),
    'new_item' => __('New ' . $singular_name, 'woo-theme'),
    'all_items' => __('All ' . $plural_name, 'woo-theme'),
    'view_item' => __('View ' . $singular_name, 'woo-theme'),
    'search_items' => __('Search ' . $plural_name, 'woo-theme'),
    'not_found' => __('No ' . $singular_name . ' found', 'woo-theme'),
    'not_found_in_trash' => __('No ' . $singular_name . ' found in Trash', 'woo-theme'),
    'parent_item_colon' => '',
    'menu_name' => __($plural_name, 'woo-theme'),
  ];
}

add_action('init', 'woo_theme_post_types_init');
function woo_theme_post_types_init() {
/*	$args = [
		'labels'             => woo_get_labels( 'Custom post', 'Custom posts' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'capability_type'    => 'page',
		'rewrite'            => [ 'with_front' => false, 'slug' => '' ],
		'has_archive'        => 'custom-posts',
		'hierarchical'       => false,
		'menu_position'      => 21,
		'supports'           => [ 'title', 'excerpt', 'editor', 'thumbnail' ],
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
	];
	register_post_type( 'custom-post', $args );*/

	$args = [
		'labels'             => woo_get_labels( 'Wholesale Product', 'Wholesale Products' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'show_in_rest'       => true,
		'capability_type'    => 'page',
		'rewrite'            => [ 'with_front' => false, 'slug' => 'wholesale-products' ],
		'has_archive'        => 'wholesale-products',
		'hierarchical'       => false,
		'menu_position'      => 21,
		'supports'           => [ 'title', 'excerpt', 'editor', 'thumbnail' ],
		'show_in_nav_menus'  => true,
		'show_in_admin_bar'  => true,
	];
	register_post_type( 'wholesale-products', $args );

    $args = array(
        'labels'             => woo_get_labels('FAQs', 'FAQs'),
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => false,
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 21,
        "menu_icon"          => 'dashicons-testimonial',
        'supports'           => ['title', 'editor'],
        'taxonomies'         => ['category_faqs'],
        'show_in_rest'       => true,
        'show_in_nav_menus'  => true,
        'show_in_admin_bar'  => true,
        'rewrite'            => false,
    );
    register_post_type('faqs', $args);

	//Someone else...
}
