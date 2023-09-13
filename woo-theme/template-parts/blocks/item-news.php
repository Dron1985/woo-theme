<?php
$post_id  = (isset($args['post_id']) && !empty($args['post_id'])) ? $args['post_id'] : '';
$category = get_categories_list($post_id);
$image    = get_featured_img_info('medium_large', $post_id);
$img_alt  = (isset($image['alt']) && !empty($image['alt'])) ? $image['alt'] : get_the_title($post_id);
$class    = (isset($args['class']) && !empty($args['class'])) ? $args['class'] : 'news-card small'; ?>
<!-- news-card -->
<article class="<?php echo $class; ?>">
    <?php if (!empty($image['src'])) : ?>
        <div class="news-card-picture">
            <img src="<?php echo $image['src']; ?>" alt="<?php echo $img_alt; ?>">
        </div>
    <?php endif; ?>
    <div class="news-card-text">
        <?php echo (!empty($category)) ? '<strong class="category">'.$category.'</strong>' : ''; ?>
        <h5 class="h5"><?php echo get_the_title($post_id); ?></h5>
    </div>
    <a class="news-card-link" href="<?php echo get_the_permalink($post_id); ?>">&nbsp;</a>
</article>
<!-- news-card end -->