<?php

add_action( 'after_setup_theme', function () {

    $GLOBALS['content_width'] = apply_filters('_themename_content_width', 1520);

    if( function_exists('register_nav_menus') ) {
        register_nav_menus(
            array(
                'header_menu' => esc_html__( 'Header menu', '_themename' ),
                'category_menu' => esc_html__( 'Menu Category', '_themename' ),
                'footer_category' => esc_html__( 'Footer Category', '_themename' ),
                'footer_menu' => esc_html__( 'Footer menu', '_themename' ),
            )
        );
    }

    // Додати поле для іконки в адмінці меню
    function add_menu_icons_field() {
        global $nav_menu_selected_id;
        ?>
        <div class="posttypediv" id="posttype-nav_menu">
            <div class="tabs-panel" id="menu-item-settings-<?php echo $nav_menu_selected_id; ?>">
                <p class="field-icon description description-wide">
                    <label for="edit-menu-item-icon-<?php echo $nav_menu_selected_id; ?>">
                        <?php _e('Icon', '_themename'); ?><br />
                        <input type="text" id="edit-menu-item-icon-<?php echo $nav_menu_selected_id; ?>" class="widefat code edit-menu-item-icon" name="menu-item-icon[<?php echo $nav_menu_selected_id; ?>]" value="" />
                    </label>
                </p>
            </div>
        </div>
        <?php
    }
    add_action('wp_nav_menu_item_custom_fields', 'add_menu_icons_field', 10, 4);

    // Зберегти значення іконки
    function save_menu_icons_field($menu_id, $menu_item_db_id, $menu_item_args) {
        if (isset($_REQUEST['menu-item-icon'][$menu_item_db_id])) {
            $icon_value = $_REQUEST['menu-item-icon'][$menu_item_db_id];
            update_post_meta($menu_item_db_id, '_menu_item_icon', $icon_value);
        }
    }
    add_action('wp_update_nav_menu_item', 'save_menu_icons_field', 10, 3);

    // ACF Options Page
    if( function_exists('acf_add_options_page') ) {
        acf_add_options_page();
    }

    if( function_exists( 'add_theme_support' ) ) {

        add_theme_support( 'post-thumbnails' );
        //set_post_thumbnail_size( 150, 150, false );

        add_theme_support( 'automatic-feed-links' );

        add_theme_support( 'title-tag' );

        add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        add_theme_support( 'woocommerce' );
    }

    if( function_exists( 'load_theme_textdomain' ) ) {
        load_theme_textdomain( '_themename', get_template_directory() . '/languages' );
    }

} );

add_action('widgets_init', function () {
    register_sidebar(array(
        'name' => esc_html__('Sidebar', '_themename'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', '_themename'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar(
        array(
            'name' => esc_html__( 'Sidebar For Filters', '_themename'),
            'id' => 'filter',
            'description' => esc_html__( 'Add widgets here.', '_themename'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
        )
    );
});

//add_filter('aws_searchbox_markup', function ($markup, $params) {
//
//    $search_string = '<svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px"><path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"></path></svg>';
//    $replace_string = '<svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 26"><path d="M25.7,24.3L19.4,18c1.6-1.9,2.6-4.4,2.6-7c0-6.1-4.9-11-11-11S0,4.9,0,11s4.9,11,11,11c2.7,0,5.1-1,7-2.6l6.3,6.3 c0.2,0.2,0.5,0.3,0.7,0.3s0.5-0.1,0.7-0.3C26.1,25.3,26.1,24.7,25.7,24.3z M2,11c0-5,4-9,9-9c5,0,9,4,9,9c0,5-4,9-9,9 C6,20,2,16,2,11z"></path></svg>';
//
//    if ( !str_contains($markup, $replace_string) ) {
//        $new_markup = str_replace($search_string, $replace_string, $markup);
//    }
//
//    return $new_markup;
//}, 10, 2);


