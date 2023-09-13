<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package woo-theme
 */

get_header();
$date = get_the_date('F d, Y');
$category = get_categories_list(get_the_ID(), 'single');
$category_ = (!empty($category)) ? ' • '.$category : ''; ?>
    <section class="simple-hero indent-top-medium middle-title">
        <div class="container">
            <div class="section-info">
                <div class="article-category"><?php echo $date . $category_; ?></div>
                <h1 class="h2"><?php the_title(); ?></h1>
            </div>
        </div>
    </section>
    <section class="article-template indent-bottom">
        <div class="container">
            <?php get_template_part('template-parts/global/section', 'share', array('class' => 'responsive')); ?>
            <div class="content">
                <?php while (have_posts()) : the_post();
                    the_content();
                endwhile; ?>
                <?php echo get_project_tags(get_the_ID()); ?>
            </div>
            <?php get_template_part('template-parts/global/section-share'); ?>
        </div>
    </section>
    <?php
    get_template_part('template-parts/blocks/section', 'upcoming-reports');
    get_template_part('template-parts/blocks/section', 'more-items');
    get_template_part('template-parts/blocks/section','get-in-touch');
get_footer();