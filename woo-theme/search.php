<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package woo-theme
 */

get_header();
global $wp_query;
$count = ($wp_query->found_posts > 0) ? $wp_query->found_posts : 0; ?>
    <section class="search-result-section indent-bottom indent-top-medium">
        <div class="container">
            <div class="search-result-content">
                <form class="search-result-form" role="search" id="main-search" action="<?php echo home_url( '/' ); ?>" method="get">
                    <div class="feildset">
                        <button type="submit">
                            <?php get_template_part('template-parts/svg/btn-search'); ?>
                        </button>
                        <input type="text" name="s" value="<?php echo (get_search_query()) ?: get_search_query(); ?>" placeholder="Search">
                        <button type="reset">
                            <?php get_template_part('template-parts/svg/btn-close'); ?>
                        </button>
                    </div>
                </form>
                <div class="search-result-amount">
                    <p>
                        <?php echo sprintf(__('Showing <b>%s</b> results for <b>“%s”</b>', 'woo-theme'),
                            $count, get_search_query()
                        ); ?>
                    </p>
                </div>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="search-result-row">
                        <h4><a href="<?php echo get_the_permalink(); ?>"><?php echo relevanssi_the_title(); ?></a></h4>
                        <?php echo relevanssi_the_excerpt(); ?>
                    </div>
                <?php endwhile; ?>
            </div>
            <?php get_template_part('template-parts/global/pagination'); ?>
        </div>
    </section>
<?php get_footer();