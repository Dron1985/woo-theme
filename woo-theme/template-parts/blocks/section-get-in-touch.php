<?php
$data = get_field('get_in_touch_field');
if (!$data) {
    return;
}

if (isset($data['global_block']) && $data['global_block'] == true) {
    $field = get_field('fields_get_in_touch', 'option');
    $data['hide_block'] = false;
    $data['title'] = (isset($field['title']) && !empty($field['title'])) ? $field['title'] : '';
    $data['description'] = (isset($field['description']) && !empty($field['description'])) ? $field['description'] : '';
    $data['bg_img'] = (isset($field['bg_img']['sizes'])) ? $field['bg_img'] : '';
    $data['display_button'] = (isset($field['display_button']) && !empty($field['display_button'])) ? $field['display_button'] : '';
    $data['button'] = (isset($field['button']) && !empty($field['button'])) ? $field['button'] : '';
    $data['form'] = (isset($field['form']) && !empty($field['form'])) ? $field['form'] : '';
}

$classes = [ 'get-in-touch animation' ];
if (is_empty($data, ['title', 'description', 'bg_img', 'form']) && isset($data['hide_block']) && $data['hide_block'] != true): ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <?php if (isset($data['bg_img']['sizes'])) : ?>
            <div class="get-in-touch-bg" style="background-image: url('<?php echo $data['bg_img']['sizes']['full_hd']; ?>')"></div>
        <?php endif; ?>
        <div class="container">
            <div class="section-info">
                <?php
                render( '<h3>', $data, 'title', '</h3>', 'text' );
                render( '<p class="full-width">', $data, 'description', '</p>', 'text' );
                if (isset($data['display_button']) && $data['display_button'] == true) :
                    render( '<div class="buttons-holder centered">', $data, 'button', '</div>', 'link', 'btn small', '<span>', '</span>' );
                elseif (isset($data['form']) && !empty($data['form'])) :
                    echo do_shortcode('[contact-form-7 id="'.$data['form'].'" title="Stay connect form"]');
                endif; ?>
            </div>
        </div>
    </section>
<?php endif;