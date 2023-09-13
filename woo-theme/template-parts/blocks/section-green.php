<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'green-section animation' ];
?>
<?php if ( is_empty( $data, [ 'background', 'title', 'description', 'button' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="green-section-inner">
			<div class="green-section-bg">
				<?php render( '', $data, 'background', '', 'img' ); ?>
			</div>
			<div class="container">
				<div class="section-info <?php echo $data['section_width']; ?>">
					<?php render( '<h2 class="h3">', $data, 'title', '</h2>', 'text' );
					render( '<p>', $data, 'description', '</p>', 'text' );
					render( '<div class="buttons-holder centered">', $data, 'button', '</div>', 'link', 'btn white small standart-size-padding', '<span>', '</span>' ); ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>