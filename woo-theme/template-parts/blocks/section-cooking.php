<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'cooking-section animation' ];
?>
<?php if ( is_empty( $data, [ 'description', 'items' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
            <div class="section-info indent-bottom-medium medium">
			    <?php
                render( '<h2>', $data, 'title', '</h2>' );
                render( '', $data, 'description' );
                ?>
            </div>
			<?php if ( is_empty( $data, [ 'items' ] ) ):
				$end = count( $data['items'] ) - 1;
				foreach ( $data['items'] as $key => $item ):
					$reverse = ( $key % 2 == 0 ) ? 'reverse' : '';
					$indent = ( $key != $end ) ? 'indent-bottom-medium' : ''; ?>
					<div class="cooking-reverse <?php echo $reverse . ' ' . $indent; ?>">
						<div class="cooking-reverse-picture">
							<?php render_image( '<div class="picture">', $item, 'big_image', '</div>', 'full_hd' );
							render_image( '<div class="picture">', $item, 'small_image', '</div>', 'full_hd' ); ?>
						</div>
                        <div class="cooking-reverse-text">
                            <?php
                            render( '<h3>', $item, 'title', '</h3>' );
                            render( '', $item, 'description' );
                            ?>
                        </div>
					</div>
				<?php endforeach;
			endif; ?>
		</div>
	</section>
<?php endif;