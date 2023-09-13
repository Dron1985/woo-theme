<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'more-products animation' ];
?>
<?php if ( is_empty( $data, [ 'product' ] ) ):
	$product = $data['product'];
    $feature_img = get_featured_img_info('extra_large', $product->ID);
    $image = (isset($data['custom_img']['sizes'])) ? $data['custom_img']['sizes']['extra_large'] : $feature_img['src'];
    $img_alt = (!empty($feature_img['alt'])) ? $feature_img['alt'] : get_the_title($product->ID); ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="more-products-card single">
				<a href="<?php echo get_the_permalink( $product ); ?>"></a>
                <?php if (!empty($image)) : ?>
                    <div class="more-products-img">
                        <img src="<?php echo $image; ?>" alt="<?php echo $img_alt; ?>">
                    </div>
                <?php endif; ?>
				<div class="more-products-text">
					<h2 class="more-ploduct-title"><?php echo $product->post_title; ?></h2>
                    <?php if (!empty($feature_img['src'])) : ?>
                        <div class="preview-img">
                            <img src="<?php echo $feature_img['src']; ?>" alt="<?php echo $img_alt; ?>">
                        </div>
                    <?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>