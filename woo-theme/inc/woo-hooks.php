<?php

/**
 * Enable Gutenberg editor for WooCommerce
 */
function j0e_activate_gutenberg_product( $can_edit, $post_type ) {
    if ( $post_type == 'product' ) {
        $can_edit = true;
    }
    return $can_edit;
}
add_filter( 'use_block_editor_for_post_type', 'j0e_activate_gutenberg_product', 10, 2 );

/**
 * enable taxonomy fields for woocommerce with gutenberg on
 */
function j0e_enable_taxonomy_rest( $args ) {
    $args['show_in_rest'] = true;
    return $args;
}
add_filter( 'woocommerce_taxonomy_args_product_cat', 'j0e_enable_taxonomy_rest' );

/**
 * Custom menu items in my-account page
 */
function custom_my_account_menu_items( $items ) {
    $items = array(
        'dashboard'         => __( 'Dashboard', 'woocommerce' ),
        'orders'            => __( 'Orders', 'woocommerce' ),
        //'downloads'       => __( 'Downloads', 'woocommerce' ),
        'edit-address'    => __( 'Addresses', 'woocommerce' ),
        'edit-account'      => __( 'Account Details', 'woocommerce' ),
        'customer-logout'   => __( 'Logout', 'woocommerce' ),
    );

    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );

/**
 * Remove the breadcrumbs
 */
add_action( 'init', 'woo_remove_wc_breadcrumbs' );
function woo_remove_wc_breadcrumbs() {
    remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
}

/* Single product settings*/

/**
 * Remove action woocommerce_single_product_summary for single product
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );


/**
 * Add label after title
 */
add_filter( 'woocommerce_single_product_summary', 'woo_label_price', 10 );
function woo_label_price() {
    global $product;
    $price = $product->get_regular_price();
    $pack_sizes = $product->get_attribute( 'pa_pack-size' );
    if (!empty($pack_sizes)) {
        $sizes = explode(',', $pack_sizes);
    }
    $cost = (isset($sizes[0])) ? $price/$sizes[0] : '';

    if (!empty($cost)) {
        echo '<p class="label-price">$'.number_format(round($cost,2), 2).'/lb <span>*Does not include shipping cost</span></p>';
    }
}

/**
 * add action woocommerce_after_add_to_cart_quantity for single product
 */
add_action( 'woocommerce_after_add_to_cart_quantity', 'woocommerce_template_single_price', 25 );
add_action( 'woocommerce_before_add_to_cart_quantity', 'woocommerce_template_choice', 25 );
function woocommerce_template_choice() {
    global $product;
    $pack_sizes = $product->get_attribute( 'pa_pack-size' );
     if (!empty($pack_sizes)) :
         $sizes = explode(',', $pack_sizes); ?>
         <div class="addition-choice">
             <p class="addition-choice__title"><?php esc_html_e( 'Available Options', 'woocommerce' ); ?></p>
             <?php foreach ($sizes as $size) : ?>
                 <div class="addition-choice__wrapper"><?php echo $size .' lbs'; ?></div>
             <?php endforeach; ?>
         </div>
    <?php endif;
}

/**
 * Remove single product tab
 */
add_filter( 'woocommerce_product_tabs', 'remove_description_tab', 11 );
function remove_description_tab( $tabs ) {
    unset( $tabs['description'] );
    unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );
}
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

/**
 * change image size for product thumbnail
 */
if ( ! function_exists( 'woocommerce_get_product_thumbnail' ) ) {
    function woocommerce_get_product_thumbnail( $size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0 ) {
        global $post;
        $image_size = apply_filters( 'single_product_archive_thumbnail_size', $size );

        if ( has_post_thumbnail() ) {
            $props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );

            return get_the_post_thumbnail( $post->ID, $image_size, array(
                'title'  => $props['title'],
                'alt'    => (!empty($props['alt'])) ? $props['alt'] : get_the_title($post->ID)
            ) );
        } elseif ( wc_placeholder_img_src() ) {
            return wc_placeholder_img( $image_size );
        }
    }
}

/**
 * Remove WooCommerce flexslider script & product gallery slider
 */

// disable flexslider js
function flex_dequeue_script() {
	wp_dequeue_script( 'flexslider' );
}
add_action( 'wp_print_scripts', 'flex_dequeue_script', 100 );

// disable zoom jquery js file
function zoom_dequeue_script() {
	wp_dequeue_script( 'zoom' );
}
add_action( 'wp_print_scripts', 'zoom_dequeue_script', 100 );

// disable photoswipe js file
function photoswipe_dequeue_script() {
	wp_dequeue_script( 'photoswipe-ui-default' );
}
add_action( 'wp_print_scripts', 'photoswipe_dequeue_script', 100 );

/**
 * Change WooCommerce Add to cart message with a checkout link.
 */
function custom_add_to_cart_message_html( $message, $products ) {

    $count = 0;
    $titles = array();
    foreach ( $products as $product_id => $qty ) {
        $titles[] = ( $qty > 1 ? absint( $qty ) . ' &times; ' : '' ) . sprintf( _x( '&ldquo;%s&rdquo;', 'Item name in quotes', 'woocommerce' ), strip_tags( get_the_title( $product_id ) ) );
        $count += $qty;
    }

    $titles     = array_filter( $titles );
    $added_text = sprintf( _n(
        '%s has been added to your cart. Thank you for shopping!', // Singular
        '%s have been added to your cart. Thank you for shopping!', // Plural
        $count, // Number of products added
        'woocommerce' // Textdomain
    ), wc_format_list_of_items( $titles ) );
    $message    = sprintf( '<a href="%s" class="button wc-forward"><span>%s</span></a> %s', esc_url( wc_get_checkout_url() ), esc_html__( 'Proceed to checkout', 'woocommerce' ), esc_html( $added_text ) );
    return $message;
}
add_filter( 'wc_add_to_cart_message_html', 'custom_add_to_cart_message_html', 10, 2 );

/**
 * remove actions mini-cart buttons View cart and Checkout
 */
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

/**
 * add span for text button View cart
 */
function my_woocommerce_widget_shopping_cart_button_view_cart() {
    echo '<a href="' . esc_url( wc_get_cart_url() ) . '" class="button wc-forward wp-element-button"><span>' . esc_html__( 'View cart', 'woocommerce' ) . '</span></a>';
}

/**
 * add span for text button Checkout
 */
function my_woocommerce_widget_shopping_cart_proceed_to_checkout() {
    echo '<a href="' . esc_url( wc_get_checkout_url() ) . '" class="button checkout wc-forward wp-element-button"><span>' . esc_html__( 'Checkout', 'woocommerce' ) . '</span></a>';
}

add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );
//add_action( 'woocommerce_widget_shopping_cart_buttons', 'my_woocommerce_widget_shopping_cart_button_view_cart', 10 );

/**
 * calculate additional discount cort/minicart/checkout
 */
function action_woocommerce_cart_calculate_fees( $cart ) {
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return;

    $fields = get_field('fields_woo', 'option');
    $data = $fields['discount_fields'];
    $percentage = (isset($data['discount']) && !empty($data['discount'])) ? $data['discount'] : '';
    $count = (isset($data['count_item']) && !empty($data['count_item'])) ? $data['count_item'] : '';

    if (isset($fields['use_discount']) && $fields['use_discount'] == true && !empty($count) && !empty($percentage)) {
        $count_items = WC()->cart->get_cart_contents_count();
        $coupon = WC()->cart->get_applied_coupons();

        // Greater than
        if ( $count_items >= $count && !isset($coupon[0]) ) {
            // Get subtotal
            $subtotal = $cart->subtotal;

            // Calculate
            $discount = ( $subtotal / 100 ) * $percentage;

            // Give % discount on the subtotal
            $cart->add_fee( sprintf( __( 'Discount', 'woocommerce'), $percentage), - $discount );
        }

    }
}
add_action( 'woocommerce_cart_calculate_fees', 'action_woocommerce_cart_calculate_fees', 10, 1 );


/**
 * change subtotal for mini-cart
 */
function woocommerce_widget_shopping_cart_subtotal() {
    $fields = get_field('fields_woo', 'option');
    $data = $fields['discount_fields'];
    $count = (isset($data['count_item']) && !empty($data['count_item'])) ? $data['count_item'] : '';
    $text = (isset($data['text_minicart']) && !empty($data['text_minicart'])) ? $data['text_minicart'] : '';
    $coupons = WC()->cart->get_applied_coupons();
    if (!empty($coupons)) {
        foreach($coupons as $key => $value) {
            $coupon = $value;
        }

        global $woocommerce;
        $coupon_arr = new WC_Coupon($coupon);
        $type = (isset($coupon_arr->discount_type ) && $coupon_arr->discount_type == 'percent') ? '%' : '$';
        $text = (isset($coupon) && !empty($text)) ? 'Used coupon "'.$coupon.'" with discount '.$coupon_arr->amount.$type : '';
    }

    foreach( WC()->session->get('shipping_for_package_0')['rates'] as $method_id => $rate ){
        if( WC()->session->get('chosen_shipping_methods')[0] == $method_id ){
            $rate_label = $rate->label; // The shipping method label name
            $rate_cost_excl_tax = floatval($rate->cost); // The cost excluding tax
            // The taxes cost
            $rate_taxes = 0;
            foreach ($rate->taxes as $rate_tax)
                $rate_taxes += floatval($rate_tax);
            // The cost including tax
            $rate_cost_incl_tax = $rate_cost_excl_tax + $rate_taxes;
            break;
        }
    }

    $cart_items = WC()->cart->get_cart_contents_count();
    if ( $cart_items >= $count && isset($fields['use_discount']) && $fields['use_discount'] == true || !empty($coupons)) {
        echo __($text, 'woo-theme' ) . '<s>'.WC()->cart->get_cart_subtotal().'</s>';
    }
    $cart_total = WC()->cart->get_total('');
    $total = (isset($rate_cost_incl_tax) && !empty($rate_cost_incl_tax)) ? $cart_total - $rate_cost_incl_tax : $cart_total; ?>
    <p class="woocommerce-mini-cart__total total">
        <strong><?php _e( 'Subtotal:' ); ?></strong>
        <span class="woocommerce-Price-amount amount">
			<span class="woocommerce-Price-currencySymbol">
                <span class="woocommerce-Price-amount amount">
                    <bdi><span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span><?php echo number_format($total, 2); ?></bdi>
                </span>
            </span>
		</span>
    </p>
    <?php
}

/**
 * Add plus minus quantity to minicart
 */
add_filter( 'woocommerce_widget_cart_item_quantity', 'add_minicart_quantity_fields', 10, 3 );
function add_minicart_quantity_fields( $html, $cart_item, $cart_item_key ) {
    $product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $cart_item['data'] ), $cart_item, $cart_item_key );

    return woocommerce_quantity_input( array( 'input_value' => $cart_item['quantity'] ), $cart_item['data'], false );
}

add_action( 'woocommerce_after_quantity_input_field', 'bbloomer_display_quantity_plus' );
function bbloomer_display_quantity_plus() {
    if (!is_product() && !is_cart() && !is_checkout()) {
        echo '<span class="quantity-button quantity-up"><span class="plus"></span></span>';
    }
}

add_action( 'woocommerce_before_quantity_input_field', 'bbloomer_display_quantity_minus' );
function bbloomer_display_quantity_minus() {
    if (!is_product() && !is_cart() && !is_checkout()) {
        echo '<span class="quantity-button quantity-down"><span class="minuse"></span></span>';
    }
}

/**
 * enqueue custom script for change ajax qty in mini-cart
 */
function enqueue_cart_qty_ajax() {
    wp_register_script( 'my_cart_qty-ajax-js', get_template_directory_uri() . '/inc/js/custom-mini-cart.js', array( 'jquery' ), '', true );
    wp_localize_script( 'my_cart_qty-ajax-js', 'cart_qty_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_script( 'my_cart_qty-ajax-js' );

}
add_action('wp_enqueue_scripts', 'enqueue_cart_qty_ajax');

function ajax_my_cart_qty() {

    // Set item key as the hash found in input.qty's name
    $cart_item_key = $_POST['hash'];

    // Get the array of values owned by the product we're updating
    $threeball_product_values = WC()->cart->get_cart_item( $cart_item_key );

    // Get the quantity of the item in the cart
    $threeball_product_quantity = apply_filters( 'woocommerce_stock_amount_cart_item', apply_filters( 'woocommerce_stock_amount', preg_replace( "/[^0-9\.]/", '', filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT)) ), $cart_item_key );

    // Update cart validation
    $passed_validation  = apply_filters( 'woocommerce_update_cart_validation', true, $cart_item_key, $threeball_product_values, $threeball_product_quantity );

    // Update the quantity of the item in the cart
    if ( $passed_validation ) {
        WC()->cart->set_quantity( $cart_item_key, $threeball_product_quantity, true );
    }

    //ob_start();
    echo wc_get_template( 'cart/mini-cart.php' );
    //$return['content'] = ob_get_contents();
    //ob_clean();

    //wp_send_json($return);
    //do_action( 'woocommerce_set_cart_cookies', TRUE );

    //WC_AJAX::get_refreshed_fragments();
    die();

}
add_action('wp_ajax_my_cart_qty', 'ajax_my_cart_qty');
add_action('wp_ajax_nopriv_my_cart_qty', 'ajax_my_cart_qty');


//add_filter( 'woocommerce_add_to_cart_fragments', 'wc_mini_cart_ajax_refresh' );
function wc_mini_cart_ajax_refresh( $fragments ){
    //Refreshing cart subtotal
    ob_start();
    //echo  woocommerce_mini_cart();

    $fragments['cart-render'] = ob_get_clean();

    return $fragments;
}

/**
 * Add shipping info
 */

add_action('woocommerce_widget_shopping_cart_before_buttons','shipping_info');
function shipping_info() {
    $data = get_field('fields_woo', 'option');
    if (isset($data['minicart_info']) && !empty($data['minicart_info'])) {
        if (isset($data['minicart_info']['shipping_title']) && !empty($data['minicart_info']['shipping_title'])) {
            echo '<p class="shipping-title">'.$data['minicart_info']['shipping_title'].'</p>';
        }

        if (isset($data['minicart_info']['description']) && !empty($data['minicart_info']['description'])) {
            echo '<p class="shipping-description">'.$data['minicart_info']['description'].'</p>';
        }

        if (isset($data['minicart_info']['info']) && !empty($data['minicart_info']['info'])) {
            echo '<ul class="shipping-disclaimer">';
            foreach ($data['minicart_info']['info'] as $info) {
                echo '<li>'.$info['text'].'</li>';
            }
            echo '</ul>';
        }
    }
}

/**
 * remove actions woocommerce_result_count shop page
 */
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

/**
 * get product custom icons
 */
function get_product_icons() {
    $icons = get_field('product_icons', get_the_ID());
    if (!empty($icons)) {
        echo ' <span class="icon-feature">';
        foreach ($icons as $icon) {
            echo '<span>';
            get_template_part('template-parts/svg/icon', 'product', ['type' => $icon['type']]);
            echo '</span>';
        }
        echo '</span>';
    }
}

/**
 * reorder actions for product cart
 */
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
add_action( 'woocommerce_before_shop_loop_item_title', 'get_product_icons', 11 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 11 );

/**
 * change actions taxonomy_archive_description and product_archive_description for show content in page shop/product category
 */
remove_action( 'woocommerce_archive_description','woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_archive_description','woocommerce_product_archive_description', 10 );

function new_woocommerce_product_archive_description() {
    // Don't display the description on search results page.
    if ( is_search() ) {
        return;
    }

    if ( (is_post_type_archive( 'product' ) || is_tax('product_cat')) && in_array( absint( get_query_var( 'paged' ) ), array( 0, 1 ), true ) ) {
        $shop_page = get_post( wc_get_page_id( 'shop' ) );
        if ( $shop_page ) {
            if ( $shop_page->post_content ) {
                echo apply_filters( 'the_content', $shop_page->post_content ); // WPCS: XSS ok.
            }
        }
    }
}
add_action( 'woocommerce_archive_description','new_woocommerce_product_archive_description', 10 );


/**
 * change product title for shop page
 */
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'wps_change_products_title', 10);
function wps_change_products_title() {
    echo '<h2 class="woocommerce-loop-product__title"><a href="'.get_the_permalink().'">'. get_the_title() . '</a></h2>';
}

/**
 * change product price for shop/category page
 */
function change_product_price_html( $price_html, $product ) {
    if (is_single($product->get_id()))
        return $price_html;

    if (is_shop() || is_tax('product_cat') || wp_doing_ajax()) {
        $price = $product->get_regular_price();
        $pack_sizes = $product->get_attribute( 'pa_pack-size' );
        if (!empty($pack_sizes)) {
            $sizes = explode(',', $pack_sizes);
        }
        $cost = (isset($sizes[0])) ? $price/$sizes[0] : '';

        if (!empty($cost)) {
            $price_html = '<p class="label-price">'.wc_price(round($cost, 2)).'/lb </p>';
        }
    }

    return $price_html;
}
add_filter( 'woocommerce_get_price_html', 'change_product_price_html', 10, 2 );


/**
 * custom change available methods for shipping in checkout
 */
function show_shipping_product_type( $available_methods ) {
    global $woocommerce;

    if ( $available_methods ) {
        foreach ($available_methods as $key => $method) {
            unset($available_methods['ups|ups_ground']);
            unset($available_methods['stamps_com|usps_media_mail']);
            unset($available_methods['stamps_com|usps_first_class_mail']);
            unset($available_methods['stamps_com|usps_ground_advantage']);
            unset($available_methods['stamps_com|usps_parcel_select']);
            unset($available_methods['stamps_com|usps_priority_mail']);
            unset($available_methods['stamps_com|usps_priority_mail_express']);
            unset($available_methods['stamps_com|usps_first_class_mail_international']);
            unset($available_methods['stamps_com|usps_priority_mail_international']);
            unset($available_methods['stamps_com|usps_priority_mail_express_international']);
        }
    }
    return $available_methods;
}
add_filter( 'woocommerce_package_rates', 'show_shipping_product_type', 10,9);


/**
 * custom button add to cart
 */
//add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
//add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart() {
    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));
        echo wp_send_json($data);
    }

    wp_die();
}

/**
 * add min length for field phone number
 */
add_filter( 'woocommerce_checkout_fields', 'bbloomer_checkout_fields_custom_attributes', 9999 );
function bbloomer_checkout_fields_custom_attributes( $fields ) {
    $fields['billing']['billing_postcode']['custom_attributes']['maxlength'] = 10;
    $fields['billing']['billing_phone']['custom_attributes']['maxlength'] = 15;
    return $fields;
}

/**
 * change product price by change quantity
 */
add_action( 'woocommerce_single_product_summary', 'woocommerce_total_product_price', 10 );
function woocommerce_total_product_price() {
    global $woocommerce, $product; ?>
    <script>
        jQuery(function($){
            var price = <?php echo $product->get_price(); ?>,
                currency = '<span class="woocommerce-Price-currencySymbol"><?php echo get_woocommerce_currency_symbol(); ?></span>';

            window.addEventListener('load', function () {
                if ($('.qty').length && $('.qty').val() > 1 ) {
                    var product_total = parseFloat(price * $('.qty').val());
                    $('.woocommerce-Price-amount bdi').html(currency + product_total.toFixed(2));
                }
            })

            $('.qty').on('change',function(){
                if (!(this.value < 1)) {
                    var product_total = parseFloat(price * this.value);
                    $('.woocommerce-Price-amount bdi').html(currency + product_total.toFixed(2));
                }
            });
        });
    </script>
    <?php
}

/**
 * change hint reset password
 */
add_filter( 'password_hint', function( $hint ){
    return __( 'Hint: *The password should be at least nine characters long and should include at least one upper and lowercase letter, a number and a symbol.' );
} );

/**
 * add custom class for link remove coupon cart/checkout page
 */
function filter_woocommerce_cart_totals_coupon_html( $coupon_html, $coupon, $discount_amount_html ) {
    // Change text
    $coupon_html = $discount_amount_html . ' <a href="' . esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url() ) ) . '" class="woocommerce-remove-coupon btn_remove" data-coupon="' . esc_attr( $coupon->get_code() ) . '">' . __( '[Remove]', 'woocommerce' ) . '</a>';

    return $coupon_html;
}
add_filter( 'woocommerce_cart_totals_coupon_html', 'filter_woocommerce_cart_totals_coupon_html', 10, 3 );


function mytheme_enqueue_styles(){
    // Check if ‘wc-cart-fragments’ script is already enqueued or registered
    if ( !wp_script_is( 'wc-cart-fragments', 'enqueued' ) && wp_script_is( 'wc-cart-fragments', 'registered' ) ) {
        // Enqueue the ‘wc-cart-fragments’ script
        wp_enqueue_script( 'wc-cart-fragments' );
    }
}
add_action('wp_enqueue_scripts', 'mytheme_enqueue_styles');


/**
 * add confirm password field
 */
//add field confirm password on form registration
add_action( 'woocommerce_register_form', 'wc_register_form_password_repeat' );
function wc_register_form_password_repeat() {
    ?>
    <p class="form-row form-row-wide">
        <input type="password" class="input-text" name="password2" id="reg_password2" placeholder="Confirm password*" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
    </p>
    <?php
}

//add validate fields confirm password and password on form registration
add_filter('woocommerce_registration_errors', 'registration_errors_validation', 10,3);
function registration_errors_validation($reg_errors, $sanitized_user_login, $user_email) {
    global $woocommerce;
    extract( $_POST );
    if ( strcmp( $password, $password2 ) !== 0 ) {
        return new WP_Error( 'registration-error', __( 'Passwords do not match.', 'woocommerce' ) );
    }
    return $reg_errors;
}

/**
 * add fields First name and Last name on register form
 */
add_action( 'woocommerce_register_form_start', 'woocom_extra_register_fields' );
function woocom_extra_register_fields() { ?>
    <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" placeholder="First name*" value="<?php if (!empty($_POST['billing_first_name'])) esc_attr_e($_POST['billing_first_name']); ?>" />
    </p>

    <p class="form-row form-row-wide">
        <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" placeholder="Last name*" value="<?php if (!empty($_POST['billing_last_name'])) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
    </p>
    <?php
}

/**
 * validate fields First name and Last name on register form
 */
add_action('woocommerce_register_post', 'woocom_validate_extra_register_fields', 10, 3);
function woocom_validate_extra_register_fields( $username, $email, $validation_errors ){
    if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name']) ) {
        $validation_errors->add('billing_first_name_error', __('First Name is required!', 'woocommerce'));
    }

    if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name']) ) {
        $validation_errors->add('billing_last_name_error', __('Last Name is required!', 'woocommerce'));
    }

    return $validation_errors;
}

/**
 * save fields First name and Last name on register form
 */
add_action('woocommerce_created_customer', 'woocom_save_extra_register_fields');
function woocom_save_extra_register_fields($customer_id) {
    if (isset($_POST['billing_first_name'])) {
        update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
    }

    if (isset($_POST['billing_last_name'])) {
        update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
    }
}


/**
 * Rename "completed" Order Status to "shipped"
 */
add_filter( 'wc_order_statuses', 'rename_completed_order_status' );
function rename_completed_order_status( $statuses ) {
    $statuses['wc-completed'] = 'Shipped';
    return $statuses;
}

add_filter( 'woocommerce_register_shop_order_post_statuses', 'rename_completed_order_status_counter' );
function rename_completed_order_status_counter( $statuses ) {
    $statuses['wc-completed']['label_count'] = _n_noop( 'Shipped <span class="count">(%s)</span>', 'Shipped <span class="count">(%s)</span>', 'woocommerce' );
    return $statuses;
}