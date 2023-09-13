<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package woo-theme
 */

/**
 * Hide Comments from Admin panel
 *
 */
add_action('admin_menu', 'remove_menu');
function remove_menu() {
  remove_menu_page('edit-comments.php');
}

/**
 * Disable wp-emoji script
 *
 */
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

/**
 * Disable wlwmanifest_link in HEAD
 *
 */
remove_action('wp_head', 'wlwmanifest_link');

/**
 * Remove wordpress version in HEAD
 *
 */
function remove_version_info() {
  return '';
}

add_filter('the_generator', 'remove_version_info');

/**
 * Remove post shortlink in HEAD
 *
 */
remove_action('wp_head', 'wp_shortlink_wp_head');

/**
 * Remove links to the extra feeds such as category feeds
 *
 */
remove_action('wp_head', 'feed_links_extra', 3);

/**
 * Remove feeds: Post and Comment Feed
 *
 */
remove_action('wp_head', 'feed_links', 2);

/**
 * Remove rsd link from HEAD
 *
 */
remove_action('wp_head', 'rsd_link');

/**
 * Disable DNS pre-fetch
 *
 */
remove_action('wp_head', 'wp_resource_hints', 2);

/**
 * Allow SVG through WordPress Media Uploader
 *
 */
add_filter('upload_mimes', 'cc_mime_types');
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
  global $wp_version;
  if ($wp_version == '4.7' || ((float) $wp_version < 4.7)) {
    return $data;
  }
  $filetype = wp_check_filetype($filename, $mimes);

  return [
    'ext' => $filetype['ext'],
    'type' => $filetype['type'],
    'proper_filename' => $data['proper_filename'],
  ];
}, 10, 4);
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';

  return $mimes;
}

/**
 * Save ACF group to json file
 *
 */
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point($path) {
  // update path
  $path = get_stylesheet_directory() . '/acf-json';
  // return
  return $path;
}

/**
 * Load ACF group from json file
 *
 */
add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point($paths) {
  // remove original path (optional)
  unset($paths[0]);
  // append path
  $paths[] = get_stylesheet_directory() . '/acf-json';
  // return
  return $paths;
}

/**
 * Add ACF options page
 *
 */
if (function_exists('acf_add_options_page')) {
  acf_add_options_page([
    'page_title' => 'Theme Settings',
    'menu_title' => 'Theme Settings',
    'menu_slug' => 'acf-options',
    'capability' => 'edit_posts',
    'redirect' => FALSE,
  ]);
}

/**
 * ACF functions - default values (if not exist ACF plugin)
 *
 */
if (!class_exists('acf') && !is_admin()) {
  function get_field_reference($field_name, $post_id) {
    return '';
  }

  function get_field_objects($post_id = FALSE, $options = []) {
    return FALSE;
  }

  function get_fields($post_id = FALSE) {
    return FALSE;
  }

  function get_field($field_key, $post_id = FALSE, $format_value = TRUE) {
    return FALSE;
  }

  function get_field_object($field_key, $post_id = FALSE, $options = []) {
    return FALSE;
  }

  function the_field($field_name, $post_id = FALSE) {
  }

  function have_rows($field_name, $post_id = FALSE) {
    return FALSE;
  }

  function the_row() {
  }

  function reset_rows($hard_reset = FALSE) {
  }

  function has_sub_field($field_name, $post_id = FALSE) {
    return FALSE;
  }

  function get_sub_field($field_name) {
    return FALSE;
  }

  function the_sub_field($field_name) {
  }

  function get_sub_field_object($child_name) {
    return FALSE;
  }

  function acf_get_child_field_from_parent_field($child_name, $parent) {
    return FALSE;
  }

  function register_field_group($array) {
  }

  function get_row_layout() {
    return FALSE;
  }

  function acf_form_head() {
  }

  function acf_form($options = []) {
  }

  function update_field($field_key, $value, $post_id = FALSE) {
    return FALSE;
  }

  function delete_field($field_name, $post_id) {
  }

  function create_field($field) {
  }

  function reset_the_repeater_field() {
  }

  function the_repeater_field($field_name, $post_id = FALSE) {
    return FALSE;
  }

  function the_flexible_field($field_name, $post_id = FALSE) {
    return FALSE;
  }

  function acf_filter_post_id($post_id) {
    return $post_id;
  }
}

/**
 * Remove Contact Form 7 styles
 *
 */
add_action('wp_enqueue_scripts', 'ac_remove_cf7_scripts');
function ac_remove_cf7_scripts() {
  wp_deregister_style('contact-form-7');
}

add_filter('wpcf7_autop_or_not', '__return_false');

/**
 * Recursively remove ALL values that evaluate to false including empty arrays
 *
 * @param $input
 * @return array
 */
function array_trim($input){
    return is_array($input) ? array_filter(
        $input,
        function (&$value) {
            return $value = array_trim($value);
        }
    ) : $input;
}

/**
 * Get author full name
 *
 */
function get_author_full_name()
{
    global $post;
    $user_info = get_userdata($post->post_author);
    $nickname = $user_info->display_name;
    $full_name = $user_info->first_name . ' ' . $user_info->last_name;
    return !empty(trim($full_name)) ? $full_name : $nickname;
}

/**
 * Phone URL
 *
 * @param string $phone_number , ex: (555) 123-4568
 *
 * @return string $phone_url, ex: tel:5551234568
 */
function phone_url($phone_number = FALSE) {
  $phone_number = preg_replace("/[^0-9]/", "", $phone_number);
  return esc_url('tel:' . $phone_number);
}

/**
 * Get featured image info
 *
 */
function get_featured_img_info($img_size = 'large', $post_id = FALSE) {
  $post_id = $post_id ?: get_the_ID();
  $post_type = get_post_type($post_id);
  $thumb_id = get_post_thumbnail_id($post_id);
  if ($post_type == 'product') {
      $img_src = wp_get_attachment_image_src($thumb_id, $img_size)[0];
  } else {
      $img_src = wp_get_attachment_image_url($thumb_id, $img_size);
  }
  $alt = get_post_meta($thumb_id, '_wp_attachment_image_alt', TRUE);
  return ['src' => $img_src, 'alt' => $alt];
}

/**
 * Limit excerpt length
 *
 */
add_filter('excerpt_length', 'custom_excerpt_length');
function custom_excerpt_length($length) {
  return 30;
}

/**
 * Change symbols after excerpt
 *
 */
add_filter('excerpt_more', 'custom_excerpt_more');
function custom_excerpt_more($more) {
  return '...';
}

/**
 * Disable wpautop for excerpt
 *
 */
remove_filter('the_excerpt', 'wpautop');

/**
 * Get custom excerpt
 *
 */
function get_excerpt_by_id($post_id) {
  $the_post = get_post($post_id);
  $the_excerpt = $the_post->post_excerpt;
  $the_excerpt = !empty($the_excerpt) ? $the_excerpt : $the_post->post_content;
  $excerpt_length = 50; //Sets excerpt length by word count
  $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images

  $words = explode(' ', $the_excerpt, $excerpt_length + 1);

  if (count($words) > $excerpt_length) :
    array_pop($words);
    array_push($words, '…');
    $the_excerpt = implode(' ', $words);
  endif;

  return $the_excerpt;
}

/**
 * get custom excertp length
 */
function do_excerpt($string, $limit){
    $string = strip_tags($string, '<br>');
    $count = strlen($string);
    $string = substr($string, 0, $limit);
    if ($count > $limit) {
        $string .= '...';
    }
    return $string;
}


/**
 * Default redirects
 *
 */
add_action('template_redirect', 'wp_redirect_post');
function wp_redirect_post() {
  if (is_date() || is_author() || is_singular('faqs') || is_tax('category_faqs')) {
    wp_redirect(site_url(), 301);
  }

  if (is_tag() || is_category() ) {
      $blog_id = get_option( 'page_for_posts' );
      $link = (!empty($blog_id)) ? get_the_permalink($blog_id) : site_url();
      wp_redirect($link, 301);
  }

  if (is_tax('product_cat')) {
      $link = (get_post_type_archive_link('product')) ? get_post_type_archive_link('product') : site_url();
      wp_redirect($link, 301);
  }
}

/**
 * Filter posts
 *
 */
add_filter('pre_get_posts', 'filter_posts');
function filter_posts($query) {
    if (!is_admin() && $query->is_main_query()) {
        if ($query->is_home()) {
            $query->set('posts_per_page', 12);
            if (!empty($_GET['category'])) {
                $query->set('tax_query', array(
                        array(
                            'taxonomy' => 'category',
                            'field'    => 'slug',
                            'terms'    => esc_sql($_GET['category'])
                        )
                    )
                );
            }
        }

        if (is_shop()) {
            $query->set('orderby', 'menu_order');
            $query->set('posts_per_page', -1);
            if (!empty($_GET['category'])) {
                $query->set('tax_query', array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => esc_sql($_GET['category'])
                        )
                    )
                );
            }
        }

        if (is_search()) {
            $query->set('posts_per_page', 5);
        }
    }

    return $query;
}

/**
 * Add in our new custom query vars first
 */
add_filter('query_vars', 'add_query_vars_filter');
function add_query_vars_filter($vars){
    $vars[] = "search";
    return $vars;
}

/**
 * Custom pagination
 *
 */
if (!function_exists('paginate_links_new')) {
  function paginate_links_new($args = '') {
    global $wp_query, $wp_rewrite;

    // Setting up default values based on the current URL.
    $pagenum_link = html_entity_decode(get_pagenum_link());
    $url_parts = explode('?', $pagenum_link);

    // Get max pages and current page out of the current query, if available.
    $total = isset($wp_query->max_num_pages) ? $wp_query->max_num_pages : 1;
    $current = get_query_var('paged') ? intval(get_query_var('paged')) : 1;

    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit($url_parts[0]) . '%_%';

    // URL base depends on permalink settings.
    $format = $wp_rewrite->using_index_permalinks() && !strpos($pagenum_link, 'index.php') ? 'index.php/' : '';
    $format .= $wp_rewrite->using_permalinks() ? user_trailingslashit($wp_rewrite->pagination_base . '/%#%', 'paged') : '?paged=%#%';

    $defaults = [
      'base' => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
      'format' => $format, // ?page=%#% : %#% is replaced by the page number
      'total' => $total,
      'current' => $current,
      'aria_current' => 'page',
      'show_all' => FALSE,
      'prev_next' => TRUE,
      'prev_text' => __('&laquo; Previous'),
      'next_text' => __('Next &raquo;'),
      'end_size' => 1,
      'mid_size' => 2,
      'type' => 'plain',
      'add_args' => [], // array of query args to add
      'add_fragment' => '',
      'before_page_number' => '',
      'after_page_number' => '',
    ];

    $args = wp_parse_args($args, $defaults);

    if (!is_array($args['add_args'])) {
      $args['add_args'] = [];
    }

    // Merge additional query vars found in the original URL into 'add_args' array.
    if (isset($url_parts[1])) {
      // Find the format argument.
      $format = explode('?', str_replace('%_%', $args['format'], $args['base']));
      $format_query = isset($format[1]) ? $format[1] : '';
      wp_parse_str($format_query, $format_args);

      // Find the query args of the requested URL.
      wp_parse_str($url_parts[1], $url_query_args);

      // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
      foreach ($format_args as $format_arg => $format_arg_value) {
        unset($url_query_args[$format_arg]);
      }

      $args['add_args'] = array_merge($args['add_args'], urlencode_deep($url_query_args));
    }

    // Who knows what else people pass in $args
    $total = (int) $args['total'];
    if ($total < 2) {
      return;
    }
    $current = (int) $args['current'];
    $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
    if ($end_size < 1) {
      $end_size = 1;
    }
    $mid_size = (int) $args['mid_size'];
    if ($mid_size < 0) {
      $mid_size = 2;
    }

    $add_args = $args['add_args'];
    $r = '';
    $page_links = [];
    $dots = FALSE;

    if ($args['prev_next'] && $current) :
      if (is_home()) {
        $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
        $link = str_replace('/page/%#%/', '/', $link);
      } else {
        $link = str_replace('%_%', 2 == $current ? '' : $args['format'], $args['base']);
        $link = str_replace('%#%', $current - 1, $link);
      }

      if ($add_args) {
        $link = add_query_arg($add_args, $link);
      }
      $link .= $args['add_fragment'];

      if (1 < $current) {
        $page_links[] = sprintf(
          '<a class="prev previouspostslink page-numbers" href="%s" data-num="' . ($current - 1) . '" title="Page ' . ($current - 1) . '">%s</a>',
          /**
           * Filters the paginated links for the given archive pages.
           *
           * @param string $link The paginated link URL.
           *
           * @since 3.0.0
           *
           */
          esc_url(apply_filters('paginate_links', $link)),
          $args['prev_text']
        );
      }
      elseif ($current == 1) {
        $page_links[] = sprintf(
          '<a class="prev previouspostslink page-numbers disabled">%s</a>',
          $args['prev_text']
        );
      }
    endif;

    for ($n = 1; $n <= $total; $n++) :
      if ($n == $current) :
        $page_links[] = sprintf(
          '<span aria-current="%s" class="page-numbers current">%s</span>',
          esc_attr($args['aria_current']),
          $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
        );

        $dots = TRUE;
      else :
        if ($args['show_all'] || ($n <= $end_size || ($current && $n >= $current - $mid_size && $n <= $current + $mid_size) || $n > $total - $end_size)) :

          if (is_home()) {
              $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
              $link = str_replace('/page/%#%/', '/', $link);
          } else {
              $link = str_replace('%_%', 1 == $n ? '' : $args['format'], $args['base']);
              $link = str_replace('%#%', $n, $link);
          }

          if ($add_args) {
            $link = add_query_arg($add_args, $link);
          }
          $link .= $args['add_fragment'];

          $page_links[] = sprintf(
            '<a class="page-numbers" href="%s" data-num="' . $n . '" title="Page ' . $n . '">%s</a>',
            /** This filter is documented in wp-includes/general-template.php */
            esc_url(apply_filters('paginate_links', $link)),
            $args['before_page_number'] . number_format_i18n($n) . $args['after_page_number']
          );

          $dots = TRUE;
        elseif ($dots && !$args['show_all']) :
          $page_links[] = '<span class="page-numbers dots">' . __('&hellip;') . '</span>';

          $dots = FALSE;
        endif;
      endif;
    endfor;

    if ($args['prev_next'] && $current) :
      if (is_home()) {
        $link = str_replace('%_%', $args['format'], $args['base']);
        $link = str_replace('/page/%#%/', '/', $link);
      } else {
        $link = str_replace('%_%', $args['format'], $args['base']);
        $link = str_replace('%#%', $current + 1, $link);
      }

      if ($add_args) {
        $link = add_query_arg($add_args, $link);
      }
      $link .= $args['add_fragment'];

      if ($current < $total) {
        $page_links[] = sprintf(
          '<a class="next nextpostslink page-numbers" href="%s" data-num="' . ($current + 1) . '" title="Page ' . ($current + 1) . '">%s</a>',
          /** This filter is documented in wp-includes/general-template.php */
          esc_url(apply_filters('paginate_links', $link)),
          $args['next_text']
        );
      }
      elseif ($current == $total) {
        $page_links[] = sprintf(
          '<a class="next nextpostslink page-numbers disabled">%s</a>',
          $args['next_text']
        );
      }
    endif;

    switch ($args['type']) {
      case 'array':
        return $page_links;

      case 'list':
        $r .= "<ul class='page-numbers'>\n\t<li>";
        $r .= join("</li>\n\t<li>", $page_links);
        $r .= "</li>\n</ul>\n";
        break;

      default:
        $r = '<div class="wp-pagenavi">' . join("\n", $page_links) . '</div>';
        break;
    }

    return $r;
  }
}

if (!function_exists('pagination')) {
  function pagination($paged = '', $max_page = '') {
    global $wp_query;
    $big = 999999999; // need an unlikely integer
    if (!$paged) {
      $paged = get_query_var('paged');
    }
    if (!$max_page) {
      $max_page = $wp_query->max_num_pages;
    }

    $result = paginate_links_new([
      'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
      'format' => '?paged=%#%',
      'current' => max(1, $paged),
      'total' => $max_page,
      'mid_size' => 1,
      'prev_text' => '<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20 9H2M2 9L9.875 1.5M2 9L9.875 16.5" stroke="#151B20" stroke-width="1.5"></path></svg>',
      'next_text' => '<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 9H18M18 9L10.125 1.5M18 9L10.125 16.5" stroke="#151B20" stroke-width="1.5"></path></svg>',
    ]);

    $result = preg_replace('~page/1/?([\'"])~', '\1', $result);
    echo $result;
  }
}

/**
 * get categories list by post id
 */
function get_categories_list($post_id, $type = false){
    $post_type = get_post_type($post_id);

    switch ($post_type) {
        case 'post':
            $categories = get_the_terms($post_id, 'category');
            break;
        default:
            $categories = '';
    }

    if (isset($categories) && !empty($categories)) {
        foreach ($categories as $category) {
            if ($category->term_id != 1) {
                $arr_term[] = $category->name;
            }
        }
        $symbol = ($type == 'single') ? ' • ' : ', ';
        $arr = implode($symbol, $arr_term);
    } else {
        $arr = '';
    }

    return $arr;
}

/**
 * get categories list by post id
 */
function get_categories_count($type = false, $value = false, $page_id = false){
    if ($type == 'faqs') {
        $page_id = (!empty($page_id)) ? $page_id : get_the_ID();
        $tax = 'category_faqs';
        $fields = get_acf_field_gutenberg($page_id, 'section-listing-faqs');
        $terms_ids = (isset($fields['faq_categories']) && !empty($fields['faq_categories'])) ? $fields['faq_categories'] : '';
    } else {
        $tax = 'category';
        $terms_ids = '';
    }

    $post_terms = array();
    $arr_count = array();
    $args = array(
        'post_type'      => $type,
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'order'          => 'DESC'
    );

    if ($type == 'faqs' && !empty($terms_ids)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category_faqs',
                'field'    => 'id',
                'terms'    => $terms_ids,
                'operator' => 'IN'
            )
        );
    }

    if (!empty($value)) {
        $args['s'] = $value;
    }

    $query = new WP_Query($args);
    if( $query->have_posts() ) {
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $categories = get_the_terms($post->ID, $tax);

            if (isset($categories) && !empty($categories)) {
                foreach ($categories as $category) {
                    $post_terms[$category->slug]++;
                }
            }

        endwhile;
        wp_reset_postdata();
    }

    $term_args = array(
        'post_type'  => $type,
        'fields'     => 'all',
        'orderby'    => 'title',
        'order'      => 'ASC',
        'hide_empty' => false,
        'include'    => $terms_ids
    );

    $terms = get_terms(array($tax), $term_args);
    if (!empty($terms)) {
        $arr_count[] = array(
            'id' => '0',
            'slug' => 'all',
            'name' => 'All',
            'count' => $query->post_count
        );
        foreach($terms as $term) {
            if (array_key_exists($term->slug, $post_terms)) {
                foreach ($post_terms as $key => $value) {
                    if ($term->slug == $key) {
                        $arr_count[] = array(
                            'id' => $term->term_id,
                            'slug' => $term->slug,
                            'name' => $term->name,
                            'count' => $value
                        );
                    }
                }
            } else {
                $arr_count[] = array(
                    'id' => $term->term_id,
                    'slug' => $term->slug,
                    'name' => $term->name,
                    'count' => 0
                );
            }
        }
    }

    return $arr_count;
}

/**
 * Get project tag list
 */
if (!function_exists('get_project_tags')) {
    function get_project_tags($post_id)     {
        $tags = get_the_terms($post_id, 'post_tag');
        $tags_html = '';

        if ($tags) {
            $tags_html .= '<div class="article-tags">';
            $tags_html .= '<span class="article-tags-title">'. __('tags:','woo-theme').'</span>';
            foreach ($tags as $tag) {
                $tags_html .= '<span>'.$tag->name.'</span>';
            }
            $tags_html .= '</div>';
        }

        return $tags_html;
    }
}

/**
 *  get latest article post
 */
function get_latest_post(){
    $arr = array();
    $args = array(
        'post_type'      => 'post',
        'posts_per_page' => 1,
        'post_status'    => 'publish',
        'order'          => 'DESC');

    $query = new WP_Query($args);
    if( $query->have_posts() ) :
        while ($query->have_posts()) : $query->the_post();
            global $post;
            $arr[] = $post->ID;
        endwhile;
        wp_reset_postdata();
    endif;

    return $arr;
}

/**
 * Add custom values for some ACF Select fields
 *
 */
add_filter('acf/load_field/name=form', 'acf_load_form_field_choices');
function acf_load_form_field_choices($field){
    $field['choices'] = array();
    $forms = get_posts(array(
        'post_type' => 'wpcf7_contact_form',
        'numberposts' => -1,
        'post_status' => 'publish'
    ));
    if (is_array($forms) && count($forms) > 0) {
        foreach ($forms as $form) {
            $field['choices'][$form->ID] = $form->post_title;
        }
    }
    return $field;
}

/**
 * Add menu list for some ACF Select fields
 */
add_filter('acf/load_field/name=menu', 'acf_load_menus');
function acf_load_menus($field)
{
    $field['choices'] = array();
    $menus = wp_get_nav_menus();
    if (!empty($menus)) {
        foreach ($menus as $menu) {
            $field['choices'][$menu->name] = $menu->name;
        }
    }
    return $field;
}

/**
 * WP header hook - add custom scripts
 */
function hook_header(){
    if (is_singular('post')) : ?>
        <!--Generic Social Share -->
        <script type="text/javascript">
            function genericSocialShare(url) {
                window.open(url, 'sharer', 'toolbar=0,status=0,width=648,height=395');
                return true;
            }
        </script>
    <?php endif;
    if (is_singular('product')) : ?>
        <style>.woocommerce-notices-wrapper{display:none;}</style>
    <?php endif;

    ?>
    <!--global style -->
    <style>.only-shop{display:none;}</style>
    <?php
}
add_action('wp_head', 'hook_header');

/**
 * WP footer hook - add custom scripts
 */
function hook_footer(){ ?>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($('.drop-nav-col .active').parents('li').length && $('.header-nav .current_page_item').length === 0) {
                setTimeout(function(){
                    $('.drop-nav-col .active:first').parents('li').addClass('active');
                }, 1000);
            }

            if ($('.woocommerce-checkout').length) {
                setTimeout(function() {
                    $('.woocommerce-checkout .place-order button').wrapInner('<span></span>');
                }, 500);
            }

            <?php if (is_singular('product')) : ?>
                if ($('.product-detail-section .woocommerce-message a').hasClass('wc-forward')) {
                    setTimeout(function(){
                        $('body').addClass('active');
                        $("[data-modal='cart']").addClass('show');
                        window.initCustomSelect();
                        $('body').attr("style", "position:fixed; top:0px; width:100%; height:auto; overflow: hidden;");
                    }, 100);
                }
            <?php endif; ?>

            <?php if (is_shop()) : ?>
                if ($('.woocommerce .products .product').length) {
                    $('.woocommerce .products .product').on('click', '.add_to_cart_button', function(){
                        var button = $(this);

                        let i = setInterval(function() {
                            if (button.hasClass("added")){
                                clearInterval(i);
                                $('body').addClass('active');
                                $("[data-modal='cart']").addClass('show');
                                window.initCustomSelect();
                            }
                        }, 1000);
                    });
                }
            <?php endif; ?>
        });
    </script>
    <?php
}
add_action('wp_footer', 'hook_footer');

/**
 * Add custom body class
 */
function new_body_class($classes){
    if (is_account_page()) {
        unset( $classes[array_search('woocommerce-account', $classes)] );
        array_push($classes, 'woocommerce');
    } elseif (!is_shop() || !is_tax('product_cat') || !is_cart() || !is_checkout() || !is_singular('product')) {
        array_push($classes, 'woocommerce');
    } 
    return $classes;
}
add_filter('body_class', 'new_body_class');

/**
 * Limit revision
 */
add_filter('wp_revisions_to_keep', 'limit_revisions');
function limit_revisions($revisions) {
    return 5;
}

/**
 * Add country and region to ACF Fields
 */
add_filter( 'acf/load_field/name=region_item', 'acf_load_regions' );
function acf_load_regions( $field ) {
	$field['choices'] = array();
	$regions = get_field('regions','options');
	if ( is_array( $regions ) && count( $regions ) > 0 ) {
		foreach ( $regions as $item ) {
			$field['choices'][ $item['region'] ] = $item['region'];
		}
	}

	return $field;
}

add_filter( 'acf/load_field/name=countries', 'acf_load_countries' );
function acf_load_countries( $field ) {
	$field['choices'] = array();
	$countries = array(
		'AW' => 'Aruba',
		'AF' => 'Afghanistan',
		'AO' => 'Angola',
		'AL' => 'Albania',
		'AD' => 'Andorra',
		'AE' => 'United Arab Emirates',
		'AR' => 'Argentina',
		'AM' => 'Armenia',
		'AS' => 'American Samoa',
		'AG' => 'Antigua and Barbuda',
		'AU' => 'Australia',
		'AT' => 'Austria',
		'AZ' => 'Azerbaijan',
		'BI' => 'Burundi',
		'BE' => 'Belgium',
		'BJ' => 'Benin',
		'BF' => 'Burkina Faso',
		'BD' => 'Bangladesh',
		'BG' => 'Bulgaria',
		'BH' => 'Bahrain',
		'BS' => 'Bahamas, The',
		'BA' => 'Bosnia and Herzegovina',
		'BY' => 'Belarus',
		'BZ' => 'Belize',
		'BM' => 'Bermuda',
		'BO' => 'Bolivia',
		'BR' => 'Brazil',
		'BB' => 'Barbados',
		'BN' => 'Brunei Darussalam',
		'BT' => 'Bhutan',
		'BW' => 'Botswana',
		'CF' => 'Central African Republic',
		'CA' => 'Canada',
		'CH' => 'Switzerland',
		'JG' => 'Channel Islands',
		'CL' => 'Chile',
		'CN' => 'China',
		'CI' => 'Cote d\'Ivoire',
		'CM' => 'Cameroon',
		'CD' => 'Congo, Dem. Rep.',
		'CG' => 'Congo, Rep.',
		'CO' => 'Colombia',
		'KM' => 'Comoros',
		'CV' => 'Cabo Verde',
		'CR' => 'Costa Rica',
		'CU' => 'Cuba',
		'CW' => 'Curacao',
		'KY' => 'Cayman Islands',
		'CY' => 'Cyprus',
		'CZ' => 'Czech Republic',
		'DE' => 'Germany',
		'DJ' => 'Djibouti',
		'DM' => 'Dominica',
		'DK' => 'Denmark',
		'DO' => 'Dominican Republic',
		'DZ' => 'Algeria',
		'EC' => 'Ecuador',
		'EG' => 'Egypt, Arab Rep.',
		'ER' => 'Eritrea',
		'ES' => 'Spain',
		'EE' => 'Estonia',
		'ET' => 'Ethiopia',
		'FI' => 'Finland',
		'FJ' => 'Fiji',
		'FR' => 'France',
		'FO' => 'Faroe Islands',
		'FM' => 'Micronesia, Fed. Sts.',
		'GA' => 'Gabon',
		'GB' => 'United Kingdom',
		'GE' => 'Georgia',
		'GH' => 'Ghana',
		'GI' => 'Gibraltar',
		'GN' => 'Guinea',
		'GM' => 'Gambia, The',
		'GW' => 'Guinea-Bissau',
		'GQ' => 'Equatorial Guinea',
		'GR' => 'Greece',
		'GD' => 'Grenada',
		'GL' => 'Greenland',
		'GT' => 'Guatemala',
		'GU' => 'Guam',
		'GY' => 'Guyana',
		'HK' => 'Hong Kong SAR, China',
		'HN' => 'Honduras',
		'HR' => 'Croatia',
		'HT' => 'Haiti',
		'HU' => 'Hungary',
		'ID' => 'Indonesia',
		'IM' => 'Isle of Man',
		'IN' => 'India',
		'IE' => 'Ireland',
		'IR' => 'Iran, Islamic Rep.',
		'IQ' => 'Iraq',
		'IS' => 'Iceland',
		'IL' => 'Israel',
		'IT' => 'Italy',
		'JM' => 'Jamaica',
		'JO' => 'Jordan',
		'JP' => 'Japan',
		'KZ' => 'Kazakhstan',
		'KE' => 'Kenya',
		'KG' => 'Kyrgyz Republic',
		'KH' => 'Cambodia',
		'KI' => 'Kiribati',
		'KN' => 'St. Kitts and Nevis',
		'KR' => 'Korea, Rep.',
		'KW' => 'Kuwait',
		'LA' => 'Lao PDR',
		'LB' => 'Lebanon',
		'LR' => 'Liberia',
		'LY' => 'Libya',
		'LC' => 'St. Lucia',
		'LI' => 'Liechtenstein',
		'LK' => 'Sri Lanka',
		'LS' => 'Lesotho',
		'LT' => 'Lithuania',
		'LU' => 'Luxembourg',
		'LV' => 'Latvia',
		'MO' => 'Macao SAR, China',
		'MF' => 'St. Martin (French part)',
		'MA' => 'Morocco',
		'MC' => 'Monaco',
		'MD' => 'Moldova',
		'MG' => 'Madagascar',
		'MV' => 'Maldives',
		'MX' => 'Mexico',
		'MH' => 'Marshall Islands',
		'MK' => 'Macedonia, FYR',
		'ML' => 'Mali',
		'MT' => 'Malta',
		'MM' => 'Myanmar',
		'ME' => 'Montenegro',
		'MN' => 'Mongolia',
		'MP' => 'Northern Mariana Islands',
		'MZ' => 'Mozambique',
		'MR' => 'Mauritania',
		'MU' => 'Mauritius',
		'MW' => 'Malawi',
		'MY' => 'Malaysia',
		'NA' => 'Namibia',
		'NC' => 'New Caledonia',
		'NE' => 'Niger',
		'NG' => 'Nigeria',
		'NI' => 'Nicaragua',
		'NL' => 'Netherlands',
		'NO' => 'Norway',
		'NP' => 'Nepal',
		'NR' => 'Nauru',
		'NZ' => 'New Zealand',
		'OM' => 'Oman',
		'PK' => 'Pakistan',
		'PA' => 'Panama',
		'PE' => 'Peru',
		'PH' => 'Philippines',
		'PW' => 'Palau',
		'PG' => 'Papua New Guinea',
		'PL' => 'Poland',
		'PR' => 'Puerto Rico',
		'KP' => 'Korea, Dem. People’s Rep.',
		'PT' => 'Portugal',
		'PY' => 'Paraguay',
		'PS' => 'West Bank and Gaza',
		'PF' => 'French Polynesia',
		'QA' => 'Qatar',
		'RO' => 'Romania',
		'RU' => 'Russian Federation',
		'RW' => 'Rwanda',
		'SA' => 'Saudi Arabia',
		'SD' => 'Sudan',
		'SN' => 'Senegal',
		'SG' => 'Singapore',
		'SB' => 'Solomon Islands',
		'SL' => 'Sierra Leone',
		'SV' => 'El Salvador',
		'SM' => 'San Marino',
		'SO' => 'Somalia',
		'RS' => 'Serbia',
		'SS' => 'South Sudan',
		'ST' => 'Sao Tome and Principe',
		'SR' => 'Suriname',
		'SK' => 'Slovak Republic',
		'SI' => 'Slovenia',
		'SE' => 'Sweden',
		'SZ' => 'Swaziland',
		'SX' => 'Sint Maarten (Dutch part)',
		'SC' => 'Seychelles',
		'SY' => 'Syrian Arab Republic',
		'TC' => 'Turks and Caicos Islands',
		'TD' => 'Chad',
		'TG' => 'Togo',
		'TH' => 'Thailand',
		'TJ' => 'Tajikistan',
		'TM' => 'Turkmenistan',
		'TL' => 'Timor-Leste',
		'TO' => 'Tonga',
		'TT' => 'Trinidad and Tobago',
		'TN' => 'Tunisia',
		'TR' => 'Turkey',
		'TV' => 'Tuvalu',
		'TW' => 'Taiwan, China',
		'TZ' => 'Tanzania',
		'UG' => 'Uganda',
		'UA' => 'Ukraine',
		'UY' => 'Uruguay',
		'US' => 'United States',
		'UZ' => 'Uzbekistan',
		'VC' => 'St. Vincent and the Grenadines',
		'VE' => 'Venezuela, RB',
		'VG' => 'British Virgin Islands',
		'VI' => 'Virgin Islands (U.S.)',
		'VN' => 'Vietnam',
		'VU' => 'Vanuatu',
		'WS' => 'Samoa',
		'XK' => 'Kosovo',
		'YE' => 'Yemen, Rep.',
		'ZA' => 'South Africa',
		'ZM' => 'Zambia',
		'ZW' => 'Zimbabwe',
	);
	foreach ( $countries as $code => $country ) {
		$field['choices'][$code] = $country;
	}

	return $field;
}


/**
 * Disable Relevanssi search for custom queries.
 */
remove_filter('posts_request', 'relevanssi_prevent_default_request');
remove_filter('the_posts', 'relevanssi_query', 99);

/**
 * get ACF fields in Gutenberg content for an off-cycle
 */
function get_acf_field_gutenberg($page_id, $acf_field){
	if (function_exists('get_field')) {
		$post   = get_post($page_id);
		$blocks = parse_blocks($post->post_content);
		$fields = '';

		// Loop through the blocks
		foreach($blocks as $block){
			if (isset($block['attrs']['name']) && $block['attrs']['name'] == 'acf/'.$acf_field) {
				$fields = $block['attrs']['data'];
			}
		}

		return $fields;
	}
}


/**
 * Contact form custom add email address for sending form
 */

function contact_form_add_recipients ( $tag, $unused ) {
	global $post;

	if ( $tag['name'] != 'list_recipient' )
		return $tag;

	$rows = get_field('contact_list', 'option' );

	if ( ! $rows )
		return $tag;

	foreach ( $rows as $key => $row ) {
		$tag['raw_values'][] = $row['select'];
		$tag['values'][] = $row['select'];
		$tag['labels'][] = $row['select'];
	}

	return $tag;
}
add_filter( 'wpcf7_form_tag', 'contact_form_add_recipients', 10, 2);

/**
 * Validate Gutenberg Block
 */

add_action( 'acf/validate_save_post', '_validate_save_post', 5 );
function _validate_save_post() {

	// bail early if no $_POST
	$acf = false;
	foreach($_POST as $key => $value) {
		if (strpos($key, 'acf') === 0) {
			if (! empty( $_POST[$key] ) ) {
				acf_validate_values( $_POST[$key], $key);
			}
		}
	}
}

/**
 * Add class to first select label
 */

function woo_wpcf7_form_elements($html) {
	$text = 'Select';
	$html = str_replace('<option value="">', '<option value="" class="hideme">', $html);
	return $html;
}
add_filter('wpcf7_form_elements', 'woo_wpcf7_form_elements');