<?php
/**
 * Single Product Thumbnails
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-thumbnails.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.5.1
 */

defined( 'ABSPATH' ) || exit;

// Note: `wc_get_gallery_image_html` was added in WC 3.3.2 and did not exist prior. This check protects against theme overrides being used on older versions of WC.
if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;

$attachment_ids = $product->get_gallery_image_ids(); //get_gallery_attachment_ids();

if ( $attachment_ids ) : ?>
    <div class="product-gallery-thumb">
        <?php foreach ( $attachment_ids as $attachment_id ) :
            $prod_img_thumb = wp_get_attachment_image_url( $attachment_id, 'shop_thumbnail' );
            $prod_img_alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
            $image_alt = (!empty($prod_img_alt)) ? $prod_img_alt : get_the_title($product->get_id()); ?>
            <div class="picture"><span><img src="<?php echo $prod_img_thumb; ?>" alt="<?php echo $image_alt; ?>"></span></div>
        <?php endforeach; ?>
    </div>
<?php endif;