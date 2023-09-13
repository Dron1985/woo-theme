<?php
$data = get_fields();
if ( !$data ) {
    return;
}
$classes = [ 'h4' ];

if (!empty(array_trim($data))) : ?>
    <blockquote class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <?php render( '', $data, 'quote_text', '', 'text' ); ?>
        <?php if (is_empty($data, [ 'author', 'position'])) : ?>
            <cite>
                <?php render( '<span>', $data, 'author', '</span>', 'text' ); ?>
                <?php render( '', $data, 'position', '', 'text' ); ?>
            </cite>
        <?php endif; ?>
    </blockquote>
<?php endif;