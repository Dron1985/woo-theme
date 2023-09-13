<?php
get_header();
$fields = get_field( 'fields_archive_pages', 'options' );
if ( isset( $fields['wholesale_archive'] ) && ! empty( $fields['wholesale_archive'] ) ) {
	$post_id = $fields['wholesale_archive'];
}
if ( is_numeric( $post_id ) ) {
	$the_post = get_post( $post_id );
	if ( has_blocks( $the_post ) ) {
		$blocks         = parse_blocks( $the_post->post_content );
		$content_markup = '';
		foreach ( $blocks as $block ) {
			if ( $block['blockName'] != null ) {
				$content_markup .= render_block( $block );
			}
		}
		echo $content_markup;
	}
}
get_footer();
?>