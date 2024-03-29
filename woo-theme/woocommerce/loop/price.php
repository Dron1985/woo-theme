<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;
$pack_sizes = $product->get_attribute( 'pa_pack-size' );
$sizes = (!empty($pack_sizes)) ? str_replace(',', ' or ', $pack_sizes) : ''; ?>

<div class="holder">
    <?php if ( $price_html = $product->get_price_html() ) : ?>
        <span class="price"><?php echo $price_html; ?></span>
    <?php endif; ?>
    <?php if (!empty($sizes)) : ?>
        <div class="pack-size">Pack size <span><?php echo $sizes .' lbs'; ?></span></div>
    <?php endif; ?>
</div>