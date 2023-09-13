<?php
$prev_link = '<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 9H2M2 9L9.875 1.5M2 9L9.875 16.5" stroke="#151B20" stroke-width="1.5"></path></svg>';
$next_link = '<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 9H18M18 9L10.125 1.5M18 9L10.125 16.5" stroke="#151B20" stroke-width="1.5"></path></svg>';

/**
 * ajax load events
 */
function load_news() {
    check_ajax_referer('posts_filter_nonce');
    parse_str($_POST['data_attr'], $output);
    $term = (isset($_POST['term'])) ? $_POST['term'] : '';
    $paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;

    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 12,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'paged'          => $paged
    );

    if (!empty($term) && $term != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'slug',
                'terms'    => esc_sql($term)
            )
        );
    }

    ob_start();
    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        $i = 1;
        while ($query->have_posts()) : $query->the_post();
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
        echo '<span class="no-results">'. __('Sorry, results not found!', 'woo-theme').'</span>';
    endif;

    $return['content'] = ob_get_contents();
    ob_clean();

    if ($query->max_num_pages > 1) {
        global $prev_link;
        global $next_link;
        $page_id = get_option( 'page_for_posts' );
        $link = get_the_permalink($page_id);
        $base = $link . '%_%';

        $query_args = array();
        if (!empty($query_args)) {
            $base = add_query_arg($query_args, $base);
        }

        $args = array(
            'base' => $base,
            'format' => (!empty($term) && $term != 'all') ? '?category='.$term : '',
            'total' => $query->max_num_pages,
            'current' => max(1, $paged),
            'mid_size' => 1,
            'prev_text' => $prev_link,
            'next_text' => $next_link,
        );
        $pagination = '<div class="line-wrap"><div class="pagination">'.paginate_links_new($args).'</div></div>';
    }
    else {
        $pagination = '';
    }

    $return['pagination'] = $pagination;
    ob_get_clean();
    wp_reset_postdata();

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_news', 'load_news');
add_action('wp_ajax_nopriv_load_news', 'load_news');


/**
 * Ajax load FAQ.
 */
function load_faq() {
    check_ajax_referer('faq_filter_nonce');
    parse_str($_POST['data_attr'], $output);
    $term = (isset($_POST['term'])) ? $_POST['term'] : '';
    $paged = (isset($_POST['paged'])) ? $_POST['paged'] : 1;
    $field = get_acf_field_gutenberg($output['page_id'], 'section-listing-faqs');
    $terms_ids = (isset($field['faq_categories']) && !empty($field['faq_categories'])) ? $field['faq_categories'] : '';

    $args = array(
        'post_type'      => 'faqs',
        'posts_per_page' => 7,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'orderby'        => 'menu_order',
        'paged'          => $paged
    );

    if (!empty($term) && $term != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category_faqs',
                'field'    => 'slug',
                'terms'    => esc_sql($term)
            )
        );
    } elseif (!empty($terms_ids)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category_faqs',
                'field'    => 'id',
                'terms'    => $terms_ids,
                'operator' => 'IN'
            )
        );
    }

    if (isset($output['search']) && !empty($output['search'])) {
        $args['s'] = $output['search'];
    }

    ob_start();
    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        $i = 1;
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $active = ($paged == 1 && $i == 1) ? 'active' : '';
            get_template_part('template-parts/blocks/item','faq', ['post_id' => $post->ID, 'active' => $active]);
            $i++;
        endwhile;
        wp_reset_postdata();
    else:
        echo '<span class="no-results">'. __('Sorry, results not found!', 'woo-theme').'</span>';
    endif;

    $return['content'] = ob_get_contents();
    ob_clean();

    if ($query->max_num_pages > 1 && $query->max_num_pages > $paged) {
        $pagination = $paged+1;
    } else {
        $pagination = 0;
    }

    $return['button'] = $pagination;
    ob_get_clean();

    if (!empty($output['search']) || isset($_POST['term_update'])) {
        $categories = get_categories_count('faqs', $output['search'], $output['page_id']);
        if (!empty($categories)) :
            foreach ($categories as $category) :
                if (empty($term) || $term == 'all') {
                    $class = ($category['slug'] == 'all') ? 'category-item active' : 'category-item';
                } else {
                    $class = ($term == $category['slug']) ? 'category-item active' : 'category-item';
                } ?>
                <li class="<?php echo $class; ?>" data-term="<?php echo $category['slug']; ?>">
                    <span><?php echo $category['name']; ?></span>
                    <span>(<?php echo $category['count']; ?>)</span>
                </li>
            <?php endforeach;
        endif;

        $return['terms'] = ob_get_contents();
        ob_get_clean();
    }

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_faq', 'load_faq');
add_action('wp_ajax_nopriv_load_faq', 'load_faq');


/**
 * ajax load products
 */
function load_products() {
    //check_ajax_referer('product_filter_nonce');
    parse_str($_POST['data_attr'], $output);
    $term = (isset($_POST['term'])) ? $_POST['term'] : '';

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'order'          => 'DESC',
        'orderby'        => 'menu_order'
    );

    if (!empty($term) && $term != 'all') {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => esc_sql($term)
            )
        );
    }

    ob_start();
    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post(); ?>
            <li <?php wc_product_cat_class( '', $term ); ?>>
                <div class="product-picture">
                    <?php
                    do_action( 'woocommerce_before_shop_loop_item' );
                    do_action( 'woocommerce_before_shop_loop_item_title' );
                    ?>
                </div>

                <div class="product-text">
                    <?php
                    do_action( 'woocommerce_shop_loop_item_title' );
                    do_action( 'woocommerce_after_shop_loop_item_title' );
                    do_action( 'woocommerce_after_shop_loop_item' );
                    ?>
                </div>
            </li>
            <?php
        endwhile;
    else:
        echo '<span class="no-results">'. __('Sorry, results not found!', 'woo-theme').'</span>';
    endif;

    $return['content'] = ob_get_contents();
    ob_get_clean();
    wp_reset_postdata();

    wp_send_json($return);
    die();
}
add_action('wp_ajax_load_products', 'load_products');
add_action('wp_ajax_nopriv_load_products', 'load_products');