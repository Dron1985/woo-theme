<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'order-section animation' ];

if (isset($data['global_order']) && $data['global_order'] == true) {
    $data = get_field('order_info_block', 'option');
}

if (is_empty($data, [ 'title_left', 'desc_left', 'button_left', 'phone_desc', 'phone', 'title_right', 'desc_right', 'button_right' ])): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="order-inner">
				<div class="section-info">
					<?php
                    render( '<h3>', $data, 'title_left', '</h3>', 'text' );
                    render( '', $data, 'desc_left' );
					render( '<div class="buttons-holder">', $data, 'button_left', '</div>', 'link', 'btn small', '<span>', '</span>' ); ?>
					<?php if (is_empty( $data, ['phone_desc', 'phone'])) : ?>
                        <div class="phone-info">
                            <?php render( '<span>', $data, 'phone_desc', '</span>' );
                            render( '', $data, 'phone', '', 'tel', '', ' Call ' ); ?>
                        </div>
                    <?php endif; ?>
				</div>
				<div class="section-info small-orders">
					<div class="section-info-inner">
						<?php
                        render( '<h3>', $data, 'title_right', '</h3>', 'text' );
                        render( '', $data, 'desc_right' );
						render( '<div class="buttons-holder">', $data, 'button_right', '</div>', 'link', 'btn small has-border', '<span>', '</span>' ); ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif;