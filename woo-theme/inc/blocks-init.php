<?php

/**
 * ACF Block Helper class
 * Get all fields of block by block name
 */
class BlockHelper
{
    var $block_name;
    var $post_id;

    function __construct($block_name, $post_id)
    {
        $this->block_name = $block_name;
        $this->post_id = $post_id;

    }

    public function getBlockFields()
    {
        $post = get_post($this->post_id);

        if (!$post) return false;

        $blocks = parse_blocks($post->post_content);

        foreach ($blocks as $block) {

            if (!isset($block['attrs']['name'])) continue;

            if ($block['attrs']['name'] != $this->block_name) continue;

            acf_setup_meta($block['attrs']['data'], $block['attrs']['id'], true);

            $fields = get_fields();

            acf_reset_meta($block['attrs']['id']);

            return $fields;
        }

        return false;
    }
}

/**
 * Add new categories for blocks
 */
add_filter('block_categories_all', 'new_block_categories', 10, 2);
function new_block_categories($block_categories, $block_editor_context)
{
    return array_merge(
        $block_categories,
        array(
            array(
                'slug' => 'global',
                'title' => __('Global (used on a lot page templates)', 'woo-theme'),
            ),
            array(
                'slug' => 'product',
                'title' => __('Coupling / Tools & Parts', 'woo-theme'),
            ),
            array(
                'slug' => 'single',
                'title' => __('Single block (used on single pages)', 'woo-theme'),
            ),
        )
    );
}

/**
 * Callback block render,
 * return preview image
 */
function block_render($block, $content = '', $is_preview = false) {
    /**
     * Back-end preview
     */
    if ($is_preview && !empty($block['data'])) {
        echo $block['data']['image'];
        return;
    }
    else {
        if ($block) :
            $template = $block['render_template'];
            $template = str_replace('.php', '', $template);
            get_template_part('/' . $template, NULL, ['block' => $block, 'anchor' => $block['anchor'] ?? '']);
        endif;
    }
}

/**
 * Register new ACF blocks
 *
 */
add_action('acf/init', 'my_acf_init_block_types');
function my_acf_init_block_types()
{
    $post_types = ['page','wholesale-products', 'post', 'product'];

    if (function_exists('acf_register_block_type')) {

        $blocks_list = [

            //About us
            [
                'name' => 'section-hero',
                'title' => __('Hero section', 'woo-theme'),
                'template' => 'template-parts/blocks/section-hero.php',
                'category' => 'global',
                'img_prev' => 'preview-section-hero.jpg',
                'keywords' => ['hero', 'section'],
                'post_types' => $post_types,
                'multiple' => true,
            ],

	        [
		        'name'       => 'section-green',
		        'title'      => __( 'Green Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-green.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-green.jpg',
		        'keywords'   => [ 'green', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-hero-products',
		        'title'      => __( 'Hero products section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-hero-products.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-products-hero.jpg',
		        'keywords'   => [ 'hero', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-shelf',
		        'title'      => __( 'Shelf section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-shelf.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-shelf.jpg',
		        'keywords'   => [ 'shelf', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-cooking',
		        'title'      => __( 'Cooking section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-cooking.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-cooking.jpg',
		        'keywords'   => [ 'cooking', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-collaboration',
		        'title'      => __( 'Collaboration section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-collaboration.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-collaboration.jpg',
		        'keywords'   => [ 'collaboration', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-more-items',
		        'title'      => __( 'More items section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-more-items.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-more-items.jpg',
		        'keywords'   => [ 'more', 'section', 'items' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-order',
		        'title'      => __( 'Order section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-order.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-order.jpg',
		        'keywords'   => [ 'order', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-logos',
		        'title'      => __( 'Logos section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-logos.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-logos.jpg',
		        'keywords'   => [ 'logos', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

            [
                'name'       => 'section-diversity',
                'title'      => __( 'Diversity section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-diversity.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-diversity.jpg',
                'keywords'   => [ 'diversity' ],
                'post_types' => ['page'],
                'multiple'   => true,
            ],

	        [
		        'name'       => 'section-hero-slider',
		        'title'      => __( 'Hero slider', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-hero-slider.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-hero-slider.jpg',
		        'keywords'   => [ 'hero', 'section', 'slider' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-loop-products',
		        'title'      => __( 'Loop wholesale', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-loop-products.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-loop-products.jpg',
		        'keywords'   => [ 'products', 'section', 'loop', 'wholesale' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-more-products',
		        'title'      => __( 'Relationship Products', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-more-products.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-more-products.jpg',
		        'keywords'   => [ 'more', 'section', 'products' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-more-product',
		        'title'      => __( 'Single Product', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-more-product.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-more-product.jpg',
		        'keywords'   => [ 'more', 'section', 'product' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'section-three-img',
		        'title'      => __( 'Text/image/number', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-three-img.php',
		        'category'   => 'global',
		        'img_prev'   => 'preview-section-three-img.jpg',
		        'keywords'   => [ 'three', 'section', 'image' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

            [
                'name'       => 'section-four-cards',
                'title'      => __('Four cards section', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-four-cards.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-four-cards.jpg',
                'keywords'   => ['video', 'cards'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-video',
                'title'      => __('Video section', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-video.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-video.jpg',
                'keywords'   => ['video'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-health-icons',
                'title'      => __('Health icons', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-health-icons.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-health-icons.jpg',
                'keywords'   => ['health', 'icons'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-columned-table',
                'title'      => __('Columned table (Tabs)', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-columned-table.php',
                'category'   => 'global',
                'img_prev'   => 'preview-columned-table.jpg',
                'keywords'   => ['tabs', 'table'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-table-2rows',
                'title'      => __('Table 2 rows (Tabs)', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-table-2rows.php',
                'category'   => 'global',
                'img_prev'   => 'preview-table-2rows.jpg',
                'keywords'   => ['tabs', 'table'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-quality',
                'title'      => __('Quality section', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-quality.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-quality.jpg',
                'keywords'   => ['quality', 'table'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-table-html',
                'title'      => __('Table section (HTML)', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-table-html.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-table-html.jpg',
                'keywords'   => ['html', 'table'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-our-partners',
                'title'      => __('Our partners', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-our-partners.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-our-partners.jpg',
                'keywords'   => ['partners', 'logo'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-featured-news',
                'title'      => __( 'Featured news section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-featured-news.php',
                'category'   => 'global',
                'img_prev'   => 'preview-featured-news.jpg',
                'keywords'   => [ 'featured', 'news', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-featured-blogs',
                'title'      => __('Featured blogs', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-featured-blogs.php',
                'category'   => 'global',
                'img_prev'   => 'preview-featured-blogs.jpg',
                'keywords'   => ['article', 'blog'],
                'post_types' => $post_types,
                'multiple'   => TRUE,
            ],

            [
                'name'       => 'section-listing-news',
                'title'      => __( 'Listing News & Insights', 'woo-theme' ),
                'template'   => 'template-parts/blocks/listing-news.php',
                'category'   => 'global',
                'img_prev'   => 'preview-listing-news.jpg',
                'keywords'   => ['listing', 'news', 'insights' ],
                'post_types' => $post_types,
                'multiple'   => false,
            ],

            [
                'name'       => 'section-listing-faqs',
                'title'      => __('FAQs listing', 'woo-theme'),
                'template'   => 'template-parts/blocks/section-listing-faqs.php',
                'category'   => 'global',
                'img_prev'   => 'preview-section-listing-faqs.jpg',
                'keywords'   => ['listing', 'FAQs'],
                'post_types' => $post_types,
                'multiple'   => FALSE,
                'assets'     => 'faqs_js_library',
            ],

            [
                'name'       => 'section-listing-products',
                'title'      => __( 'Listing Products (only shop page)', 'woo-theme' ),
                'template'   => 'template-parts/blocks/listing-products.php',
                'category'   => 'global',
                'img_prev'   => 'preview-listing-products.jpg',
                'keywords'   => ['listing', 'products' ],
                'post_types' => $post_types,
                'multiple'   => false,
            ],

            [
                'name'       => 'section-know-more',
                'title'      => __( 'Know more section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-know-more.php',
                'category'   => 'global',
                'img_prev'   => 'preview-know-more.jpg',
                'keywords'   => ['know', 'more', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-food-safety',
                'title'      => __( 'Food Safety/Facilities section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-food-safety.php',
                'category'   => 'global',
                'img_prev'   => 'preview-food-safety.jpg',
                'keywords'   => ['food', 'safety', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-sustainability',
                'title'      => __( 'Sustainability section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-sustainability.php',
                'category'   => 'global',
                'img_prev'   => 'preview-sustainability.jpg',
                'keywords'   => ['sustainability', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-wholesale-nuts',
                'title'      => __( 'Wholesale Rotating Nuts section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-wholesale-nuts.php',
                'category'   => 'global',
                'img_prev'   => 'preview-sustainability.jpg',
                'keywords'   => ['wholesale', 'nuts', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-discount-notice',
                'title'      => __( 'Discount notice section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-discount-notice.php',
                'category'   => 'global',
                'img_prev'   => 'preview-discount-notice.jpg',
                'keywords'   => ['discount', 'notice', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            //Single blocks
            [
                'name'       => 'section-text-quote',
                'title'      => __( 'Article quote section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-text-quote.php',
                'category'   => 'single',
                'img_prev'   => 'preview-text-quote.jpg',
                'keywords'   => [ 'article', 'quote', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-article-slider',
                'title'      => __( 'Article slider section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-article-slider.php',
                'category'   => 'single',
                'img_prev'   => 'preview-article-slider.jpg',
                'keywords'   => [ 'article', 'slider', 'gallery', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-gallery',
                'title'      => __( 'Gallery section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-gallery.php',
                'category'   => 'single',
                'img_prev'   => 'preview-section-gallery.jpg',
                'keywords'   => ['slider', 'gallery'],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            [
                'name'       => 'section-get-in-touch',
                'title'      => __( 'Get In Touch section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-get-in-touch.php',
                'category'   => 'single',
                'img_prev'   => 'preview-get-in-touch.jpg',
                'keywords'   => [ 'get', 'in', 'touch', 'section' ],
                'post_types' => ['page', 'wholesale-products', 'product'],
                'multiple'   => true,
            ],

            [
                'name'       => 'section-upcoming-reports',
                'title'      => __( 'Upcoming reports section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-upcoming-reports.php',
                'category'   => 'single',
                'img_prev'   => 'preview-upcoming-reports.jpg',
                'keywords'   => [ 'upcoming', 'reports', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

            //Products section
            [
                'name'       => 'section-benefits',
                'title'      => __( 'Benefits section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-benefits.php',
                'category'   => 'single',
                'img_prev'   => 'preview-benefits.jpg',
                'keywords'   => [ 'benefits', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],

	        [
		        'name'       => 'specification-sheet-tabs',
		        'title'      => __( 'Specification Sheet Tabs section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/specification-sheet-tabs.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-specification-sheet-tabs.jpg',
		        'keywords'   => [ 'preview', 'specification', 'sheet', 'tabs', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'packaging-section',
		        'title'      => __( 'Packaging section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/packaging-section.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-packaging-section.jpg',
		        'keywords'   => [ 'packaging', 'table', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'shelf-life',
		        'title'      => __( 'Tabs Table Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/shelf-life.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-shelf-life.jpg',
		        'keywords'   => [ 'shelf', 'life', 'section', 'tabs', 'table' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'testimonial-section',
		        'title'      => __( 'Testimonial Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/testimonial-section.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-testimonial-section.jpg',
		        'keywords'   => [ 'about', 'testimonial', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'what-we-do',
		        'title'      => __( 'What We Do Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-what-we-do.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-what-we-do.jpg',
		        'keywords'   => [ 'what', 'we', 'do', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'map-section',
		        'title'      => __( 'Map Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-map.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-map-section.jpg',
		        'keywords'   => [ 'map', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'our-story',
		        'title'      => __( 'Our Story', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-our-story.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-our-story.jpg',
		        'keywords'   => [ 'our', 'story' , 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'season-section',
		        'title'      => __( 'Season Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-season.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-season-section.jpg',
		        'keywords'   => [ 'season', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'review-section',
		        'title'      => __( 'Review Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-review.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-review-section.jpg',
		        'keywords'   => [ 'review', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'icon-list-section',
		        'title'      => __( 'Icon List Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-icon-list.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-icon-list-section.jpg',
		        'keywords'   => [ 'icon', 'list', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'bulleted-list-section',
		        'title'      => __( 'Bulleted List Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-bulleted-list.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-bulleted-list-section.jpg',
		        'keywords'   => [ 'list', 'bullet', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'proof-numbers-section',
		        'title'      => __( 'Proof Numbers Section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-proof-numbers.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-proof-numbers-section.jpg',
		        'keywords'   => [ 'proof', 'numbers', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

	        [
		        'name'       => 'contact-us',
		        'title'      => __( 'Contact Us section', 'woo-theme' ),
		        'template'   => 'template-parts/blocks/section-contact-us.php',
		        'category'   => 'single',
		        'img_prev'   => 'preview-contact-us.jpg',
		        'keywords'   => [ 'us', 'contact', 'section' ],
		        'post_types' => $post_types,
		        'multiple'   => true,
	        ],

            [
                'name'       => 'section-divider',
                'title'      => __( 'Divider section', 'woo-theme' ),
                'template'   => 'template-parts/blocks/section-divider.php',
                'category'   => 'global',
                'img_prev'   => 'preview-divider.jpg',
                'keywords'   => [ 'divider', 'section' ],
                'post_types' => $post_types,
                'multiple'   => true,
            ],
        ];

        foreach ($blocks_list as $block) {
            acf_register_block_type([
                'name' => $block['name'],
                'title' => $block['title'],
                'description' => '',
                'render_template' => $block['template'],
                'category' => $block['category'],
                'icon' => '<svg class="block-default" width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19 8h-1V6h-5v2h-2V6H6v2H5c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2zm.5 10c0 .3-.2.5-.5.5H5c-.3 0-.5-.2-.5-.5v-8c0-.3.2-.5.5-.5h14c.3 0 .5.2.5.5v8z"></path></svg><svg class="eye" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M15 12c0 1.654-1.346 3-3 3s-3-1.346-3-3 1.346-3 3-3 3 1.346 3 3zm9-.449s-4.252 8.449-11.985 8.449c-7.18 0-12.015-8.449-12.015-8.449s4.446-7.551 12.015-7.551c7.694 0 11.985 7.551 11.985 7.551zm-7 .449c0-2.757-2.243-5-5-5s-5 2.243-5 5 2.243 5 5 5 5-2.243 5-5z"/></svg><span class="block-preview hidden" style="background-image: url(' . get_template_directory_uri() . '/inc/block-previews/' . $block['img_prev'] . ')" /></span><svg class="eye-close none" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><defs><style>.cls-1{fill:#fff;opacity:0;}.cls-2{fill:#231f20;}</style></defs><title>eye-off</title><g id="Layer_2" data-name="Layer 2"><g id="eye-off"><g id="eye-off-2" data-name="eye-off"><rect class="cls-1" width="24" height="24"/><circle class="cls-2" cx="12" cy="12" r="1.5"/><path class="cls-2" d="M15.29,18.12,14,16.78l-.07-.07-1.27-1.27a4.07,4.07,0,0,1-.61.06A3.5,3.5,0,0,1,8.5,12a4.07,4.07,0,0,1,.06-.61l-2-2L5,7.87A15.89,15.89,0,0,0,2.13,11.5a1,1,0,0,0,0,1c.63,1.09,4,6.5,9.89,6.5h.25a9.48,9.48,0,0,0,3.23-.67Z"/><path class="cls-2" d="M8.59,5.76l2.8,2.8A4.07,4.07,0,0,1,12,8.5,3.5,3.5,0,0,1,15.5,12a4.07,4.07,0,0,1-.06.61l2.68,2.68.84.84a15.89,15.89,0,0,0,2.91-3.63,1,1,0,0,0,0-1c-.64-1.11-4.16-6.68-10.14-6.5a9.48,9.48,0,0,0-3.23.67Z"/><path class="cls-2" d="M20.71,19.29,19.41,18l-2-2L7.89,6.47,6.42,5,4.71,3.29A1,1,0,0,0,3.29,4.71L5.53,7,7.28,8.7,14.59,16l.07.07L16,17.41l.59.59,2.7,2.71a1,1,0,0,0,1.42,0A1,1,0,0,0,20.71,19.29Z"/></g></g></g></svg>',
                'mode' => 'edit',
                'render_callback' => 'block_render',
                'example' => [
                    'attributes' => [
                        'mode' => 'preview',
                        'data' => [
                            'image' => '<img src="' . get_template_directory_uri() . '/inc/block-previews/' . $block['img_prev'] . '" style="display: block; margin: 0 auto; width: 450px; height: auto;">',
                        ],
                    ],
                ],
                'supports' => [
                    'mode' => FALSE,
                    'multiple' => $block['multiple'],
                    'align' => FALSE,
                    "anchor" => TRUE,
                ],
                'keywords' => $block['keywords'],
                'post_types' => $block['post_types'],
                'enqueue_assets' => $block['assets'] ?? '',
            ]);
        }
    }
}

/**
 * Set allowed Gutenberg blocks
 *
 */
add_filter('allowed_block_types_all', 'theme_allowed_block_types', 99, 2);
function theme_allowed_block_types($block_editor_context, $editor_context)
{
    $block_editor_context = array(
        'core/paragraph',
        'core/paragraph',
        'core/heading',
        'core/list',
        'core/list-item',
        'core/freeform',
        'core/html',
        'core/image',
        'core/shortcode',
        'core/quote',
        'core/embed',
        'acf/section-text-quote',
        'acf/section-article-slider'
    );

    if (!empty($editor_context->post)) {
        $post_types = ['post'];
        if (($editor_context->post->post_type == 'page' && in_array(basename(get_page_template()), ['page-text.php']))
            || in_array($editor_context->post->post_type, $post_types)) {
            $block_editor_context = array(
                'core/paragraph',
                'core/heading',
                'core/list',
                'core/list-item',
                'core/freeform',
                'core/html',
                'core/image',
                'core/shortcode',
                'core/quote',
                'core/embed',
	            'acf/section-hero-slider',
                'acf/section-text-quote',
                'acf/section-article-slider',
                'acf/section-get-in-touch',
                'acf/section-benefits',
                'acf/section-upcoming-reports',
                'acf/section-featured-news',
                'acf/section-divider'
            );
        }
	    if ($editor_context->post->post_type == 'page') {
		    $block_editor_context = array(
			    'core/paragraph',
			    'core/heading',
			    'core/list',
			    'core/list-item',
			    'core/freeform',
			    'core/html',
			    'core/image',
			    'core/shortcode',
			    'core/quote',
			    'core/embed',
                'acf/section-hero',
			    'acf/section-hero-slider',
			    'acf/section-loop-products',
			    'acf/section-more-products',
			    'acf/section-more-product',
			    'acf/section-three-img',
                'acf/section-video',
                'acf/section-four-cards',
                'acf/section-health-icons',
                'acf/section-text-quote',
                'acf/section-article-slider',
                'acf/section-gallery',
                'acf/section-get-in-touch',
			    'acf/testimonial-section',
			    'acf/what-we-do',
                'acf/section-benefits',
			    'acf/map-section',
			    'acf/section-collaboration',
			    'acf/our-story',
			    'acf/season-section',
			    'acf/section-logos',
                'acf/section-our-partners',
			    'acf/section-more-items',
			    'acf/section-green',
			    'acf/section-collaboration',
			    'acf/section-order',
			    'acf/review-section',
			    'acf/icon-list-section',
                'acf/section-upcoming-reports',
                'acf/section-featured-news',
                'acf/section-featured-blogs',
			    'acf/icon-list-section',
			    'acf/bulleted-list-section',
                'acf/section-diversity',
			    'acf/gallery-section',
			    'acf/proof-numbers-section',
                'acf/section-listing-news',
                'acf/section-listing-faqs',
                'acf/section-listing-products',
                'acf/section-know-more',
                'acf/section-food-safety',
                'acf/section-columned-table',
                'acf/section-table-2rows',
                'acf/section-table-html',
                'acf/section-quality',
                'acf/section-sustainability',
                'acf/section-wholesale-nuts',
			    'acf/contact-us',
                'acf/section-shelf',
                'acf/section-discount-notice',
			    'acf/packaging-section',
                'acf/section-divider'
		    );
	    }
	    if ($editor_context->post->post_type == 'wholesale-products') {
		    $block_editor_context = array(
			    'core/paragraph',
			    'core/heading',
			    'core/list',
			    'core/list-item',
			    'core/freeform',
			    'core/html',
			    'core/image',
			    'core/shortcode',
			    'core/quote',
			    'core/embed',
			    'acf/section-green',
			    'acf/section-hero-products',
			    'acf/section-shelf',
			    'acf/section-cooking',
			    'acf/section-collaboration',
			    'acf/section-more-items',
			    'acf/section-order',
			    'acf/section-logos',
			    'acf/specification-sheet-tabs',
			    'acf/packaging-section',
			    'acf/shelf-life'
		    );
	    }

        if ($editor_context->post->post_type == 'product') {
            $block_editor_context = array(
                'acf/section-green',
                'acf/section-cooking',
                'acf/section-more-items',
                'acf/section-benefits',
                'acf/section-order'
            );
        }

    }

    return $block_editor_context;
}

/**
 * @param array $class
 *  Block classes list.
 *
 * @return string
 */
function apply_global_classes(array $class, array $data)
{
	$classes = [];
	$classes += $class;
	$data    = $data ?: get_fields();

	if ( isset( $data['indent_top'] ) && $data['indent_top'] !== 'none' ) {
		$classes[] = $data['indent_top'];
	}
	if ( isset( $data['indent_bottom'] ) && $data['indent_bottom'] !== 'none' ) {
		$classes[] = $data['indent_bottom'];
	}

	return implode( ' ', $classes );
}