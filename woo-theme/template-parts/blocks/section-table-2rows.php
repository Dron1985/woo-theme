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
                    <div class="tabset-btn-text<?= $index === 0 ? ' active' : ''; ?>" data-tab="tb2row-index-<?= $index; ?>">
                        <?php render('<h3>', $tab, 'title', '</h3>'); ?>
                        <?php render('<p>', $tab, 'text', '</p>'); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="tabs">
            <?php foreach ($data['tabs'] as $index => $tab) : ?>
                <div class="tab<?= $index === 0 ? ' active' : ''; ?>" data-tab="tb2row-index-<?= $index; ?>">
                    <div class="table-scrolling">
                        <div class="holder">
                            <table class="big-table">
                                <?php $f_tbody = FALSE; ?>
                                <?php foreach ($tab['rows'] as $key => $row) : ?>
                                    <?php if ($key === 0) : ?>
                                        <thead>
                                            <tr>
                                                <th><?php render('', $row, 'title', ''); ?></th>
                                                <th><?php render('', $row, 'description', ''); ?></th>
                                            </tr>
                                        </thead>
                                    <?php else : ?>
                                        <?php if (!$f_tbody) : ?>
                                            <?php $f_tbody = TRUE; ?>
                                            <tbody>
                                        <?php endif; ?>
                                        <tr>
                                            <td><?php render('', $row, 'title', ''); ?></td>
                                            <td><?php render('', $row, 'description', ''); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php if ($f_tbody) : ?>
                                    </tbody>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
