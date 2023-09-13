<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
    return;
}
$classes = ['simple-hero long-title animation'];
?>
<section class="<?php echo apply_global_classes( $classes, $data ); ?>">
    <div class="container">
        <div class="section-info">
            <?php render('<h1>', $data, 'title', '</h1>'); ?>
            <?php render('', $data, 'description'); ?>
            <?php render(
                    '<div class="buttons"><div class="buttons-holder centered">',
                    $data,
                    'button',
                    '</div></div>',
                    'link',
                    'btn',
                    '<span>',
                    '</span>'
            ); ?>
        </div>
    </div>
</section>
