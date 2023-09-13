<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}
$classes   = [ 'shelf-life', 'tabs-section', 'animation' ];
$classes[] = ( isset( $data['grey_bg'] ) && ! empty( $data['grey_bg'] ) && $data['grey_bg'] == true ) ? 'grey-bg' : '';
?>
<?php if ( is_empty( $data, [ 'tabs' ] ) ): ?>
	<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
		<div class="container">
			<div class="tabset">
				<div class="holder">
					<?php
					$data_tabs = [];
					foreach ( $data['tabs'] as $key => $item ):
						$active_class = ( $key == 0 ) ? 'active' : '';
						$data_tab = str_replace( " ", "_", $item['tab_name'] );
						$data_tab = mb_strtolower( $data_tab );
						$data_tabs[] = $data_tab;
						?>
						<button type="button" data-tab="shelf_life_<?php echo $data_tab; ?>"
						        class="<?php echo $active_class; ?> btn"><span><?php echo $item['tab_name']; ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="tabs">
				<?php foreach ( $data['tabs'] as $key => $item ):
					$active_class = ( $key == 0 ) ? 'active' : '';
					$data_tab = str_replace( " ", "_", $item['title'] );
					$data_tab = mb_strtolower( $data_tab );
					?>
					<div class="tab <?php echo $active_class; ?>" data-tab="shelf_life_<?php echo $data_tabs[$key]; ?>">
						<h3><?php echo $item['title']; ?></h3>
						<?php render( '<div class="table-scrolling"><div class="holder dark-head">', $item, 'table', '</div></div>' ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>
<?php endif; ?>