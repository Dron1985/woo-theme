<?php
$header = get_field('fields_header', 'options');
$class = (get_field('use_white_color') == true && !is_search()) ? 'header white' : 'header'; ?>
<header class="<?php echo $class; ?>">
    <div class="header-holder">
        <div class="header-top">
            <div class="container">
                <div class="header-logo-row">
                    <?php if (isset($header['logo']['sizes'])) : ?>
                        <!-- logo -->
                        <span class="logo">
                            <a href="<?php echo home_url('/'); ?>">
                                <img src="<?php echo $header['logo']['sizes']['medium']; ?>" alt="<?php echo $header['logo']['alt']; ?>" data-no-lazy="1">
                            </a>
                        </span>
                        <!-- logo end -->
                    <?php endif; ?>
                    <button class="btn-menu">&nbsp;</button>
                </div>
                <?php wp_nav_menu(array('menu' => 'header-submenu', 'menu_class' => 'header-add-links', 'container' => '', 'theme_location' => 'primary-menu', 'fallback_cb' => '__return_empty_string', 'walker'=> new CustomSubMenuWalker())); ?>
            </div>
        </div>
        <div class="header-bottom animation">
            <div class="container">
                <button class="back">
                    <?php get_template_part('template-parts/svg/icon-back'); ?>
                    <?php echo __('Back', 'woo-theme'); ?>
                </button>
                <nav class="header-nav">
                    <?php wp_nav_menu(array('menu' => 'header-menu-left', 'menu_class' => '', 'container' => '', 'theme_location' => 'primary-menu', 'fallback_cb' => '__return_empty_string', 'walker'=> new CustomMenuWalker())); ?>
                    <?php wp_nav_menu(array('menu' => 'header-menu-right', 'menu_class' => '', 'container' => '', 'theme_location' => 'primary-menu', 'fallback_cb' => '__return_empty_string', 'walker'=> new CustomMenuWalker())); ?>
                </nav>
            </div>
        </div>
    </div>
</header>