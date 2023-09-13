<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'packaging-section animation' ];
if(isset($data['table']) && !empty($data['table'])) {
	$classes[] = 'grey-bg';
}
?>
<?php if ( is_empty( $data, [ 'title' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<?php render( '<h3>', $data, 'title', '</h3>' ); ?>
			<?php render( '<div class="table-scrolling"><div class="holder dark-head">', $data, 'table', '</div></div>' ); ?>
			<?php if ( isset( $data['packages'] ) && is_array( $data['packages'] ) && count( $data['packages'] ) > 0 ): ?>
				<div class="packaging-items slick-slider">
					<?php foreach ( $data['packages'] as $item ): ?>
						<div class="packaging-item">
							<div class="picture">
								<?php render_image( '<span>', $item, 'icon', '</span>', 'large' ); ?>
							</div>
							<div class="text">
								<?php render( '<span class="title">', $item, 'title', '</span>' ); ?>
								<?php render( '<span class="size">', $item, 'size', '</span>' ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>