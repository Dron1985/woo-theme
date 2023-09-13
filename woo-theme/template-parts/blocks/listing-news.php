<?php
$args = array(
    'post_type'  => 'post',
    'fields'     => 'all',
    'orderby'    => 'title',
    'order'      => 'ASC',
    'exclude'    => array(1, 46),
    'hide_empty' => true
);

$categories = get_terms(array('category'), $args);
$data = $args['data'] ?? get_fields();
if (!$data) {
    return;
}

$classes = [ 'news-section animation' ];
if (is_home()) :
    $class = (!isset($_GET['category'])) ? 'btn small has-border active' : 'btn small has-border'; ?>
    <section class="<?php echo apply_global_classes( $classes, $data ); ?>">
        <div class="container">
            <div class="news-filters line-wrap">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="<?php echo $class; ?>" data-term="all">
                            <span>all</span>
                        </a>
                    </li>
                    <?php foreach ($categories as $category) :
                        $class_active = (isset($_GET['category']) && $_GET['category'] == $category->slug) ? 'btn small has-border active' : 'btn small has-border'; ?>
                        <li>
                            <a href="javascript:void(0)" class="<?php echo $class_active; ?>" data-term="<?php echo $category->slug; ?>">
                                <span><?php echo $category->name; ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="news-holder listing-news">
                <?php
                if (have_posts()) :
                    $i = 1;
                    while (have_posts()) : the_post();
                        global $post;
                        switch ($i) {
                            case 1:
                            case 6:
                            case 7:
                            case 12:
                                $class = 'news-card small';
                                break;
                            case 2:
                            case 4:
                            case 8:
                            case 10:
                                $class = 'news-card big';
                                break;
                            case 3:
                            case 5:
                            case 9:
                            case 11:
                                $class = 'news-card medium';
                                break;
                        }
                        get_template_part('template-parts/blocks/item','news', ['post_id' => $post->ID, 'class' => $class]);
                    $i++;
                    endwhile;
                else:
                    echo '<span class="no-results">Sorry, results not found!</span>';
                endif; ?>
            </div>

            <div class="news-pagination">
                <?php global $wp_query;
                if ($wp_query->max_num_pages > 1) : ?>
                    <div class="line-wrap">
                        <?php get_template_part('template-parts/global/pagination');?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif;
