<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'our-story animation' ];
?>
<?php if ( is_empty( $data, [ 'description', 'items' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="our-story-inner">
				<div class="section-info">
					<?php render( '<h2>', $data, 'title', '</h2>' );
					render( '', $data, 'description' ); ?>
				</div>
				<div class="story-slider">
					<?php foreach ( $data['items'] as $item ): ?>
						<div class="story-slide">
							<?php render_image( '<div class="story-slide-img">', $item, 'image', '</div>', 'large' ); ?>
							<div class="story-slide-text-holder">
								<div class="story-slide-text">
									<?php render( '<h3 class="h2">', $item, 'year', '</h3>' ); ?>
									<?php render( '<p>', $item, 'description', '</p>' ); ?>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<div class="story-slider-nav">
					<?php foreach ( $data['items'] as $item ): ?>
						<?php render( '<div class="story-nav-item">', $item, 'year', '<span></span></div>' ); ?>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>