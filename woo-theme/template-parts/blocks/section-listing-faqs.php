<?php
$data = $args['data'] ?? get_fields();
if (!$data) {
    return;
}

if (isset($data['faq_categories']) && !empty($data['faq_categories'])) {
    $terms_ids = $data['faq_categories'];
    $count_posts = get_categories_count( 'faqs', '', get_the_ID());
    $count_posts = (isset($count_posts[0]['count'])) ? $count_posts[0]['count'] : 0;
} else {
    $terms_ids = '';
    $count_posts = wp_count_posts( 'faqs' )->publish;
}

$args = array(
    'post_type'  => 'faqs',
    'fields'     => 'all',
    'orderby'    => 'title',
    'order'      => 'ASC',
    'hide_empty' => false,
    'include'    => $terms_ids,
);

$categories = get_terms(array('category_faqs'), $args);
$search = (isset($_GET['search'])) ? esc_sql($_GET['search']) : '';
$active = (!isset($_GET['category'])) ? 'active' : '';
$classes = ['faq', 'bd-faq-section', 'animation']; ?>

<section class="<?php echo apply_global_classes($classes, $data); ?>">
    <div class="container">
        <div class="two-sides-row faq-inner">
            <div class="left-side">
                <form id="faq-search-form" class="category-form-search" action="#">
                    <div class="feildset">
                        <input type="search" class="bd-key-search" name="search" placeholder="Search" value="<?php echo $search; ?>">
                        <input type="hidden" name="page_id" value="<?php echo get_the_ID(); ?>">
                        <button type="submit" class="btn-search">
                            <?php get_template_part('template-parts/svg/btn-search'); ?>
                        </button>
                    </div>
                </form>
                <div class="faq-categories">
                    <h5><?php _e('Categories', 'woo-theme') ?></h5>
                    <ul class="categories-list">
                        <li class="category-item <?php echo $active; ?>" data-term="all">
                            <span><?php echo __('All', 'woo-theme'); ?></span>
                            <span>(<?php echo $count_posts; ?>)</span>
                        </li>
                        <?php foreach ($categories as $category) :
                            $class = (isset($_GET['category']) && $_GET['category'] == $category->slug) ? 'category-item active' : 'category-item'; ?>
                            <li class="<?php echo $class; ?>" data-term="<?php echo $category->slug; ?>">
                                <span><?php echo $category->name; ?></span>
                                <span>(<?php echo $category->count; ?>)</span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <div class="right-side">
                <ul class="accordion"></ul>
                <div class="buttons-holder hidden">
                    <a href="javascript:void(0)" class="btn small bd-load-more" data-paged="2">
                        <span>
                            <?php get_template_part('template-parts/svg/btn-load-more'); ?>
                            <?php _e('load more', 'woo-theme'); ?>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
