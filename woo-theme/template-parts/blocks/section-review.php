<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'review-section animation' ];
$reverse = ( $data['reverse'] == true ) ? 'right-side-content' : '';
?>
<?php if ( is_empty( $data, [ 'items' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="slider-bg">
			<?php foreach ( $data['items'] as $item ):
                $img_desk = (isset($item['image']['sizes'])) ? $item['image']['sizes']['full_hd'] : '';
                $img_mob = (isset($item['mobile_image']['sizes'])) ? $item['mobile_image']['sizes']['full_hd'] : (!empty($img_desk) ? $img_desk : '');
                $img_alt = (isset($item['image']['sizes']) && !empty($item['image']['alt'])) ? $item['image']['alt'] : (isset($item['mobile_image']['sizes']) && !empty($item['mobile_image']['alt']) ? $item['mobile_image']['alt'] : '');
                if (!empty($img_desk) || !empty($img_mob)) : ?>
                    <div class="slide-bg">
                        <picture>
                            <?php if (!empty($img_desk)) : ?>
                                <source media="(min-width:1200px)" srcset="<?php echo $img_desk; ?>">
                            <?php endif; ?>
                            <img src="<?php echo $img_mob; ?>" alt="<?php echo $img_alt; ?>" data-no-lazy="1">
                        </picture>
                    </div>
			    <?php endif;
            endforeach; ?>
		</div>
		<div class="container">
			<div class="review-inner <?php echo $reverse; ?>">
				<div class="review-slider">
					<?php foreach ( $data['items'] as $item ): ?>
						<div class="review-slide">
							<?php render( '<h3>', $item, 'title', '</h3>' ); ?>
							<svg width="84" height="84" viewBox="0 0 84 84" fill="none"
							     xmlns="http://www.w3.org/2000/svg">
								<path
									d="M37.5245 19.412V3C13.4685 10.7887 2 29.7042 2 53.3486V82H29.6923V48.8979H5.35664C7.87412 31.6514 20.1818 22.4718 37.5245 19.412ZM46.4755 82H74.1678V48.8979H49.8322C52.3497 31.6514 64.6573 22.4718 82 19.412V3C57.9441 10.7887 46.4755 29.7042 46.4755 53.3486V82Z"
									stroke="#151B20" stroke-width="3"/>
							</svg>
							<?php render( '<p>', $item, 'review', '</p>' ); ?>
							<div class="author">
								<?php render( '<span>', $item, 'author', '</span> ' );
								render( ' <span class="author-position">', $item, 'position', '</span>' ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="review-slider-nav numbered"></div>
			</div>
		</div>
	</section>
<?php endif; ?>