<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}

$use_column = array_get_value($data, ['use_bulleted_column'], FALSE);

$classes = [$use_column ? 'bulleted-column-section animation' : 'bulleted-list-section animation'];
if (array_get_value($data, ['two_columns'], FALSE)) {
    $classes[] = 'two-columns';
}
$reverse   = (isset($data['reverse']) && $data['reverse'] == TRUE ) ? 'reverse' : '';
$icon_list = (isset($data['custom_icon']) && $data['custom_icon'] == TRUE) ? 'big-ico-list' : ''; ?>
<?php if (is_empty($data, ['items'])): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
            <?php if ($use_column) : ?>
                <?php render( '<h2>', $data, 'title', '</h2>' ); ?>
            <?php endif; ?>
			<div class="<?= $use_column ? 'bulleted-column-section-row' : 'bulleted-list-section-row'; ?> <?php echo $reverse . ' ' . $icon_list; ?>">
				<div class="section-info">
                    <?php if (!$use_column) : ?>
                        <?php render( '<h2>', $data, 'title', '</h2>' ); ?>
                    <?php endif; ?>
					<?php render( '<p class="sub-text">', $data, 'sub_text', '</p>' ); ?>
					<?php render( '', $data, 'description' ); ?>
				</div>
				<?php if ( isset( $data['lists'] ) && is_array( $data['lists'] ) && count( $data['lists'] ) > 0 ):
					$class = ( isset( $data['custom_icon'] ) && ! empty( $data['custom_icon'] ) ) ? 'icon-list' : 'dark-bullet'; ?>
					<div class="<?= $use_column ? 'bulleted-column-list' : 'bulleted-list-col'; ?>">
						<ul class="<?php echo $class; ?>">
							<?php foreach ( $data['lists'] as $item ) {
								if ( isset( $data['custom_icon'] ) && ! empty( $data['custom_icon'] ) ) {
									echo '<li>';
									render_image( '<span class="icon">', $item, 'icon', '</span>', 'large' );
									render( '<span class="text">', $item, 'item', '</span>' );
									echo '</li>';
								}
                                else {
									render( '<li>', $item, 'item', '</li>' );
								}
							} ?>
						</ul>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>
