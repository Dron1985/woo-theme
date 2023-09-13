<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'four-card-section animation' ];
$anchor = (isset($args['anchor']) && !empty($args['anchor'])) ? 'id="'.$args['anchor'].'" data-anchor="'.$args['anchor'].'"' : ''; ?>
<section class="<?php echo apply_global_classes( $classes, $data ); ?>" <?php echo $anchor; ?>>
	<div class="four-card-bg">
		<?php if ( $data['use_video'] ) : ?>
			<video class="stope-last-frame" muted autoplay>
				<source src="<?php echo $data['video']; ?>" type="video/mp4">
				<?php _e( 'Your browser does not support the video tag.', 'woo-theme' ); ?>
			</video>
		<?php else : ?>
			<img src="<?php echo $data['image']; ?>" alt="image description">
		<?php endif; ?>
	</div>
	<div class="container">
		<div class="section-info static">
			<?php render( '<h2>', $data, 'title', '</h2>' ); ?>
			<?php render( '<p>', $data, 'text', '</p>' ); ?>
		</div>
	</div>
	<div class="four-card-items">
		<?php foreach ( $data['cards'] as $key => $val ) :
			$small = ( $key % 2 === 0 ) ? '' : 'small'; ?>
			<div class="four-card-item <?php echo $small; ?>">
				<div class="picture">
					<img src="<?php echo $val['image']; ?>" alt="image description">
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>