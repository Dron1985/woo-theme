<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}
$classes = ['icon-list-tabs', 'tabs-section', 'white-bg', 'animation'];
?>
<section class="<?php echo apply_global_classes($classes, $data); ?>">
    <div class="container">
        <div class="tabset text-col-view">
            <div class="holder">
                <?php foreach ($data['tabs'] as $index => $tab) : ?>
                    <div class="tabset-btn-text<?= $index === 0 ? ' active' : ''; ?>" data-tab="tb-index-<?= $index; ?>">
                        <?php render('<h3>', $tab, 'title', '</h3>'); ?>
                        <?php render('<p>', $tab, 'text', '</p>'); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tabs">
            <?php foreach ($data['tabs'] as $index => $tab) : ?>
                <div class="tab<?= $index === 0 ? ' active' : ''; ?>" data-tab="tb-index-<?= $index; ?>">
	                <div class="icon-list-rows">
	                    <?php foreach ($tab['row'] as $row) : ?>
	                        <div class="icon-list-row">
	                            <span class="icon full-img">
	                                <img src="<?= $row['image'] ?>" alt="image description">
	                            </span>
	                            <?php render('<h4>', $row, 'title', '</h4>'); ?>
	                            <?php render('<div class="text">', $row, 'description', '</div>'); ?>
	                        </div>
	                    <?php endforeach; ?>
	                </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
