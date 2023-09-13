<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}
$classes = ['table-section', 'white-bg', 'animation'];
?>
<section class="<?php echo apply_global_classes($classes, $data); ?>">
    <div class="container">
        <div class="table-section-heading">
            <div class="col">
                <?php render('<h3>', $data, 'title', '</h3>'); ?>
                <?php render('<p>', $data, 'text', '</p>'); ?>
            </div>
            <div class="col">
                <?php if (array_has_key($data, ['legends', 0, 'text'], TRUE)) : ?>
                    <div class="table-section-legend">
                        <?php foreach ($data['legends'] as $item) :
                            $icon = (isset($item['icon']) && !empty($item['icon'])) ? $item['icon'] : ''; ?>
                            <div class="row">
                                <span class="legend-color white"<?= (!empty($item['color']) ? ' style="background-color:' . $item['color'] . ';"' : ''); ?>><?php echo $icon; ?></span>
                                <?php render('<span class="text">', $item, 'text', '</span>'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="table-scrolling">
            <?php render('<div class="holder jcf-scrollable">', $data, 'html', '</div>'); ?>
        </div>
        <?php render('<div class="bottom-text">', $data, 'bottom_text', '</div>'); ?>
    </div>
</section>
