<?php
$data = $args['data'] ?? get_fields();
if ( ! $data ) {
	return;
}

$classes = ['logos-section animation'];
if (isset($data['white_background']) && !empty($data['white_background'])) {
	$classes[] = 'white-bg';
}
if ( isset( $data['with_border'] ) && ! empty( $data['with_border'] ) ) {
	$classes[] = 'with-border';
}

if (isset($data['global_logos']) && $data['global_logos'] != true) {
    $logos = (isset($data['items']) && !empty($data['items'])) ? $data['items'] : '';
} else {
    $logos = get_field('fields_logos', 'option');
}

if (!empty($logos)) : ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <div class="container">
            <div class="logos-block">
                <?php foreach ($logos as $logo): ?>
                    <div class="logo-container">
                        <?php if (isset($logo['title_link']['url'])) : ?>
                            <a href="<?php echo $logo['title_link']['url']; ?>" target="<?php echo ($logo['title_link']['target'] ? '_blank' : '_self'); ?>"></a>
                        <?php endif; ?>
                        <?php render_image( '<div class="logo-img">', $logo, 'logo', '</div>', 'medium' ); ?>
                        <?php if (isset($logo['title_link']['title']) && !empty($logo['title_link']['title'])) : ?>
                            <p class="logo-desc"><?php echo $logo['title_link']['title']; ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif;
