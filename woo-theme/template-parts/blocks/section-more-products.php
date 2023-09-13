<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'more-products animation' ];

if ( is_empty( $data, [ 'products' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="more-products-list">
				<?php foreach ( $data['products'] as $item ):
					$image = get_featured_img_info('medium_large', $item);
                    $img_alt = (!empty($image['alt'])) ? $image['alt'] : get_the_title($item->ID);
                    ?>
					<div id="post-<?php echo $item->ID; ?>" class="more-products-card">
						<a href="<?php echo get_the_permalink( $item ); ?>"></a>
                        <?php if (!empty($image['src'])) : ?>
                            <div class="more-products-img">
                                <img src="<?php echo $image['src']; ?>" alt="<?php echo $img_alt; ?>">
                            </div>
						<?php endif; ?>
                        <div class="more-products-text">
							<h4 class="more-ploduct-title"><?php echo $item->post_title; ?></h4>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>