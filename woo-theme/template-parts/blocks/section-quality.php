<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}

$sizes = [
    '18' => '18/20',
    '20' => '20/22',
    '23' => '23/25',
    '25' => '25/27',
    '27' => '27/30',
    '30' => '30/32',
    '32' => '32/34',
    '34' => '34/36',
    '36' => '36/40'
];
$classes = ['quality-section', 'white-bg', 'animation'];
if (isset($data['rows']) && !empty($data['rows'])) : ?>
    <section class="<?php echo apply_global_classes($classes, $data); ?>">
        <div class="container">
            <div class="table-section-heading">
                <div class="col">
                    <?php render('<h3>', $data, 'title', '</h3>'); ?>
                    <?php render('<p>', $data, 'text', '</p>'); ?>
                </div>
            </div>
            <?php foreach ($data['rows'] as $row) : ?>
                <div class="quality-box">
                    <div class="quality-title">
                        <?php render('<span>', $row, 'title', '</span>'); ?>
                        <button class="open-close-btn">&nbsp;</button>
                    </div>
                    <div class="quality-description jcf-scrollable">
                        <div class="col-top">
                            <div class="col-picture"><img src="<?= $row['image']; ?>" alt="image descrition"></div>
                            <div class="col-text">
                                <?php foreach ($row['items'] as $item) : ?>
                                    <div class="col">
                                        <?php render('<span class="col-text-title">', $item, 'title', '</span>'); ?>
                                        <?php render('<p>', $item, 'text', '</p>'); ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="col-nuts">
                            <?php foreach ($sizes as $key => $val) : ?>
                                <div class="col">
                                    <span class="size"><?= $val; ?></span>
                                    <span class="view">
                                        <?php if (array_has_key($row, ['image_' . $key], TRUE)) : ?>
                                            <img src="<?= $row['image_' . $key] ?>" alt="image description">
                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
<?php endif;
