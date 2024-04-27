<?php

class Yaba_Categories_Section extends Walker_Nav_Menu {

    public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
        // Restores the more descriptive, specific name for use within this method.
        $menu_item = $data_object;

        if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

        $classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
        $classes[] = 'menu-item-' . $menu_item->ID;

        $args = apply_filters( 'nav_menu_item_args', $args, $menu_item, $depth );

        $class_names = implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $menu_item, $args, $depth ) );

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $menu_item->ID, $menu_item, $args, $depth );

        $li_atts          = array();
        $li_atts['id']    = ! empty( $id ) ? $id : '';
        $li_atts['class'] = ! empty( $class_names ) ? $class_names : '';

        $li_atts       = apply_filters( 'nav_menu_item_attributes', $li_atts, $menu_item, $args, $depth );
        $li_attributes = $this->build_atts( $li_atts );

        $output .= $indent . '<li' . $li_attributes . '>';

        $atts           = array();
        $atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
        $atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
        if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
            $atts['rel'] = 'noopener';
        } else {
            $atts['rel'] = $menu_item->xfn;
        }

        if ( ! empty( $menu_item->url ) ) {
            if ( get_privacy_policy_url() === $menu_item->url ) {
                $atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
            }

            $atts['href'] = $menu_item->url;
        } else {
            $atts['href'] = '';
        }

        $atts['aria-current'] = $menu_item->current ? 'page' : '';

        $atts       = apply_filters( 'nav_menu_link_attributes', $atts, $menu_item, $args, $depth );
        $attributes = $this->build_atts( $atts );

        $title = apply_filters( 'the_title', $menu_item->title, $menu_item->ID );

        $title = apply_filters( 'nav_menu_item_title', $title, $menu_item, $args, $depth );
        $thumbnail_id = get_term_meta( $menu_item->object_id, 'thumbnail_id', true );
        $image = wp_get_attachment_url( $thumbnail_id );

        $item_output  = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= '<span>' . $args->link_before . $title . $args->link_after . '</span>';
        $item_output .= "<img src='{$image}' alt='' width='762' height='365' />";
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $menu_item, $depth, $args );
    }
}
