<?php

class CustomSubMenuWalker extends Walker_Nav_Menu{

    function start_el(&$output, $item, $depth = 0, $args = Array(), $id = 0 ) {
        $menu_icon = get_field('show_icon', $item);
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = esc_attr($class_names);

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li class="object '.$class_names.'" ' . $id . $value.'>';
        $myurl = $item->url;

        $attributes  = !empty($item->attr_title) ? ' title="'  . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target)     ? ' target="' . esc_attr($item->target    ) .'"' : '';
        $attributes .= !empty($item->xfn)        ? ' rel="'    . esc_attr($item->xfn       ) .'"' : '';
        $attributes .= !empty($item->url) && !in_array('cart-link-item', $classes) ? ' href="'   . esc_attr($myurl           ) .'"' : '';
        $attributes .= $depth == 0 && in_array('cart-link-item', $classes) ? ' class="cart-link" data-modal-open="cart"' : '';

        $item_output = $args->before;
        $item_output .= '<a'. $attributes . '>';

        if ($menu_icon == true ) {
            $type = get_field('icon', $item);
            switch ($type) {
                case 'contact':
                    $item_output .= '<span class="icon contact-icon"><svg width="19" class="phone-icon" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.20028 5.32061L5.4516 2.14799C5.13473 1.78239 4.5538 1.78401 4.18574 2.15286L1.92537 4.41717C1.25263 5.09069 1.06006 6.09082 1.44925 6.8927C3.7743 11.7065 7.65675 15.5941 12.4675 17.9258C13.2686 18.315 14.268 18.1224 14.9407 17.4489L17.2222 15.1635C17.5919 14.7938 17.5927 14.2096 17.2239 13.8928L14.0389 11.1589C13.7057 10.8729 13.1882 10.9103 12.8543 11.245L11.746 12.3548C11.6893 12.4143 11.6146 12.4535 11.5334 12.4664C11.4523 12.4793 11.3691 12.4652 11.2967 12.4263C9.48519 11.3832 7.98252 9.87865 6.94172 8.06588C6.90274 7.99337 6.88863 7.91008 6.90154 7.82878C6.91446 7.74747 6.95369 7.67265 7.01322 7.61579L8.11821 6.51004C8.45296 6.17368 8.48952 5.65372 8.20028 5.3198V5.32061Z" stroke="white" stroke-width="1.875" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
                    break;
                case 'external':
                    $item_output .= '<span class="icon"><svg class="lock-icon" width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.83333 7.5V3.75C3.83333 3.15326 4.05283 2.58097 4.44353 2.15901C4.83423 1.73705 5.36413 1.5 5.91667 1.5H10.0833C10.6359 1.5 11.1658 1.73705 11.5565 2.15901C11.9472 2.58097 12.1667 3.15326 12.1667 3.75V4.5M3.13889 7.5H12.8611C13.6282 7.5 14.25 8.17157 14.25 9V15C14.25 15.8284 13.6282 16.5 12.8611 16.5H3.13889C2.37183 16.5 1.75 15.8284 1.75 15V9C1.75 8.17157 2.37183 7.5 3.13889 7.5Z" stroke="white" stroke-width="1.875" stroke-linecap="square"/></svg></span>';
                    break;
                case 'cart':
                    $item_output .= '<span class="icon no-empty"><svg class="cart-icon" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.71422 4.77778H16.1906C16.4434 4.77779 16.6934 4.83309 16.9245 4.94013C17.1555 5.04717 17.3626 5.20357 17.5322 5.39924C17.7018 5.59491 17.8303 5.82551 17.9093 6.07618C17.9883 6.32685 18.0162 6.59202 17.991 6.85461L17.4482 12.5213C17.4035 12.9874 17.1946 13.4195 16.8619 13.7338C16.5292 14.0481 16.0965 14.2222 15.6477 14.2222H7.00748C6.58901 14.2224 6.18342 14.0712 5.85976 13.7943C5.53611 13.5174 5.31439 13.1319 5.23237 12.7036L3.71422 4.77778ZM3.71422 4.77778L2.98138 1.71494C2.93237 1.51071 2.81939 1.32943 2.66039 1.1999C2.50138 1.07036 2.30548 1.00001 2.10378 1H1M6.42844 18H8.23792M13.6664 18H15.4758" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><span>&nbsp;</span></span>';
                    break;
                case 'search':
                    $item_output .= '<span class="icon"><svg class="search-icon" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M16.5 16.5L12.9584 12.9521M14.9211 8.21053C14.9211 9.99027 14.2141 11.6971 12.9556 12.9556C11.6971 14.2141 9.99027 14.9211 8.21053 14.9211C6.43078 14.9211 4.72394 14.2141 3.46547 12.9556C2.207 11.6971 1.5 9.99027 1.5 8.21053C1.5 6.43078 2.207 4.72394 3.46547 3.46547C4.72394 2.207 6.43078 1.5 8.21053 1.5C9.99027 1.5 11.6971 2.207 12.9556 3.46547C14.2141 4.72394 14.9211 6.43078 14.9211 8.21053Z" stroke="white" stroke-width="1.875" stroke-linecap="square"/></svg></span>';
                    break;
                case 'account':
                    $item_output .= '<span class="icon"><svg class="account-icon" width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.86223 8.2H9.06373C9.48224 8.20012 9.8863 8.36042 10.2 8.65077C10.5137 8.94112 10.7154 9.34154 10.7673 9.7768L10.9912 11.6512C11.0113 11.8201 10.9969 11.9915 10.949 12.1541C10.9011 12.3167 10.8208 12.4667 10.7133 12.5943C10.6058 12.7218 10.4737 12.824 10.3257 12.8939C10.1777 12.9639 10.0172 13 9.85486 13H2.14514C1.98279 13 1.82228 12.9639 1.67427 12.8939C1.52627 12.824 1.39415 12.7218 1.28669 12.5943C1.17922 12.4667 1.09887 12.3167 1.05097 12.1541C1.00307 11.9915 0.988704 11.8201 1.00884 11.6512L1.23209 9.7768C1.28401 9.34133 1.48592 8.94075 1.79986 8.65037C2.1138 8.35999 2.51814 8.19983 2.93684 8.2H3.13777M8.86223 4C8.86223 5.65685 7.58077 7 6 7C4.41923 7 3.13777 5.65685 3.13777 4C3.13777 2.34315 4.41923 1 6 1C7.58077 1 8.86223 2.34315 8.86223 4Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
                    break;
            }
            $item_output .= '<span>'.$item->title.'</span>';
        }

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        $item_output .= "\n";
    }

    function end_el(&$output, $item, $depth = 0, $args = Array()) {
        $output .=  '</li>';
    }
}