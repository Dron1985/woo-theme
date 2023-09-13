<?php
$data = get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'proof-numbers-section animation' ];
if ( is_empty( $data, [ 'title', 'description', 'rows' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="section-info">
				<?php render( '<h2>', $data, 'title', '</h2>' );
				render( '<p>', $data, 'description', '</p>' ); ?>
			</div>
		</div>
		<?php if ( isset( $data['rows'] ) && is_array( $data['rows'] ) && count( $data['rows'] ) > 0 ): ?>
			<div class="proof-numbers-slider">
				<?php foreach ( $data['rows'] as $item ): ?>
					<div class="proof-numbers-row">
						<?php if ( isset( $item['items'] ) && is_array( $item['items'] ) && count( $item['items'] ) > 0 ):
							foreach ( $item['items'] as $value ) : ?>
								<div class="proof-number">
									<?php render( '<span class="number">', $value, 'number', '</span>' );
									render( '<span class="text">', $value, 'text', '</span>' ); ?>
								</div>
							<?php endforeach;
						endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>