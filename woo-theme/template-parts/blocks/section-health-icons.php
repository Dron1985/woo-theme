<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
    return;
}

$classes = ['three-img-section', 'has-statistics', 'animation'];
?>
<section class="<?php echo apply_global_classes($classes, $data); ?>">
    <div class="container">
        <div class="two-sides-row stretched-left-side one-picture">
            <div class="left-side">
                <div class="section-info">
                    <?php render('<h2>', $data, 'title', '</h2>'); ?>
                    <?php render('<p class="sub-text">', $data, 'text', '</p>'); ?>
                </div>
            </div>
            <div class="right-side">
                <div class="health-methods">
                    <?php foreach ($data['items'] as $val) : ?>
                        <div class="health-method">
                            <div class="health-method-img-holder">
                                <?php echo get_svg_file_content($val['icon']); ?>
                            </div>
                            <?php render('<p class="sub-text">', $val, 'text', '</p>'); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>