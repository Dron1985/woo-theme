<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}
$classes = ['diversity-section animation'];
?>
<section class="<?php echo apply_global_classes($classes, $data); ?>">
	<div class="container">
		<div class="section-info large">
            <?php render('<h2>', $data, 'title', '</h2>'); ?>
            <?php render('<p>', $data, 'text', '</p>'); ?>
		</div>
	</div>
    <?php if (array_has_key($data, ['image', 'url'])) : ?>
        <div class="diversity-picture">
            <img src="<?= $data['image']['url'] ?>" alt="image description">
        </div>
    <?php endif; ?>
    <?php if (array_has_key($data, ['items', '0', 'number'])) : ?>
        <div class="diversity-numbers">
            <?php foreach ($data['items'] as $val) : ?>
                <div class="col">
                    <div class="holder">
                        <?php render('<span class="h2">', $val, 'number', '%</span>'); ?>
                        <?php render('<span class="sub-text">', $val, 'text', '</span>'); ?>
                    </div>
                    <span class="icon"><img src="<?= $val['icon'] ?>" alt="image description"></span>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>
