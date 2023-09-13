<?php
/**
 * Enqueue scripts and styles.
 */

//Admin style for Gutenberg
add_action('admin_enqueue_scripts', 'load_admin_style');
function load_admin_style() {
    wp_enqueue_style('admin_css', get_template_directory_uri() . '/assets/css/admin.css', FALSE, '1.0.0');
    wp_enqueue_script('admin-preview', get_template_directory_uri() . '/assets/js/admin-preview.js');
}

add_action('wp_enqueue_scripts', 'woo_theme_enqueue_styles');
function woo_theme_enqueue_styles() {
    wp_enqueue_style('woo_theme-global-style', woo_theme_get_css_uri('style'));
}

add_action('wp_enqueue_scripts', 'woo_theme_enqueue_scripts', 0);
function woo_theme_enqueue_scripts() {
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/inc/js/jquery.min.js', array(), '3.2.1', false);
    wp_enqueue_script('jquery');

    $data = get_acf_field_gutenberg(get_the_ID(), 'contact-us');
	if(isset($data['display_map']) && !empty($data['display_map'])) {
		$key = (get_field('google_api_key', 'option')) ? get_field('google_api_key', 'option') : 'AIzaSyBmqAKQbjpja1DzfaO67vNC1lN1cN5hHzY';
		wp_enqueue_script('google-maps-script', 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=Function.prototype&key='.$key, array('jquery'), 20200325, true);
	}

    wp_enqueue_script('global', woo_theme_get_js_uri('global'), ['jquery'], get_file_version(woo_theme_get_js_path('global')), TRUE);
    wp_localize_script( 'global', 'ajaxvars', ['ajaxurl' => admin_url('admin-ajax.php')]);

    if (is_home() || is_search() || is_page() || is_shop()){
        $acf_block = get_acf_field_gutenberg(get_the_ID(), 'section-listing-faqs');
        if (is_home()) {
            $params = array(
                'post_type' => 'post',
                'action' => 'load_news',
                'filter_nonce_token' => wp_create_nonce('posts_filter_nonce')
            );
        } elseif (is_page() && !empty($acf_block)) {
            $params = array(
                'post_type' => 'faqs',
                'action' => 'load_faq',
                'filter_nonce_token' => wp_create_nonce('faq_filter_nonce')
            );
        } elseif (is_shop()) {
            $params = array(
                'post_type' => 'product',
                'action' => 'load_products',
                //'filter_nonce_token' => wp_create_nonce('product_filter_nonce')
            );
        }

        if (is_home() || is_search() || is_shop() || (is_page() && !empty($acf_block))) {
            wp_register_script('filters',get_template_directory_uri() . '/inc/js/filters.js', array('jquery'), '',true);
            wp_enqueue_script('filters');
            wp_localize_script('filters', 'vars', array('ajax' => $params));
        }
    }
}

/**
 * include custom style for admin menu
 */
function add_custom_stylesheet() {
    wp_register_style('custom-style', get_template_directory_uri() . '/inc/css/custom-menu.css');
    wp_enqueue_style('custom-style');
}
add_action('admin_enqueue_scripts', 'add_custom_stylesheet');