<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
    return;
}
$classes = [ 'know-more-section animation' ];
if (is_empty($data, ['title', 'description', 'bg_img', 'button'])): ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <?php if (isset($data['bg_img']['sizes'])) : ?>
            <div class="know-more-bg"><img src="<?php echo $data['bg_img']['sizes']['full_hd']; ?>" alt="<?php echo $data['bg_img']['alt']; ?>"></div>
        <?php endif; ?>
        <div class="container">
            <div class="section-info">
                <?php
                render( '<h3>', $data, 'title', '</h3>', 'text' );
                render( '', $data, 'description', '', 'text' );
                render( '<div class="buttons"><div class="buttons-holder centered">', $data, 'button', '</div></div>', 'link', 'btn small', '<span>', '</span>' );?>
            </div>
        </div>
    </section>
<?php endif;