<?php
$data = get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'sustainability-section animation' ];

if ( is_empty( $data, [ 'info' ] ) ): ?>
    <div class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <div class="container">
            <div class="two-sides-row">
                <div class="left-side">
                    <div class="section-info">
                        <?php
                        render( '<h2>', $data, 'title', '</h2>' );
                        render( '', $data, 'description' );
                        ?>
                    </div>
                    <div class="nav-list">
                        <?php foreach ($data['info'] as $info) : ?>
                            <div class="nav-item">
                                <?php
                                render( '<div class="nav-item-icon-holder">', $info, 'svg_icon', '</div>', 'text');
                                render( '<div class="nav-item-text">', $info, 'title', '</div>', 'text');
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php render( '<div class="buttons-holder">', $data, 'button', '</div>', 'link', 'btn small', '<span>', '</span>' ); ?>
                </div>
                <div class="right-side">
                    <div class="sustainability-slider">
                        <?php foreach ($data['info'] as $info) :?>
                            <div class="sustainability-item">
                                <div class="sustainability-media">
                                    <?php if (isset($info['use_video']) && $info['use_video'] == true && isset($info['video']['url'])) :  ?>
                                        <video class="video-bg" preload="metadata" loop autoplay muted playsinline>
                                            <source src="<?php echo $info['video']['url']; ?>" type="video/mp4">
                                            <?php echo __('Your browser does not support the video tag.', 'woo-theme'); ?>
                                        </video>
                                    <?php else :
                                        echo render_image( '<div class="sustainability-media">', $info, 'image', '</div>', 'medium_large');
                                    endif; ?>
                                </div>
                                <div class="sustainability-info">
                                    <?php render( '<h2>', $info, 'value', '</h2>', 'text'); ?>
                                    <div class="sustainability-divider">
                                        <?php echo get_template_part('template-parts/svg/divider'); ?>
                                    </div>
                                    <?php render( '', $info, 'description', '', 'text'); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;