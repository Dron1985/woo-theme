<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}

$classes = ['gallery-section animation'];
?>
<section class="<?php echo apply_global_classes($classes, $data); ?>">
    <div class="container">
        <div class="section-info large">
            <?php render('<h2>', $data, 'title', '</h2>'); ?>
            <?php render('<p>', $data, 'text', '</p>'); ?>
        </div>
    </div>
    <div class="gallery">
        <?php foreach ($data['gallery'] as $val) : ?>
            <div class="gallery-picture"><img src="<?= $val['url']; ?>" alt="image"></div>
        <?php endforeach; ?>
    </div>
</section>
