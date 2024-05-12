<?php

if ( !class_exists('Yaba')) {
    class Yaba {
        public static function replace_array_keys($src_array, $prefix = 'attribute_') {
            $new_array = array_map(function($key) use ($prefix, $src_array) {
                $new_key = str_replace($prefix, '', $key);
                return [$new_key => $src_array[$key]];
            }, array_keys($src_array));

            return call_user_func_array('array_merge', $new_array);
        }

        public static function compare_arrays($default_attr, $variation_attributes): int {
            $counts = count($default_attr) === count($variation_attributes);
            $difference = count( array_diff_assoc($default_attr, $variation_attributes ) ) === 0;
            return $counts && $difference;
        }

        // Breadcrumbs Custom Function
        public static function breadcrumbs() {

            $text['home']     = esc_html__('Startseite','yaba');
            $text['category'] = esc_html__('Archive','yaba').' "%s"';
            $text['search']   = esc_html__('Search results','yaba').' "%s"';
            $text['tag']      = esc_html__('Tag','yaba').' "%s"';
            $text['author']   = esc_html__('Author','yaba').' %s';
            $text['404']      = esc_html__('Fehler 404','yaba');

            $show_current   = 1;
            $show_on_home   = 0;
            $show_home_link = 1;
            $show_title     = 1;
            $delimiter      = '<span class="breadcrumb-separator icon-arrow_right_small"></span>';
            $before         = '<span class="current">';
            $after          = '</span>';

            global $post;
            $home_link    = esc_url(home_url('/'));
            $link_before  = '<span typeof="v:Breadcrumb">';
            $link_after   = '</span>';
            $link_attr    = ' rel="v:url" property="v:title"';
            $link         = $link_before . '<a' . $link_attr . ' href="%1$s">%2$s</a>' . $link_after;
            if(isset($post->post_parent)){$my_post_parent = $post->post_parent;}else{$my_post_parent=1;}
            $parent_id    = $parent_id_2 = $my_post_parent;
            $frontpage_id = get_option('page_on_front');

            if (is_home() || is_front_page()) {

                if ($show_on_home == 1) echo '<div class="breadcrumbs"><a href="' . $home_link . '">' . $text['home'] . '</a></div>';

                if(get_option( 'page_for_posts' )){
                    echo '<div class="breadcrumbs"><a href="' . esc_url($home_link) . '">' . esc_attr($text['home']) . '</a>'.ale_wp_kses($delimiter).' '.__('Blog','yaba').'</div>';
                }
            }
            else {

                echo '<div class="breadcrumb woocommerce-breadcrumb">';
                if ($show_home_link == 1) {
                    echo sprintf($link, $home_link, $text['home']);
                    if ($frontpage_id == 0 || $parent_id != $frontpage_id) echo ale_wp_kses($delimiter);
                }

                if ( is_category() ) {
                    $this_cat = get_category(get_query_var('cat'), false);
                    if ($this_cat->parent != 0) {
                        $cats = get_category_parents($this_cat->parent, TRUE, $delimiter);
                        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                        echo ale_wp_kses($cats);
                    }
                    if ($show_current == 1) echo ale_wp_kses($before) . sprintf($text['category'], single_cat_title('', false)) . ale_wp_kses($after);

                } elseif ( is_search() ) {
                    echo ale_wp_kses($before) . sprintf($text['search'], get_search_query()) . ale_wp_kses($after);

                } elseif ( is_day() ) {
                    echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . ale_wp_kses($delimiter);
                    echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . ale_wp_kses($delimiter);
                    echo ale_wp_kses($before) . get_the_time('d') . ale_wp_kses($after);

                } elseif ( is_month() ) {
                    echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . ale_wp_kses($delimiter);
                    echo ale_wp_kses($before) . get_the_time('F') . ale_wp_kses($after);

                } elseif ( is_year() ) {
                    echo ale_wp_kses($before) . get_the_time('Y') . ale_wp_kses($after);

                } elseif ( is_single() && !is_attachment() ) {
                    if ( get_post_type() != 'post' ) {
                        $post_type = get_post_type_object(get_post_type());
                        $slug = $post_type->rewrite;
                        printf($link, $home_link . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
                        if ($show_current == 1) echo ale_wp_kses($delimiter) . ale_wp_kses($before) . get_the_title() . ale_wp_kses($after);
                    } else {
                        $cat = get_the_category(); $cat = $cat[0];
                        $cats = get_category_parents($cat, TRUE, $delimiter);
                        if ($show_current == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
                        $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                        $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                        if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                        echo ale_wp_kses($cats);
                        if ($show_current == 1) echo ale_wp_kses($before) . get_the_title() . ale_wp_kses($after);
                    }

                } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
                    $post_type = get_post_type_object(get_post_type());
                    echo ale_wp_kses($before) . esc_attr($post_type->labels->singular_name) . ale_wp_kses($after);

                } elseif ( is_attachment() ) {
                    $parent = get_post($parent_id);
                    $cat = get_the_category($parent->ID); $cat = $cat[0];
                    $cats = get_category_parents($cat, TRUE, $delimiter);
                    $cats = str_replace('<a', $link_before . '<a' . $link_attr, $cats);
                    $cats = str_replace('</a>', '</a>' . $link_after, $cats);
                    if ($show_title == 0) $cats = preg_replace('/ title="(.*?)"/', '', $cats);
                    echo ale_wp_kses($cats);
                    printf($link, get_permalink($parent), $parent->post_title);
                    if ($show_current == 1) echo ale_wp_kses($delimiter) . ale_wp_kses($before) . get_the_title() . ale_wp_kses($after);

                } elseif ( is_page() && !$parent_id ) {
                    if ($show_current == 1) echo ale_wp_kses($before) . get_the_title() . ale_wp_kses($after);

                } elseif ( is_page() && $parent_id ) {
                    if ($parent_id != $frontpage_id) {
                        $breadcrumbs = array();
                        while ($parent_id) {
                            $page = get_page($parent_id);
                            if ($parent_id != $frontpage_id) {
                                $breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
                            }
                            $parent_id = $page->post_parent;
                        }
                        $breadcrumbs = array_reverse($breadcrumbs);
                        for ($i = 0; $i < count($breadcrumbs); $i++) {
                            echo ale_wp_kses($breadcrumbs[$i]);
                            if ($i != count($breadcrumbs)-1) echo ale_wp_kses($delimiter);
                        }
                    }
                    if ($show_current == 1) {
                        if ($show_home_link == 1 || ($parent_id_2 != 0 && $parent_id_2 != $frontpage_id)) echo ale_wp_kses($delimiter);
                        echo ale_wp_kses($before) . get_the_title() . ale_wp_kses($after);
                    }

                } elseif ( is_tag() ) {
                    echo ale_wp_kses($before) . sprintf($text['tag'], single_tag_title('', false)) . ale_wp_kses($after);

                } elseif ( is_author() ) {
                    global $author;
                    $userdata = get_userdata($author);
                    echo ale_wp_kses($before) . sprintf($text['author'], $userdata->display_name) . ale_wp_kses($after);

                } elseif ( is_404() ) {
                    echo ale_wp_kses($before) . esc_attr($text['404']) . ale_wp_kses($after);
                }

                if ( get_query_var('paged') ) {
                    if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
                    echo esc_html__('Page','yaba') . ' ' . get_query_var('paged');
                    if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
                }

                echo '</div><!-- .breadcrumbs -->';

            }
        }

        public static function products_title() {
            if (is_shop()) {
                if ( array_key_exists('orderby', $_GET) && $_GET['orderby'] === 'date' ) {
                    return 'Neue Produkte';
                }

                if ( array_key_exists('filterby', $_GET) && $_GET['filterby'] === 'featured' ) {
                    return 'Hot Deals';
                }
            }

            return false;
        }

    }
}

function ale_wp_kses($ale_string){
    $allowed_tags = array(
        'img' => array(
            'src' => array(),
            'alt' => array(),
            'width' => array(),
            'height' => array(),
            'class' => array(),
        ),
        'a' => array(
            'href' => array(),
            'title' => array(),
            'class' => array(),
        ),
        'span' => array(
            'class' => array(),
        ),
        'br' => array(),
        'div' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h1' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h2' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h3' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h4' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h5' => array(
            'class' => array(),
            'id' => array(),
        ),
        'h6' => array(
            'class' => array(),
            'id' => array(),
        ),
        'p' => array(
            'class' => array(),
            'id' => array(),
        ),
        'strong' => array(
            'class' => array(),
            'id' => array(),
        ),
        'i' => array(
            'class' => array(),
            'id' => array(),
        ),
        'del' => array(
            'class' => array(),
            'id' => array(),
        ),
        'ul' => array(
            'class' => array(),
            'id' => array(),
        ),
        'li' => array(
            'class' => array(),
            'id' => array(),
        ),
        'ol' => array(
            'class' => array(),
            'id' => array(),
        ),
        'input' => array(
            'class' => array(),
            'id' => array(),
            'type' => array(),
            'style' => array(),
            'name' => array(),
            'value' => array(),
        ),
    );
    if ( function_exists('wp_kses') ) {
        return wp_kses( $ale_string, $allowed_tags );
    }
}


