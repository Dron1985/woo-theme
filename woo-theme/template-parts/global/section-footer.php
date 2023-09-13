<?php
$footer  = get_field('fields_footer', 'options');
$contact = (isset($footer['contact_info']) && !empty(array_trim($footer['contact_info']))) ? $footer['contact_info'] : ''; ?>
<footer class="footer">
    <div class="footer-top">
        <div class="container">

            <nav class="footer-nav">
                <ul class="footer-nav-list">
                    <?php foreach ($footer['menu_lists'] as $item) :
                        echo '<li>';
                        if (isset($item['type']) && $item['type'] == 'type3') :
                            wp_nav_menu(array('menu' => $item['menu'], 'menu_class' => '', 'container' => '', 'theme_location' => 'primary-menu', 'fallback_cb' => '__return_empty_string', 'walker'=> new CustomFooterMenuWalker()));
                        else :
                            $class = ($item['type'] == 'type2') ? 'footer-nav-inner two-col' : 'footer-nav-inner'; ?>
                            <?php render('<h6 class="footer-nav-link footer-nav-button">', $item, 'title_link', '</h6>', 'link'); ?>
                            <div class="<?php echo $class; ?>">
                                <?php wp_nav_menu(array('menu' => $item['menu'], 'menu_class' => '', 'container' => '', 'theme_location' => 'primary-menu', 'fallback_cb' => '__return_empty_string')); ?>
                            </div>
                        <?php endif;
                        echo '</li>';
                    endforeach; ?>
                </ul>
            </nav>

            <?php if (!empty($contact)) : ?>
            <div class="footer-contact">
                <?php render('<h6 class="footer-nav-link">', $contact, 'title_link', '</h6>', 'link'); ?>
                <ul>
                    <?php render('<li>', $contact, 'email', '</li>', 'mail', '', '', ''); ?>
                    <?php render('<li>', $contact, 'phone', '</li>', 'tel', '', '', ''); ?>
                    <?php if (isset($contact['address']) && !empty($contact['address'])) : ?>
                        <li>
                            <address>
                                <?php if (isset($contact['location']) && !empty($contact['location'])) : ?>
                                    <a href="<?php echo $contact['location']; ?>" target="_blank"><?php echo $contact['address']; ?></a>
                                <?php else:
                                    echo $contact['address'];
                                endif;?>
                            </address>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-top">
                <?php if (isset($footer['logo']['sizes'])) : ?>
                    <div class="footer-logo">
                        <!-- logo -->
                        <span class="logo">
                            <a href="<?php echo home_url('/'); ?>">
                                <img src="<?php echo $footer['logo']['sizes']['medium']; ?>" alt="<?php echo $footer['logo']['alt']; ?>">
                            </a>
                        </span>
                        <!-- logo end -->
                    </div>
                <?php endif; ?>

                <?php if (isset($footer['form']) && !empty($footer['form'])) :
                    echo do_shortcode('[contact-form-7 id="'.$footer['form'].'" title="Subscribe form" html_class="form-subscribe"]');
                endif; ?>

                <?php if (isset($footer['social_networks']) && !empty($footer['social_networks'])) : ?>
                    <div class="footer-follow">
                        <h5 class="h5"><?php echo __('Follow Us', 'woo-theme'); ?></h5>
                        <ul class="social-list">
                            <?php foreach ($footer['social_networks'] as $item) :
                                if (!empty($item['link']) && !empty($item['svg_code'])) : ?>
                                    <li>
                                        <a href="<?php echo $item['link']; ?>" class="social-btn" aria-label="social button linkedin" target="_blank" rel="nofollow">
                                            <?php echo $item['svg_code']; ?>
                                        </a>
                                    </li>
                                <?php endif;
                            endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
            <div class="footer-bottom-bottom">
                <nav class="footer-add-nav">
                    <?php wp_nav_menu(array('menu' => 'terms-menu', 'menu_class' => '', 'container' => '', 'theme_location' => 'primary-menu', 'fallback_cb' => '__return_empty_string')); ?>
                </nav>
                <?php if (isset($footer['copyright']) && !empty($footer['copyright'])) : ?>
                    <div class="copyright"><?php echo str_replace('%year%', date('Y'), $footer['copyright']); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</footer>