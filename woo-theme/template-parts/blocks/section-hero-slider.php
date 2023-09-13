<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = ( is_front_page() ) ? [ 'hero-section home animation' ] : [ 'hero-section animation' ];
if ( isset( $data['simple_hero'] ) && $data['simple_hero'] == true ) {
	$classes = [ 'simple-hero' ];
}
$bg_class = isset( $data['has_dark_overlay'] ) && $data['has_dark_overlay'] ? 'hero-section-bg has-dark-overlay' : 'hero-section-bg';

if ( is_empty( $data, [ 'items' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<?php if ( isset( $data['single_image'] ) && $data['single_image'] == true ): ?>
			<div class="hero-section-outer">
                <?php if (isset($data['image']['sizes'])) :
                    $img_mob = (isset($data['mob_image']['sizes'])) ? $data['mob_image']['sizes']['full_hd'] : ''; ?>
                    <div class="<?php echo $bg_class; ?>">
                        <?php if (isset($data['image']['sizes'])) : ?>
                            <picture>
                                <?php if (!empty($img_mob)) : ?>
                                    <source media="(max-width:768px)" srcset="<?php echo $img_mob; ?>">
                                <?php endif; ?>
                                <img src="<?php echo $data['image']['sizes']['full_hd']; ?>" alt="<?php echo $data['image']['alt']; ?>" data-no-lazy="1">
                            </picture>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
				<div class="container">
					<div class="hero-section-inner">
						<div class="hero-info">
							<?php render( '<h1>', $data, 'title', '</h1>' );
							render( '<p>', $data, 'description', '</p>' );
							render( '<div class="buttons-holder centered">', $data, 'button', '</div>', 'link', 'btn', '<span>', '</span>' ); ?>
						</div>
					</div>
				</div>
			</div>
		<?php elseif ( isset( $data['simple_hero'] ) && $data['simple_hero'] != true ): ?>
			<div class="hero-section-inner">
				<div class="hero-slider">
					<?php foreach ( $data['items'] as $key => $item ): ?>
						<div class="hero-slide">
							<?php if ( $item['choice'] == 'color' ): ?>
								<div class="hero-section-bg" style="background-color: <?php echo $item['background_color']; ?>">
									<?php
									render_image( '<div class="decor decor-left">', $item, 'left_image', '</div>', 'large' );
									render_image( '<div class="decor decor-right">', $item, 'right_image', '</div>', 'large' ); ?>
								</div>
							<?php elseif ( $item['choice'] == 'image' ):
                                $img_mob = (isset($item['mob_image']['sizes'])) ? $item['mob_image']['sizes']['full_hd'] : ''; ?>
								<div class="hero-section-bg has-<?php echo $item['choice_overlay']; ?>-overlay">
                                    <?php if (isset($item['image']['sizes'])) : ?>
                                        <picture>
                                            <?php if (!empty($img_mob)) : ?>
                                                <source media="(max-width:768px)" srcset="<?php echo $img_mob; ?>">
                                            <?php endif; ?>
                                            <img src="<?php echo $item['image']['sizes']['full_hd']; ?>" alt="<?php echo $item['image']['alt']; ?>" data-no-lazy="1">
                                        </picture>
                                    <?php endif; ?>
                                </div>
							<?php else: ?>
								<?php if ( isset( $item['video']['url'] ) && ! empty( $item['video']['url'] ) ): ?>
									<div class="hero-section-bg">
										<video class="video-bg" muted autoplay loop>
											<source src="<?php echo $item['video']['url']; ?>" type="video/mp4">
											<?php echo __('Your browser does not support the video tag.','woo-theme'); ?>
										</video>
									</div>
								<?php endif; ?>
							<?php endif; ?>
							<div class="container">
								<div class="hero-info">
									<?php if ( $key == 0 ) {
										render( '<h1>', $item, 'title', '</h1>', 'text' );
									} else {
										render( '<h2 class="h1">', $item, 'title', '</h2>', 'text' );
									}
									render( '<p>', $item, 'description', '</p>', 'text' ); ?>
									<div class="buttons-holder centered">
										<?php render( '', $item, 'button', '', 'link', 'btn', '<span>', '</span>' ); ?>
										<?php render( '', $item, 'button_second', '', 'link', 'btn has-border', '<span>', '</span>' ); ?>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="hero-slider-nav numbered"></div>
			</div>
		<?php elseif ( isset( $data['simple_hero'] ) && $data['simple_hero'] == true ): ?>
			<div class="container">
				<div class="section-info">
					<?php render( '<h1>', $data, 'title', '</h1>', 'text' );
					render( '<p>', $data, 'description', '</p>', 'text' ); ?>
					<div class="buttons">
						<div class="buttons-holder centered">
							<?php render( '', $data, 'button', '', 'link', 'btn', '<span>', '</span>' ); ?>
							<?php if ( isset( $data['download']['url'] ) && ! empty( $data['download']['url'] ) ): ?>
								<a href="<?php echo $data['download']['url']; ?>" class="btn" target="_blank"><span><?php echo __('Download','woo-theme'); ?></span></a>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</section>
<?php endif;