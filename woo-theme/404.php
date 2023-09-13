<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package woo-theme
 */

get_header();
    $fields = get_field('fields_404', 'option');
    if (!empty(array_filter($fields))) : ?>
        <div class="error-page indent-top indent-bottom">
            <div class="container">
                <?php render('<p class="sub-title">', $fields, 'subtitle', '</p>', 'text', '', '', ''); ?>
                <?php render('<h1>', $fields, 'title', '</h1>', 'text', '', '', ''); ?>
                <div class="buttons">
                    <div class="buttons-holder centered">
                        <!-- button -->
                        <?php if (isset($fields['text_btn']) && !empty($fields['text_btn'])) : ?>
                            <a class="btn " href="<?php echo home_url('/'); ?>">
                                <span><?php echo $fields['text_btn']; ?></span>
                            </a>
                        <?php endif; ?>
                        <!-- button end -->
                    </div>
                </div>
            </div>
        </div>
    <?php endif;
get_footer();