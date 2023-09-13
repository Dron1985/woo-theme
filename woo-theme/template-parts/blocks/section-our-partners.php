<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}
$classes = ['our-partners animation'];
?>
<section class="<?php echo apply_global_classes($classes, $data); ?>">
    <div class="container">
        <div class="section-info">
            <?php render('<h3>', $data, 'title', '</h3>'); ?>
            <?php render('<p>', $data, 'text', '</p>'); ?>
        </div>
        <ul class="partners-list">
            <?php foreach ($data['items'] as $val) : ?>
                <li>
                    <?php if (array_has_key($val, ['url'], TRUE)) : ?>
                        <a href="<?= $val['url']; ?>"></a>
                    <?php endif; ?>
                    <div class="partners-img-holder">
                        <img src="<?= $val['image']; ?>" alt="partner logo">
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
