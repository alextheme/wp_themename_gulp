<?php

if (!defined('ABSPATH')) {
    exit;
}

// Change Woocommerce css breaktpoint from max width: 768px to 1024px
add_filter('woocommerce_style_smallscreen_breakpoint', function () { return '1024px'; });

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
function _themename_woocommerce_after_shop_loop_item()
{
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
add_action('woocommerce_after_shop_loop_item', function () { ?>  </div><!-- .product_item__footer -->  <?php }, 11);

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









