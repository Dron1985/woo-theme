<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}

$classes = ['collaboration-section animation'];
if (array_has_key($data, ['title'], TRUE)) {
    $classes[] = 'large-padding';
}
?>
<?php if ( is_empty( $data, [ 'description', 'background', 'first_button', 'second_button' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<?php if ( is_empty( $data, [ 'background' ] ) ): ?>
				<div class="collaboration-bg">
					<?php if ( $data['background']['type'] == 'image' ) {
						render_image( '', $data, 'background', '', 'full_hd' );
					} else { ?>
						<video class="video-bg" muted autoplay loop>
							<source src="<?php echo $data['background']['url']; ?>" type="video/mp4">
							Your browser does not support the video tag.
						</video>
					<?php } ?>
				</div>
		<?php endif; ?>
		<div class="container">
			<div class="collaboration-section-inner">
				<div class="section-info">
                    <?php render('<h2>', $data, 'title', '</h2>'); ?>
					<?php render( '', $data, 'description' );
					if ( is_empty( $data, [ 'first_button', 'second_button' ] ) ): ?>
						<div class="buttons-holder">
							<?php render( '', $data, 'first_button', '', 'link', 'btn small', '<span>', '</span>' );
							render( '', $data, 'second_button', '', 'link', 'btn has-border small', '<span>', '</span>' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
