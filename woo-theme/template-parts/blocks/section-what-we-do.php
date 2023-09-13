<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'what-we-do animation' ];
?>
<?php if ( is_empty( $data, [ 'description', 'items' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="what-we-do-inner">
				<div class="section-info">
					<?php render( '<h2>', $data, 'title', '</h2>' );
					render( '', $data, 'description' ); ?>
				</div>
				<div class="cycle">
					<?php foreach ( $data['items'] as $key => $item ):
						$reverse = ( $key % 2 ) ? 'reversed' : ''; ?>
						<div class="cycle-item <?php echo $reverse; ?>">
							<?php render_image( '<div class="cycle-img-holder">', $item, 'image', '</div>' ); ?>
							<?php render( '<div class="cycle-item-text-inner"><div class="cycle-item-text">', $item, 'description', '</div></div>' ); ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>