<?php
$data = get_fields();
if ( ! $data ) {
	return;
}
$classes = [ 'rotating-nuts-section animation' ];

if ( is_empty( $data, [ 'animation_slider' ] ) ): ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <div class="container">
            <div class="section-info">
                <?php
                render( '<h2>', $data, 'title', '</h2>' );
                render( '', $data, 'description' ); ?>
            </div>
            <div class="sliders-container animation">
                <div class="origin-image-wrap">
                    <img class="origin-image-bg" src="<?php echo get_template_directory_uri(); ?>/dist/images/ellipse-bg.png" alt="bg-image">
                    <canvas id="nut-intro-animation-box" data-directory-url="<?php echo get_template_directory_uri(); ?>/assets/animation-intro"></canvas>
                </div>
                <div class="home-media-slider">
                    <?php foreach ($data['animation_slider'] as $slide) :
                        $class = (isset($slide['type']) && !empty($slide['type'])) ? 'media-slider-item '.$slide['type'] : 'media-slider-item'; ?>
                        <div class="<?php echo $class; ?>">
                            <div class="media-slider-img-holder">
                                <div class="media-slider-decor-holder">
                                    <?php switch ($slide['type']) :
                                        case 'butter': ?>
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-01.png" alt="butter image">
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-02.png" alt="butter image">
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-03.png" alt="butter image">
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-04.png" alt="butter image">
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-05.png" alt="butter image">
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-06.png" alt="butter image">
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-07.png" alt="butter image">
                                            <?php break;
                                        case 'inshell': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/shell-img-01.png" alt="icon">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/shell-img-02.png" alt="icon">
                                            <?php break;
                                        case 'diced': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-01.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-02.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-03.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-04.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-05.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-06.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-07.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-08.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-09.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-10.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-11.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-12.png" alt="diced image">
                                            <?php break;
                                        case 'slivered': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-01.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-02.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-03.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-04.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-05.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-06.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-07.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-08.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-09.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-10.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-11.png" alt="slivered image">
                                            <?php break;
                                        case 'halved': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-01.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-02.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-03.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-04.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-05.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-06.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-07.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-08.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-09.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-10.png" alt="halved image">
                                            <?php break;
                                        case 'sliced': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-01.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-02.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-03.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-04.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-05.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-06.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-07.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-08.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-09.png" alt="sliced image">
                                            <?php break;
                                        case 'powder': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/flour-img-01.png" alt="powder image">
                                            <?php break;
                                        case 'oil': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/oil-img-01.png" alt="oil image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/oil-img-02.png" alt="oil image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/oil-img-03.png" alt="oil image">
                                            <?php break;
                                        case 'flour': ?>
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/powder-img-01.png" alt="flour image">
                                            <?php break;
                                    endswitch; ?>
                                </div>
                                <div class="origin-img-holder">
                                    <div class="origin-animation-wrap">
                                        <img class="nut" src="<?php echo get_template_directory_uri(); ?>/dist//images/almond-slider/origin-image-1.png" alt="nut image">
                                    </div>
                                </div>

                                <?php switch ($slide['type']) :
                                    case 'butter': ?>
                                        <div class="media-slider-decor-holder duplicate">
                                            <img class="" src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/butter-img-01.png" alt="butter image">
                                        </div>
                                        <?php break;
                                    case 'inshell': ?>
                                        <div class="media-slider-decor-holder duplicate">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/shell-img-01.png" alt="icon">
                                        </div>
                                        <?php break;
                                    case 'diced': ?>
                                        <div class="media-slider-decor-holder duplicate">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-02.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-07.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-08.png" alt="diced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/diced-img-11.png" alt="diced image">
                                        </div>
                                        <?php break;
                                    case 'slivered': ?>
                                        <div class="media-slider-decor-holder duplicate">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-02.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-04.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-07.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-08.png" alt="slivered image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/slivered-img-09.png" alt="slivered image">
                                        </div>
                                        <?php break;
                                    case 'halved': ?>
                                        <div class="media-slider-decor-holder duplicate">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-02.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-04.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-06.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-07.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-08.png" alt="halved image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/halved-img-09.png" alt="halved image">
                                        </div>
                                        <?php break;
                                    case 'sliced': ?>
                                        <div class="media-slider-decor-holder duplicate">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-02.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-05.png" alt="sliced image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/dist/images/almond-slider/sliced-img-06.png" alt="sliced image">
                                        </div>
                                        <?php break;
                                endswitch; ?>
                                <a href="#"></a>
                            </div>
                            <div class="media-slider-text container">
                                <h4></h4>
                                <?php render( '<div class="buttons-holder centered">', $slide, 'button', '</div>', 'link', 'btn small', '<span>', '</span>' ); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="home-media-nav-holder">
                    <div class="home-media-nav">
                        <?php foreach ($data['animation_slider'] as $slide) : ?>
                            <div class="media-nav-item">
                                <?php
                                render( '<p>', $slide, 'title', '</p>' );
                                render( '<p class="active-title">', $slide, 'title', '</p>'); ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif;