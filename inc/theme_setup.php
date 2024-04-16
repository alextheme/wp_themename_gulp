<?php

function _themename_setup() {

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

}
add_action( 'after_setup_theme', '_themename_setup' );

function _themename_set_global_var() {
    global $_themename_text;

    $_themename_text = array(
        'designer'            => 'test'
    );
}
add_action( 'init', '_themename_set_global_var' );
