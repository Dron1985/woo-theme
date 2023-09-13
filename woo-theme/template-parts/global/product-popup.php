<?php $data = get_field('product_info_fields'); ?>
<div class="modal-window nutrition" data-modal="nutrition">
    <div class="modal-overlay"></div>
    <div class="modal-outer">
        <button type="button" class="close-modal"></button>
        <div class="modal-inner-wrap">
            <div class="modal-inner jcf-scrollable">
                <div class="modal-text">
                    <div class="modal-text-card">
                        <?php render('<h5>', $data, 'title', '</h5>', 'text');
                        render('<p>', $data, 'subtitle', '</p>', 'text');  ?>
                    </div>
                    <?php render('<span class="note">', $data, 'note', '</span>', 'text'); ?>
                    <div class="calories-info">
                        <?php if (is_empty($data, ['heading', 'value', 'note_info'])) : ?>
                            <div class="modal-text-card">
                                <?php
                                render('<div><span class="h5">', $data, 'heading', '</span></div>');
                                render('<span class="h5">', $data, 'value', '</span>', 'text'); ?>
                            </div>
                            <?php render('<span class="note">', $data, 'note_info', '</span>', 'text');
                        endif; ?>

                        <?php foreach ($data['info'] as $info) :
                            if (isset($info['multipl_lines']) && !empty($info['multipl_lines']) && isset($info['use_multipl_lines']) && $info['use_multipl_lines'] == true) : ?>
                                <div class="calories-card-outer">
                                    <?php foreach ($info['multipl_lines'] as $item) : ?>
                                        <div class="calories-info-card half">
                                            <?php
                                            render('<div>', $item, 'text', '</div>');
                                            render('<span>', $item, 'value', '</span>', 'text'); ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else:
                                $class = (isset($info['top_margin']) && $info['top_margin'] == true ) ? 'calories-info-card has-top-margin' : 'calories-info-card'; ?>
                                <div class="<?php echo $class; ?>">
                                    <?php if (isset($item['light_text']) && $item['light_text'] == true || stristr($info['text'], '<span class="bold">') == true) {
                                        render('<div>', $info, 'text', '</div>');
                                    } else {
                                        render('<div><span>', $info, 'text', '</span></div>');
                                    }; ?>
                                    <?php render('<span>', $info, 'value', '</span>', 'text'); ?>
                                </div>
                                <?php if (isset($info['show_divider']) && $info['show_divider'] == true) : ?>
                                    <span class="modal-divider"></span>
                                <?php endif;
                            endif;
                        endforeach; ?>
                    </div>
                    <?php render('<div class="text-bottom">', $data, 'description', '</div>', 'text'); ?>
                </div>
            </div>
        </div>
    </div>
</div>