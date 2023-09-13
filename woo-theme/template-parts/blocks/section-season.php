<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes      = [ 'season-section animation' ];
$modal_window = $data['modal_window'];
?>

<?php if ( is_empty( $data, [ 'title', 'button', 'svg_icon', 'items' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="season-section-inner">
				<div class="section-info">
					<?php render( '<div class="section-info-bg">', $data, 'svg_icon', '</div>' );
					render( '<h2>', $data, 'title', '</h2>' );
					render( '<div class="buttons-holder centered"><a class="btn small has-border" href="#" data-modal-open="reports"><span>', $data, 'button', '</span></a></div>' ); ?>
				</div>
				<div class="almond-diagram">
					<?php foreach ( $data['items'] as $item ): ?>
						<div class="diagram-card">
							<div class="diagram-media">
								<?php render_image( '<div class="diagram-bg-holder">', $item, 'big_image', '</div>', 'large' );
								render_image( '', $item, 'small_image', '', 'large', 'transparent-decor' ); ?>
							</div>
							<div class="diagram-text">
								<?php render( '<h6>', $item, 'title', '</h6>' );
								render( '<p>', $item, 'description', '</p>' ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
<?php if ( is_empty( $modal_window, [ 'button', 'image', 'items' ] ) ): ?>
	<div class="modal-window" data-modal="reports">
		<div class="modal-overlay"></div>
		<div class="modal-outer">
			<button type="button" class="close-modal"></button>
			<div class="modal-inner-wrap">
				<div class="modal-inner jcf-scrollable">
					<div class="modal-text">
						<?php if ( isset( $modal_window['items'] ) && ! empty( $modal_window['items'] ) && is_array( $modal_window['items'] ) && count( $modal_window['items'] ) > 0 ):
							foreach ( $modal_window['items'] as $item ): ?>
								<div class="modal-text-card">
									<?php render( '<h4>', $item, 'link', '</h4>', 'link' );
									render( '<h4>', $item, 'title', '</h4>' );
									render( '<p>', $item, 'description', '</p>' ); ?>
								</div>
							<?php endforeach;
						endif;
						render( '<div class="buttons-holder">', $modal_window, 'button', '</div>', 'link', 'btn small', '<span>', '</span>' ); ?>
					</div>
					<?php render_image( '<div class="modal-img-holder">', $modal_window, 'image', '</div>', 'full_hd' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>