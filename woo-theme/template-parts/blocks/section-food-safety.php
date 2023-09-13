<?php
$data = get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'four-card-section animation' ];
$anchor = (isset($args['anchor']) && !empty($args['anchor'])) ? 'id="'.$args['anchor'].'" data-anchor="'.$args['anchor'].'"' : '';

if ( is_empty( $data, [ 'card_info' ] ) ): ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>" <?php echo $anchor; ?>>
        <div class="four-card-bg">
            <?php if (isset($data['use_video']) && $data['use_video'] != true) :
                render_image( '', $data, 'bg_img', '', 'full_hd', '' );
            elseif ($data['use_video'] == true && isset($data['video']['url'])) : ?>
                <video class="stope-last-frame" muted autoplay>
                    <source src="<?php echo $data['video']['url']; ?>" type="video/mp4">
                    <?php echo __('Your browser does not support the video tag.', 'woo-theme'); ?>
                </video>
            <?php endif; ?>
        </div>
        <div class="container">
            <div class="section-info static">
                <?php
                render( '<h2>', $data, 'title', '</h2>' );
                render( '', $data, 'description' );
                render( '<div class="buttons-holder centered">', $data, 'button', '</div>', 'link', 'btn small', '<span>', '</span>' );
                ?>
            </div>
        </div>
        <div class="four-card-items animation">
            <?php $i = 1;
            foreach ($data['card_info'] as $info) :
                $class = ( $i % 2 ) ? 'four-card-item' : 'four-card-item small'; ?>
                <div class="<?php echo $class; ?>">
                    <?php render_image( '<div class="picture">', $info, 'image', '</div>', 'medium_large', '' ); ?>
                    <div class="four-card-text">
                        <?php
                        render( '<div class="four-card-info-holder"><h5>', $info, 'title', '</h5></div>', 'text' );
                        render( '<div class="icon-holder">', $info, 'svg_icon', '</div>', 'text');
                        ?>
                    </div>
                </div>
            <?php $i++;
            endforeach; ?>
        </div>
    </section>
<?php endif;