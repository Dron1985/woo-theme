<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'almon-products animation' ];

/**
 * Top Products
 */
if ( isset( $data['hide_top_products'] ) && $data['hide_top_products'] == false ) {
	$top_products = [];
	foreach ( $data['top_products'] as $item ) {
        $image = get_featured_img_info('medium_large', $item);
		$top_products[] = [
			'id'        => $item,
			'permalink' => get_the_permalink( $item ),
            'image_url' => (!empty($image['src'])) ? $image['src'] : '',
            'image_alt' => (!empty($image['alt'])) ? $image['alt'] : get_the_title( $item ),
			'title'     => get_the_title( $item ),
			'excerpt'   => get_the_excerpt( $item )
		];
	}
}

/**
 * Slider Products
 */
if ( isset( $data['hide_slider_products'] ) && $data['hide_slider_products'] == false ) {
	$slider_products = [];
	foreach ( $data['slider_products'] as $item ) {
        $image = get_featured_img_info('medium_large', $item);
		$slider_products[] = [
			'id'        => $item,
			'permalink' => get_the_permalink( $item ),
			'image_url' => (!empty($image['src'])) ? $image['src'] : '',
            'image_alt' => (!empty($image['alt'])) ? $image['alt'] : get_the_title( $item ),
			'title'     => get_the_title( $item ),
			'excerpt'   => get_the_excerpt( $item )
		];
	}
}

if ( is_empty( $data, [ 'description' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<?php render( '<div class="section-info">', $data, 'description', '</div>' ); ?>
			<div class="round-card-list three-per-row">
				<?php if ( isset( $data['hide_slider_products'] ) && $data['hide_slider_products'] == false ):
					foreach ( $top_products as $key => $item ): ?>
						<div id="post-<?php echo $item['id']; ?>" class="round-card">
							<a href="<?php echo $item['permalink']; ?>"></a>
                            <?php if (!empty($item['image_url'])) : ?>
                                <div class="round-card-media">
                                    <img class="has-shadow" src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['image_alt']; ?>">
                                </div>
							<?php endif; ?>
                            <div class="round-card-info">
								<h4><?php echo $item['title']; ?></h4>
								<p><?php echo $item['excerpt']; ?></p>
							</div>
						</div>
					<?php endforeach;
				endif; ?>
			</div>
			<div class="round-card-slider">
				<?php if ( isset( $data['hide_slider_products'] ) && $data['hide_slider_products'] == false ):
					foreach ( $slider_products as $key => $item ): ?>
						<div id="post-<?php echo $item['id']; ?>" class="round-card">
							<a href="<?php echo $item['permalink']; ?>"></a>
                            <?php if (!empty($item['image_url'])) : ?>
                                <div class="round-card-media">
                                    <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['image_alt']; ?>">
                                </div>
                            <?php endif; ?>
							<div class="round-card-info">
								<h4><?php echo $item['title']; ?></h4>
								<p><?php echo $item['excerpt']; ?></p>
							</div>
						</div>
					<?php endforeach;
				endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>