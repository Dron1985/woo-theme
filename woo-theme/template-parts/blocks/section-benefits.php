<?php
$data = get_fields();
if (!$data) {
    return;
}

$classes = [ 'benefits-section animation' . (array_get_value($data, ['light_bg'], FALSE) ? '' : ' cream-bg') ];
$anchor = (isset($args['anchor']) && !empty($args['anchor'])) ? 'id="'.$args['anchor'].'" data-anchor="'.$args['anchor'].'"' : '';

if (is_empty($data, ['title', 'text', 'benefits'])): ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>" <?php echo $anchor; ?>>
        <div class="container">
            <?php if (is_empty($data, ['title', 'text'])) : ?>
                <div class="section-info large">
                    <?php $tag = (isset($data['title_tag']) && !empty($data['title_tag'])) ? $data['title_tag'] : 'h3'; ?>
                    <?php render("<{$tag}>", $data, 'title', "</{$tag}>"); ?>
                    <?php render('<p>', $data, 'text', '</p>'); ?>
                </div>
            <?php endif; ?>
            <div class="benefits-list">
                <?php foreach ($data['benefits'] as $benefit) : ?>
                    <div class="benefits-item">
                        <?php
                        render('<div class="benefits-icon-holder">', $benefit, 'svg_icon', '</div>', 'text');
                        render('<h5>', $benefit, 'title', '</h5>', 'text');
                        render('', $benefit, 'description', '', 'text'); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif;