<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'icon-list-section animation' ];
?>
<?php if ( is_empty( $data, [ 'title', 'sub_text', 'description', 'button', 'items' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="icon-list-heading">
				<?php render( '<h2>', $data, 'title', '</h2>' ); ?>
				<div class="text">
					<?php render( '<p class="sub-text">', $data, 'sub_text', '</p>' );
					render( '', $data, 'description' ); ?>
				</div>
			</div>
			<div class="icon-list-rows">
				<?php foreach ( $data['items'] as $item ): ?>
					<div class="icon-list-row">
						<?php render_image( '<span class="icon">', $item, 'icon', '</span>' ); ?>
						<?php render( '<h4>', $item, 'title', '</h4>' );
						render( '<div class="text"><p>', $item, 'description', '</p></div>' ); ?>
					</div>
				<?php endforeach; ?>
			</div>
			<?php render( '<div class="buttons"><div class="buttons-holder centered">', $data, 'button', '</div></div>', 'link', 'btn small', '<span>', '</span>' ); ?>
		</div>
	</section>
<?php endif; ?>