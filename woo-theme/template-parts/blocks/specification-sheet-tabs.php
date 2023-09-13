<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'specification-sheet-tabs', 'tabs-section', 'white-bg', 'animation'];
if ( isset( $data['top_overlay'] ) && $data['top_overlay'] == true ) {
	$classes = [ 'specification-sheet-section' ];
}
$tabs_title = [];
if ( is_array( $data['tabs'] ) && count( $data['tabs'] ) > 0 ) {
	foreach ( $data['tabs'] as $tab ) {
		if ( ! empty( $tab['tab_title'] ) ) {
			$tabs_title[] = $tab['tab_title'];
		}
	}
}
?>
<?php if ( is_empty( $data, [ 'tabs' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<?php if ( isset( $tabs_title ) && is_array( $tabs_title ) && count( $tabs_title ) > 0 ): ?>
				<div class="tabset">
					<div class="holder">
						<?php foreach ( $tabs_title as $key => $item ):
							$active_class = ( $key == 0 ) ? 'active' : '';
							$data_tab = str_replace( " ", "_", $item );
							$data_tab = mb_strtolower( $data_tab );
							?>
							<button type="button" data-tab="<?php echo $data_tab; ?>"
							        class="<?php echo $active_class; ?> btn"><span><?php echo $item; ?></span></button>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php if ( isset( $data['tabs'] ) && is_array( $data['tabs'] ) && count( $data['tabs'] ) > 0 ): ?>
				<div class="tabs">
					<?php foreach ( $data['tabs'] as $key => $item ):
						$active_class = ( $key == 0 ) ? 'active' : '';
						$data_tab = str_replace( " ", "_", $item['tab_title'] );
						$data_tab = mb_strtolower( $data_tab );
						?>
						<div class="tab <?php echo $active_class; ?>" data-tab="<?php echo $data_tab; ?>">
							<h3><?php echo ucwords( $item['tab_title'] ); ?></h3>
							<div class="specification-sheet-section">
								<div class="specification-sheet-cards">
									<?php $card_title           = [];
									foreach ( $item['tabs_card'] as $sub_key => $card ):
										$active_class = ''; //( $sub_key == 0 ) ? 'active' : '';
										$card['title']          = mb_strtolower( $card['title'] );
										$card_title[ $sub_key ] = $card['title'] . $sub_key; ?>
										<div class="specification-sheet-card <?php echo $active_class; ?>" data-row="<?php echo $card['title'] . $sub_key; ?>">
											<?php render_image( '', $card, 'image', '', 'large' ); ?>
											<span class="mask">&nbsp;</span>
											<button class="btn has-border small" type="button">
												<span><?php echo $card['title']; ?></span>
											</button>
										</div>
									<?php endforeach; ?>
								</div>
								<?php if ( isset( $item['row'] ) && is_array( $item['row'] ) && count( $item['row'] ) > 0 ): ?>
									<div class="table-adaptive jcf-scrollable">
										<table>
											<thead>
											<?php foreach ( $item['row'] as $item_key => $value ):
												if ( $item_key == 0 ):
													echo '<tr>';
													render( '<th>', $value, 'first_cell', '</th>' );
													render( '<th>', $value, 'second_cell', '</th>' );
													render( '<th>', $value, 'third_cell', '</th>' );
													render( '<th>', $value, 'fourth_cell', '</th>' );
													render( '<th>', $value, 'fifth_cell', '</th>' );
													render( '<th>', $value, 'sixth_cell', '</th>' );
													echo '</tr>';
												endif;
											endforeach; ?>
											</thead>
											<tbody>
											<?php foreach ( $item['row'] as $item_key => $value ):
												if ( $item_key > 0 ):
													$data_row = "";
													if ( isset( $value['select_card'] ) && is_array( $value['select_card'] ) && count( $value['select_card'] ) > 0 ) {
														foreach ( $value['select_card'] as $sub_key => $sub_value ) {
															if($sub_key > 0) {
																$data_row .= ' ';
															}
															$data_row .= $card_title[ $sub_value ];
														}
													}
													echo '<tr data-row="' . $data_row . '">';
													render( '<td>', $value, 'first_cell', '</td>' );
													render( '<td>', $value, 'second_cell', '</td>' );
													render( '<td>', $value, 'third_cell', '</td>' );
													render( '<td>', $value, 'fourth_cell', '</td>' );
													render( '<td>', $value, 'fifth_cell', '</td>' );
													render( '<td>', $value, 'sixth_cell', '</td>' );
													echo '</tr>';
												endif;
											endforeach; ?>
											</tbody>
										</table>
									</div>
									<?php render( '<div class="buttons"><div class="buttons-holder centered">', $item, 'button', '</div></div>', 'link', 'btn small', '<span>', '</span>' );
								endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>