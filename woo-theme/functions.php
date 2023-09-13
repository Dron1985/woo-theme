<?php
/**
 * woo-theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package woo-theme
 */

if (!function_exists('woo_theme_setup')) :
  /**
   * Sets up theme defaults and registers support for various WordPress features.
   *
   * Note that this function is hooked into the after_setup_theme hook, which
   * runs before the init hook. The init hook is too late for some features, such
   * as indicating support for post thumbnails.
   */
  function woo_theme_setup() {
    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support('title-tag');

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus([
      'menu-1' => esc_html__('Primary', 'woo-theme'),
    ]);

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support('html5', [
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
    ]);

    /**
     * Add new image sizes
     *
     */
    add_image_size('full_hd', 1920, 99999);
    add_image_size('extra_large', 1550, 99999);

    /**
     * WooCommerce
     */
      add_theme_support( 'woocommerce' );
  }
endif;
add_action('after_setup_theme', 'woo_theme_setup');

/**
 * Include all files from the includes directory.
 * Custom template tags for this theme
 * Include post types
 * Include taxonomies
 * Include Ajax File
 * Include Render
 * Include Blocks
 * Functions which enhance the theme by hooking into WordPress.
 */
$includes_path = dirname(__FILE__) . '/inc/*.php';
foreach (glob($includes_path) as $filename) {
  if (basename($filename) != "integration-greenhouse.php") {
    require_once dirname(__FILE__) . '/inc/' . basename($filename);
  }
}

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/classes/walker_main_menu.php';
require get_template_directory() . '/inc/classes/walker_main_submenu.php';
require get_template_directory() . '/inc/classes/walker_footer_menu.php';