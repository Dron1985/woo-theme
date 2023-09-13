<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes         = ['three-img-section animation'];
$classes[]       = ($data['contain_img'] == true && $data['variant'] != 'icon-list') ? 'has-contain-big-img' : '';
$classes[]       = ( $data['reverse'] == true ) ? 'reverse' : '';
$top_image_class = ( $data['top_image'] == true ) ? 'home' : '';
$has_bg_class    = ( $data['display_bg'] == true ) ? 'has-bg' : '';
$big_img         = ( $data['big_img'] == true || ( isset( $data['list_icons'] ) && is_array( $data['list_icons'] ) && count( $data['list_icons'] ) > 0 ) ) ? 'one-picture' : '';
$classes[]       = ( ( isset( $data['numbers'] ) && is_array( $data['numbers'] ) && count( $data['numbers'] ) > 0 ) || ( isset( $data['list_icons'] ) && is_array( $data['list_icons'] ) && count( $data['list_icons'] ) > 0 ) ) ? 'has-statistics' : '';
$btn_type        = array_get_value( $data, [ 'button_type' ], '' );

if ( is_empty( $data, [
	'description',
	'list',
	'button',
	'reverse',
	'variant',
	'first_small_image',
	'second_small_image',
	'big_image',
	'numbers'
] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="two-sides-row <?php echo $top_image_class .' '.$has_bg_class; ?> <?php echo $big_img; ?>">
				<?php render_image( '<div class="two-sides-row-bg">', $data, 'background', '</div>', 'full_hd' ); ?>
				<div class="left-side">
					<div class="section-info">
						<?php if ( isset( $data['title'] ) && ! empty( $data['title'] ) ) {
							echo ( isset( $data['title_size'] ) && ! empty( $data['title_size'] ) ) ? '<' . $data['title_size'] . '>' : '<h2>';
							render( '', $data, 'title' );
							echo ( isset( $data['title_size'] ) && ! empty( $data['title_size'] ) ) ? '</' . $data['title_size'] . '>' : '</h2>';
						}
						render( '<p class="sub-text">', $data, 'sub_text', '</p>' );
						render( '', $data, 'description' );
						if ( array_has_key( $data, [ 'list' ], true ) ): ?>
							<ul class="dark-bullet">
								<?php foreach ( $data['list'] as $item ) {
									render( '<li>', $item, 'item', '</li>' );
								} ?>
							</ul>
						<?php endif;
						render(
                                '<div class="buttons-holder">',
                                $data,
                                'button',
                                '</div>',
                                'link',
                                'btn small' . ($btn_type === 'without_border' ? '' : ' has-border'),
                                '<span>',
                                '</span>'
                        ); ?>
					</div>
					<?php if ( isset( $data['first_small_image'] ) && ! empty( $data['first_small_image'] ) || isset( $data['second_small_image'] ) && ! empty( $data['second_small_image'] ) ): ?>
						<div class="images-holder">
							<?php render_image( '<div class="img-wrap">', $data, 'first_small_image', '</div>' );
							render_image( '<div class="img-wrap big">', $data, 'second_small_image', '</div>' ); ?>
						</div>
					<?php endif; ?>
				</div>
				<?php render_image( '<div class="right-side">', $data, 'big_image', '</div>' );
				if ( isset( $data['list_icons'] ) && is_array( $data['list_icons'] ) && count( $data['list_icons'] ) > 0 ): ?>
					<div class="right-side">
						<div class="health-methods">
							<?php foreach ( $data['list_icons'] as $item ): ?>
								<div class="health-method">
									<?php render( '<div class="health-method-img-holder">', $item, 'icon', '</div>' );
									render( '<p>', $item, 'title', '</p>' ); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif;
				if ( isset( $data['numbers'] ) && is_array( $data['numbers'] ) && count( $data['numbers'] ) > 0 ): ?>
					<div class="right-side">
						<div class="statistics-block">
							<?php foreach ( $data['numbers'] as $item ): ?>
								<div class="statistics-item">
									<h5 class="h2"><?php echo $item['number']; ?></h5>
									<p><?php echo $item['description']; ?></p>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif;