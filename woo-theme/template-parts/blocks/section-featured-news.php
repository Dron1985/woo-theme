<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
	return;
}
$classes = ['featured-news animation'];

if (is_empty($data, ['featured_posts'])): ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <div class="container">
            <div class="news-holder">
                <?php $i = 1;
                foreach ($data['featured_posts'] as $news) :
                    $category = get_categories_list($news->ID);
                    $image = get_featured_img_info('large', $news->ID);
                    $img_alt = (!empty($image['alt'])) ? $image['alt'] : get_the_title($news->ID);
                    $class = ($i == 1) ? 'news-card large' : 'news-card medium'; ?>
                    <!-- news-card -->
                    <article class="<?php echo $class; ?>">
                        <div class="news-card-picture">
                            <?php if (!empty($image['src'])) : ?>
                                <img src="<?php echo $image['src']; ?>" alt="<?php echo $img_alt; ?>">
                            <?php endif; ?>
                        </div>
                        <div class="news-card-text">
                            <?php if (!empty($category)) : ?>
                                <strong class="category"><?php echo $category; ?></strong>
                            <?php endif; ?>
                            <h4><?php echo get_the_title($news->ID); ?></h4>
                        </div>
                        <a class="news-card-link" href="<?php echo get_the_permalink($news->ID); ?>">&nbsp;</a>
                    </article>
                    <!-- news-card end -->
                <?php $i++; endforeach; ?>
            </div>
        </div>
    </section>
<?php endif;