<?php
/**
 *  Template Name: Text template
 **/

get_header();
while (have_posts()): the_post(); ?>
    <section class="simple-hero indent-top-medium middle-title">
        <div class="container">
            <div class="section-info">
                <?php if (get_field('show_author') == true) : ?>
                    <div class="article-category"><span><?php echo get_author_full_name(get_the_ID()); ?></span></div>
                <?php endif; ?>
                <h1 class="h2"><?php the_title(); ?></h1>
            </div>
        </div>
    </section>
    <section class="article-template indent-bottom">
        <div class="container">
            <div class="content">
                <?php the_content(); ?>
            </div>
        </div>
    </section>
<?php endwhile;
get_footer();
