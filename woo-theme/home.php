<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package woo-theme
 */

get_header();
$page_for_posts = get_option( 'page_for_posts' );
$page_for_posts_obj = get_post( $page_for_posts );
echo apply_filters( 'the_content', $page_for_posts_obj->post_content );
get_footer();