<?php
$data = get_field('fields_woo', 'option');
$popup = $data['popup_fields'];
if (isset($data['shop_popup']) && $data['shop_popup'] == true && isset($popup['info_block']) && !empty($popup['info_block'])) : ?>
    <div class="modal-window one-time" data-modal="one-time">
        <div class="modal-overlay"></div>
        <div class="modal-outer">
            <button type="button" class="close-modal"></button>
            <div class="modal-inner-wrap">
                <div class="modal-inner jcf-scrollable">
                    <div class="modal-text">
                        <?php $i = 1;
                        foreach ($popup['info_block'] as $info) :
                            $btn_class = ($i == 1) ? 'btn small' : 'btn small has-border'; ?>
                            <div class="modal-text-card">
                                <?php
                                    render('<h4>', $info, 'title', '</h4>', 'text');
                                    render('', $info, 'description', '', 'text');
                                    render('<div class="buttons-holder">', $info, 'button', '</div>', 'link', $btn_class, '<span>', '</span>');
                                ?>
                            </div>
                        <?php $i++;
                        endforeach; ?>
                    </div>
                    <?php if (isset($popup['image']['sizes'])) : ?>
                        <div class="modal-img-holder">
                            <img src="<?php echo $popup['image']['sizes']['medium_large']; ?>" alt="<?php echo $popup['image']['alt']; ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php endif;