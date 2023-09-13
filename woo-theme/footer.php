<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package woo-theme
 */

$fields = get_field('fields_woo', 'option');
$data = $fields['discount_fields'];
$coupon = WC()->cart->get_applied_coupons();
$count = (isset($data['count_item']) && !empty($data['count_item'])) ? $data['count_item'] : '';
if (isset($coupon[0])) {
    $text = 'Discount by coupon';
} else {
    $text = (isset($data['text_minicart']) && !empty($data['text_minicart'])) ? $data['text_minicart'] : '';
} ?>
    </main>

    <?php get_template_part('template-parts/global/section', 'footer');
    if (is_product()) :
        get_template_part('template-parts/global/product', 'popup');
    endif; ?>

    <?php if (is_shop()) :
        get_template_part('template-parts/global/shop', 'popup');
    endif; ?>

    <div class="modal-window cart" data-modal="cart">
        <div class="modal-overlay"></div>
        <div class="modal-outer">
            <button type="button" class="close-modal"></button>
            <div class="modal-inner-wrap">
                <div class="modal-inner jcf-scrollable">
                    <div class="cart-modal-title">
                        <h4>Your Cart</h4>
                        <div class="discount-tooltip-outer">
                            <?php if (isset($fields['use_discount']) && $fields['use_discount'] == true && !empty($text)) : ?>
                                <button type="button">i</button>
                                <div class="discount-tooltip">
                                    <h6><?php _e( 'Discount', 'woo-theme' ); ?></h6>
                                    <p><?php _e( $text, 'woo-theme' ); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="minicart-wrapper empty">
                        <div class="widget_shopping_cart_content"><?php woocommerce_mini_cart(); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php wp_footer(); ?>

</body>
</html>