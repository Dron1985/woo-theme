<?php

class CustomMenuWalker extends Walker_Nav_Menu{

    function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0 ) {
        $page_id = get_the_ID();
        $dropdawn_menu = get_field('show_menu', $item);
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if ($dropdawn_menu == true) {
            $classes[] = 'has-dropdown';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = esc_attr($class_names);

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li class="object '.$class_names.'" ' . $id . $value.'>';

        $myurl = $item->url;

        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= !empty($item->url)        ? ' href="'   . esc_attr($myurl           ) .'"' : '';
        $attributes .= $depth == 0               ? ' class="header-nav-link-view"'                : '';

        $item_output = $args->before;

        if ($dropdawn_menu == true) {
            $menu_field = get_field('menu_field', $item);

            $item_output .= '<a'. $attributes . '>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;

            if (!empty($menu_field)) {
                $menu_class = (isset($menu_field['type_menu']) && $menu_field['type_menu'] == 'posts') ? 'header-drop-menu has-news' : 'header-drop-menu';
                $item_output .= '<div class="'.$menu_class.'"><div class="container"><div class="sub-menu">';

                if (isset($menu_field['info_block']) && !empty($menu_field['info_block'])) {
                    $info = $menu_field['info_block'];
                    $item_output .= '<div class="drop-text-col">';
                    $item_output .= render('<strong class="h3">', $info, 'title', '</strong>', 'text', '', '', '', false);
                    $item_output .= (isset($info['description']) && !empty($info['description'])) ? $info['description'] : '';
                    if (isset($info['button']['url'])) {
                        $item_output .= '<div class="buttons">';
                        $item_output .= render('<div class="button-inner">', $info, 'button', '</div>', 'link', 'btn small', '<span>', '</span>', false);
                        $item_output .= '</div>';
                    }
                    $item_output .= '</div>';
                }

                if (isset($menu_field['links_block']) && !empty($menu_field['links_block']) && $menu_field['type_menu'] == 'info') {
                    $field = $menu_field['links_block'];
                    $item_output .= '<div class="drop-nav-col">';
                    if (isset($field['use_title_link']) && $field['use_title_link'] == true) {
                        $item_output .= render('<span class="header-nav-link-view">', $field, 'title_link', '</span>', 'link', 'header-nav-link-view', '', '', false);
                    } else {
                        $item_output .= render('<span class="header-nav-link-view">', $field, 'title', '</span>', 'text', '', '', '', false);
                    }
                    $item_output .= '<ul class="header-nav-second-list">';
                    foreach ($field['links'] as $link) {
                        if (is_shop()) {
                            $class = (home_url($_SERVER['REQUEST_URI']) == $link['link']['url']) ? ' class="active"' : '';
                        } else {
                            $class = ($page_id == url_to_postid($link['link']['url'])) ? ' class="active"' : '';
                        }
                        $item_output .= render('<li'.$class.'>', $link, 'link', '</li>', 'link', 'header-nav-link-view', '', '', false);
                    }
                    $item_output .= '</ul>';
                    $item_output .= render_ACF_Link($field['button'], 'link');
                    $item_output .= '</div>';
                }

                if (isset($menu_field['links']) && !empty($menu_field['links'])) {
                    $item_output .= '<div class="drop-nav-col">';
                    $item_output .= '<ul>';
                    foreach ($menu_field['links'] as $link) {
                        if (is_shop()) {
                            $class = (home_url($_SERVER['REQUEST_URI']) == $link['link']['url']) ? ' class="active"' : '';
                        } else {
                            $class = ($page_id == url_to_postid($link['link']['url'])) ? ' class="active"' : '';
                        }
                        $item_output .= render('<li'.$class.'>', $link, 'link', '</li>', 'link', 'header-nav-link-view', '', '', false);
                    }
                    $item_output .= '</ul>';
                    $item_output .= '</div>';
                }

                if (isset($menu_field['type_menu']) && $menu_field['type_menu'] == 'links') {
                    $latest_post = get_latest_post();
                    $post_id = (isset($menu_field['related_post']) && !empty($menu_field['related_post'])) ? $menu_field['related_post'] : (isset($latest_post[0]) ? $latest_post[0] : '');
                    if (!empty($post_id)) {
                        $image = get_featured_img_info('medium_large', $post_id);
                        $image_alt = (!empty($image['alt'])) ? $image['alt'] : get_the_title($post_id);
                        $item_output .= '<div class="news-card">';
                        if (!empty($image['src'])) {
                            $item_output .= '<figure class="news-card-picture">';
                            $item_output .= '<img src="'.$image['src'].'" alt="'.$image_alt.'">';
                            $item_output .= '</figure>';
                        }
                        $item_output .= '<div class="news-card-text">';
                        $item_output .=  '<strong class="h5">'. get_the_title($post_id).'</strong>';
                        $item_output .= (get_the_excerpt($post_id)) ? '<p>'.do_excerpt(get_the_excerpt($post_id), 120).'</p>' : '';
                        $item_output .= '</div>';
                        $item_output .= '<a class="news-card-link" href="'.get_the_permalink($post_id).'">&nbsp;</a>';
                        $item_output .= '</div>';
                    }
                }

                if (isset($menu_field['type_menu']) && $menu_field['type_menu'] == 'posts') {
                    $latest_post = (isset($menu_field['related_posts']) && !empty($menu_field['related_posts'])) ? $menu_field['related_posts'] : '';
                    if (!empty($latest_post)) {
                        foreach ($latest_post as $item) {
                            $image = get_featured_img_info('medium_large', $item);
                            $image_alt = (!empty($image['alt'])) ? $image['alt'] : get_the_title($item);
                            $item_output .= '<div class="news-card">';
                            if (!empty($image['src'])) {
                                $item_output .= '<figure class="news-card-picture">';
                                $item_output .= '<img src="'.$image['src'].'" alt="'.$image_alt.'">';
                                $item_output .= '</figure>';
                            }
                            $item_output .= '<div class="news-card-text">';
                            $item_output .=  '<strong class="h5">'. get_the_title($item).'</strong>';
                            $item_output .= (get_the_excerpt($item)) ? '<p>'.do_excerpt(get_the_excerpt($item), 120).'</p>' : '';
                            $item_output .= '</div>';
                            $item_output .= '<a class="news-card-link" href="'.get_the_permalink($item).'">&nbsp;</a>';
                            $item_output .= '</div>';
                        }
                    }
                }

                $item_output .= '</div></div></div>';
            }
        } else {
            $item_output .= '<a'. $attributes . '>';
            $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
        }

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        $item_output .= "\n";
    }

    function end_el(&$output, $item, $depth = 0, $args = Array()) {
        $output .=  '</li>';
    }
}