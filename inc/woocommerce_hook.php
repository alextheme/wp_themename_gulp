<?php

if (!defined('ABSPATH')) {
    exit;
}

// Change Woocommerce css breaktpoint from max width: 768px to 1024px
add_filter('woocommerce_style_smallscreen_breakpoint', function () { return '1024px'; });

// Обновлення міні-кошика
add_filter( 'woocommerce_add_to_cart_fragments', function ( $fragments ) {
    $count_prod = WC()->cart->get_cart_contents_count(); //count( WC()->cart->get_cart() )
    $fragments['.header__mini_cart_count'] = '<span class="header__mini_cart_count">' . $count_prod . '</span>';
    return $fragments;
} );

// Rating (archive)
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 9);

// Обрізати нулі в десяткових знаках ціни
add_filter('woocommerce_price_trim_zeros', '__return_true');

// Move Price of Product (archive)
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
add_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_price', 6);

// Add Footer wrapper of product and Quantity of product (archive)
add_action('woocommerce_after_shop_loop_item', '_themename_woocommerce_after_shop_loop_item', 9);
function _themename_woocommerce_after_shop_loop_item() {
    global $product; ?>

    <div class="product_item__footer">

    <?php if ($product->get_type() === 'simple') { ?>
        <div class="product_item__quantity">
            <div class="quantity">
                <button class="minus" aria-label="Reduce quantity of product">－</button>
                <input class="qty" type="number" step="1" min="1" max="9999" value="1"
                       aria-label="Quantity of product in your cart.">
                <button class="plus" aria-label="Increase quantity of product">＋</button>
            </div>
        </div>
    <?php }
}
add_action('woocommerce_after_shop_loop_item', function () { ?>
    </div><!-- .product_item__footer -->  <?php
}, 11);

/*
 * Menu Categories
 */
add_action( 'woocommerce_archive_description', '_themename_add_menu_categories' );
function _themename_add_menu_categories() { ?>

    <div class="wc_products_header__menu_cat">
        <label class="label">Verwandte Kategorien</label>
        <?php
        wp_nav_menu(array(
            'theme_location' => 'category_menu',
            'container' => false,
        ))
        ?>
    </div>

<?php }

/*
 * Featured Product List in Shop
 */
add_action( 'woocommerce_after_main_content', '_themename_add_featured_products_list', 5 );
function _themename_add_featured_products_list() { ?>
    <div class="shop__featured_products_wrapper js-slick-products">

        <header class="woocommerce-products-header">
            <h1 class="woocommerce-products-header__title page-title">
                <?php echo esc_html( 'Angesehene Produkte' ); ?>
            </h1>
        </header>

        <?php // Show Featured Products Block ?>
        <div class="featured_products">
            <?php echo do_shortcode('[featured_products columns=6 limit=6]')?>
        </div>
        <div class="featured_products_mobile">
            <?php echo do_shortcode('[featured_products columns=6 limit=6]')?>
        </div>

    </div>
    <?php
}

/*
 * Селектор для сортування
 * https://wphelper.io/sort-alphabetically-option-default-woocommerce-sorting/
 */
add_filter('woocommerce_default_catalog_orderby_options', '_thememane_woocommerce_catalog_orderby');
add_filter('woocommerce_catalog_orderby', '_thememane_woocommerce_catalog_orderby');
function _thememane_woocommerce_catalog_orderby($sortby) {
    $sortby['menu_order'] = 'Sorted by';
    $sortby['popularity'] = 'Popularity';
    $sortby['price'] = 'Price (Decreasing)';
    $sortby['price-desc'] = 'Price (Increasing)';
    unset($sortby['rating']);
    unset($sortby['date']);

    return $sortby;
}

remove_action('woocommerce_before_shop_loop', 'woocommerce_result_count', 20);
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );

// Хлебные крошки
add_filter( 'woocommerce_breadcrumb_defaults', function () {
    return array(
        'delimiter'   => '<span class="breadcrumb-separator icon-arrow_right_small"></span>',
        'wrap_before' => '<nav class="breadcrumb woocommerce-breadcrumb">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => __( 'Home', 'woostudy' ),
    );
} );

// Pagination
add_filter('woocommerce_pagination_args', function ($args) {
    $args['type'] = 'plain';
    $args['prev_text'] = '<span class="icon-arrow-left"></span><span>Zurück</span>';
    $args['next_text'] = '<span>Mehr</span><span class="icon-arrow-right"></span>';
    return $args;
});

/*
 * Add wrapper for item product
 */
add_action( 'woocommerce_before_shop_loop_item', function () { echo '<div class="product_item__wrapper">'; }, 5 );
add_action( 'woocommerce_after_shop_loop_item', function () { echo '</div>'; }, 20 );

/**
 * SINGLE PRODUCT
 */
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

/*
 * Add buttons PLUS & MINUS Quantity
 */
add_action( 'woocommerce_after_quantity_input_field', '_themename_quantity_plus' );
add_action( 'woocommerce_before_quantity_input_field', '_themename_quantity_minus' );
function _themename_quantity_plus() {
    echo '<button type="button" class="plus">+</button>';
}
function _themename_quantity_minus() {
    echo '<button type="button" class="minus">-</button>';
}

/*
 * TABS in product single page
 */
add_filter( 'woocommerce_product_tabs', '_themename_add_product_tab', 100 );
function _themename_add_product_tab( $tabs ) {
    unset( $tabs['reviews'] );
    unset( $tabs['additional_information'] );

    $tabs['description']['title'] = __( 'Beschreibung', 'woocommerce' );
    add_filter( 'woocommerce_product_description_heading', function() { return ''; } );

    $tabs['ingredients'] = array(
        'title' => __( 'Inhaltsstoffe', 'woocommerce' ), // TAB TITLE
        'priority' => 20, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        'callback' => '_themename_ingredients_product_tab_content', // TAB CONTENT CALLBACK
    );
    $tabs['delivery'] = array(
        'title' => __( 'Lieferung', 'woocommerce' ), // TAB TITLE
        'priority' => 30, // TAB SORTING (DESC 10, ADD INFO 20, REVIEWS 30)
        'callback' => '_themename_delivery_product_tab_content', // TAB CONTENT CALLBACK
    );
    return $tabs;
}
function _themename_ingredients_product_tab_content() {
    global $product;
    $content = get_field('ingredients', $product->get_id() );
    echo $content;
}
function _themename_delivery_product_tab_content() {
    global $product;
    $content = get_field('delivery', $product->get_id() );
    echo $content;
}

/*
 * Variable Product Buttons
 */
add_action( 'woocommerce_after_add_to_cart_quantity', '_themename_add_variation_product_list_buttons_variable', 10 );
function _themename_add_variation_product_list_buttons_variable() {
    global $product;

    if ( $product->is_type( 'variable' ) ) { ?>

        <ul class="variations_form__var_list">
            <?php global $product;
            $variations = $product->get_available_variations();
            $default_attr = $product->get_default_attributes();
            $variation_data_localize = array(
                'default_variation_id' => 0,
                'price_html' => '',
                'image' => '',
            );

            foreach ( $variations as $variation ) {
                $variation_attributes = Yaba::replace_array_keys($variation['attributes']);

                if ( Yaba::compare_arrays($default_attr, $variation_attributes) ) {
                    $variation_data_localize['default_variation_id'] = $variation['variation_id'];
                    $variation_data_localize['price_html'] = $variation['price_html'];
                    $variation_data_localize['image'] = $variation['image']['full_src'];
                }
            }

            foreach ( $variations as $variation ) {

                $variation_data_localize['price_base_html'] = '<span class="price">' . $product->get_price_html() . '</span>';
                wp_localize_script( '_themename-scripts', 'variationData', $variation_data_localize);

                $array_data_variation = array(
                    'attributes' => $variation['attributes'],
                    'product_id' => $product->get_id(),
                    'price_html' => $variation['price_html'],
                    'variation_id' => $variation['variation_id'],
                    'image' => $variation['image']['full_src'],
                    'image_html' => wc_get_gallery_image_html( $variation['image_id'], true ),
                );

                ?>
                <li class="variations_form__var_item <?php echo esc_attr( $variation_data_localize['default_variation_id'] === $variation['variation_id'] ? 'variations_form__var_item--active' : '' ); ?>">
                    <button type="button" class="variations_form__var_btn"
                            data-json_data="<?php echo htmlspecialchars( json_encode($array_data_variation) ); ?>"
                    >
                        <img src="<?php echo $variation['image']['thumb_src'] ?>" alt="">
                    </button>
                </li>
                <?php

            } ?>
        </ul>

    <?php } ?>

    <div class="product_summary_footer">
        <div class="add_to_cart_button__wrapper">
            <!-- Pays Services list -->
<?php
}

add_action( 'woocommerce_after_add_to_cart_button', '_themename_pay_service_list_and_close_div', 10 );
add_action( 'woocommerce_after_add_to_cart_button', '_themename_close_div_product_summary_footer', 20 );

/*
 * Pays list in single page product
 */
function _themename_pay_service_list_and_close_div() { ?>

        <?php
        $array_pays_icons = array( 'visa', 'mastercard', 'gpay', 'paypal', 'apay' );
        $array_pays_icons = get_field('pay_services', 'option');
        if ($array_pays_icons && count($array_pays_icons) > 0) { ?>

            <ul class="pay_services_list">

                <?php foreach ($array_pays_icons as $icon) { ?>
                    <li>
                        <span class="pay_service pay_service__<?= $icon ?>" aria-label="pay service <?= $icon ?>">
                            <span class="icon_wrap">
                                <svg class="icon icon--size_mod">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#' . $icon . '2' ?>"></use>
                                </svg>
                            </span>
                        </span>
                    </li>
                <?php } ?>

            </ul>
        <?php } ?>

    </div><!-- .add_to_cart_button__wrapper -->

    <?php
}
function _themename_close_div_product_summary_footer() {
    echo '</div><!-- .product_summary_footer -->';
}

/*
 * Remove Upsell & Related products list in Single page
 */
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
/*
 * Featured Product List in Single page
 */
//add_action( 'woocommerce_after_single_product_summary', '_themename_add_featured_products_list', 10 );

