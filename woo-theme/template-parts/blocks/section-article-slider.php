<?php
$data = get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'article-slider-wrap animation' ];
if ( isset( $data['gallery_slider'] ) && $data['gallery_slider'] == true ) {
	$classes = [ 'gallery-section' ];
}
if ( is_empty( $data, [ 'slider' ] ) ): ?>
	<div class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<?php if ( isset( $data['gallery_slider'] ) && $data['gallery_slider'] == true ): ?>
			<div class="gallery">
				<?php foreach ( $data['slider'] as $item ) {
					render_image( '<div class="gallery-picture">', $item, '', '</div>', 'full_hd', '' );
				} ?>
			</div>
		<?php else: ?>
			<div class="article-slider">
				<?php foreach ( $data['slider'] as $slide ) {
					render_image( '<div class="article-slide">', $slide, '', '</div>', 'extra_large' );
				} ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif;