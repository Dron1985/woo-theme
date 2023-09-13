<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'product-description-section animation' ];
$class   = (isset($data['type']) && !empty($data['type'])) ? $data['type'] : 'whole';
if ( is_empty( $data, [ 'image', 'button', 'main_description', 'additional_description' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<?php if (isset($data['image']['sizes'])) : ?>
				<div class="product-description-picture animation">
                    <div class="product-description-decor <?php echo $class; ?>">
                        <?php if (isset($data['gallery_animation']) && !empty($data['gallery_animation']) && count( $data['gallery_animation']) > 0 ):
                            foreach ( $data['gallery_animation'] as $item ) :
                                render_image( '', $item, 'image', '', 'full_hd' );
                            endforeach;
                        endif;
                        render_image( '<div class="origin-img-holder">', $data, 'image', '</div>', 'large', 'nut' ); ?>
                    </div>
				</div>
			<?php endif; ?>
			<div class="product-description-text">
				<h1 class="h2"><?php the_title(); ?></h1>
				<?php render( '<p class="sub-text">', $data, 'main_description', '</p>', 'text' );
				render( '<p>', $data, 'additional_description', '</p>', 'text' );
				render( '<div class="buttons"><div class="buttons-holder">', $data, 'button', '</div></div>', 'link', 'btn', '<span>', '</span>' ) ?>
			</div>
		</div>
	</section>
<?php endif;