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
while (have_posts()): the_post();
    if (!is_account_page() && !is_checkout() && !is_cart() && !is_order_received_page() || is_shop() || is_tax('product_cat')) :
        the_content();
    else :
        if (!is_user_logged_in() && is_account_page() || is_user_logged_in() && $_SERVER['REQUEST_URI'] === '/my-account/lost-password/') : ?>
            <div class="authorization-section indent-top-medium indent-bottom-medium">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php else:
            if (isset($_GET['show-reset-form']) || (isset($_GET['key']) && !is_order_received_page())) {
                $class = 'indent-bottom-medium reset-password-section';
            } else {
                $class = (is_cart() || (is_checkout() && !is_order_received_page()) || isset($_GET['reset-link-sent'])) ? 'indent-bottom-medium indent-top-medium' : 'indent-bottom-medium';
            } ?>
            <div class="<?php echo $class; ?>">
                <div class="container">
                    <?php the_content(); ?>
                </div>
            </div>
        <?php endif;
   endif;
endwhile;
get_footer();
