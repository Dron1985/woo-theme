<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}

$classes = ['shelf-section animation'];
$anchor = (isset($args['anchor']) && !empty($args['anchor'])) ? 'id="'.$args['anchor'].'" data-anchor="'.$args['anchor'].'"' : '';

if (is_empty($data, ['title', 'description', 'images'])) :
    $class = (isset($data['hide_border']) && $data['hide_border'] == true) ? 'shelf-item without-border' : 'shelf-item'; ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>" <?php echo $anchor; ?>>
        <div class="container">
            <div class="<?php echo $class; ?>">
                <?php
                    echo (count($data['images']) > 1 ? '<div class="shelf-picture-slider">' : '');
                    foreach ($data['images'] as $item) {
                        render_image('<div class="shelf-picture">', $item, '', '</div>', 'full_hd', '');
                    }
                    echo(count($data['images']) > 1 ? '</div>' : '');
                ?>
                <div class="shelf-text">
                    <?php render_image('<div class="icon">', $data, 'icon', '</div>', 'large', ''); ?>
                    <div class="text">
                        <?php render('<h4>', $data, 'title', '</h4>'); ?>
                        <?php render('<p>', $data, 'description', '</p>'); ?>
                    </div>
                    <?php if (isset($data['type']) && $data['type'] == 'one_column_list' && !empty($data['items'])) : ?>
                        <div class="columns has-bullets one-col">
                            <div class="col">
                                <ul class="dark-bullet">
                                    <?php foreach ($data['items'] as $item): ?>
                                        <?php render('<li>', $item, 'title', '</li>'); ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php else :
                        $class = (count($data['items']) == 3) ? 'three-col' : (count($data['items']) == 1 ? 'one-col' : ''); ?>
                        <div class="columns <?php echo $class; ?>">
                            <?php foreach ($data['items'] as $item): ?>
                                <div class="col">
                                    <?php render('<span class="title">', $item, 'title', '</span>');
                                    render('<span>', $item, 'subtitle', '</span>'); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif;