<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Change Woocommerce css breaktpoint from max width: 768px to 1024px
add_filter('woocommerce_style_smallscreen_breakpoint', function () { return '1024px'; });

// Rating (archive)
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action('woocommerce_before_shop_loop_item', 'woocommerce_template_loop_rating', 9);

// Обрізати нулі в десяткових знаках ціни
add_filter( 'woocommerce_price_trim_zeros', '__return_true');

// Add Quantity to Product (archive)
add_action( 'woocommerce_after_shop_loop_item', 'shbbp_woocommerce_after_shop_loop_item', 9 );
function shbbp_woocommerce_after_shop_loop_item() { ?>

    <div class="product_item__quantity">
        <div class="quantity">
            <button aria-label="Reduce quantity of Beanie with Logo" class="minus">－</button>
            <input class="qty"
                   type="number" step="1" min="1" max="9999"
                   aria-label="Quantity of Beanie with Logo in your cart."
                   value="1">
            <button aria-label="Increase quantity of Beanie with Logo" class="plus">＋</button>
        </div>
    </div>

    <?php
    wc_enqueue_js( "
      $('.product_item__quantity').on( 'click', 'button.plus, button.minus', function() {
        console.log('abc');
        return;
            var qty = $( this ).closest( '.product_item__quantity' ).find( '.qty' );
            var val   = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));
             console.log(val, min, max);
             
            if ( $( this ).is( '.plus' ) ) {
               if ( max && ( max <= val ) ) {
                  qty.val( max );
               } else {
                  qty.val( val + step );
               }
            } else {
               if ( min && ( min >= val ) ) {
                  qty.val( min );
               } else if ( val > 1 ) {
                  qty.val( val - step );
               }
            }
         });
   " );
}

/**
 * Sort by name function by WP Helper
 *
 * https://wphelper.io/sort-alphabetically-option-default-woocommerce-sorting/
 */
add_filter( 'woocommerce_get_catalog_ordering_args', 'wphelper_woocommerce_get_catalog_ordering_args' );
function wphelper_woocommerce_get_catalog_ordering_args( $args ) {
    $orderby_value = isset( $_GET['orderby'] ) ? woocommerce_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby' ) );

    if ( 'alphabetical' == $orderby_value ) {
        $args['orderby'] = 'title';
        $args['order'] = 'ASC';
    }

    return $args;
}

add_filter( 'woocommerce_default_catalog_orderby_options', 'wphelper_woocommerce_catalog_orderby' );

add_filter( 'woocommerce_catalog_orderby', 'wphelper_woocommerce_catalog_orderby' );
function wphelper_woocommerce_catalog_orderby( $sortby ) {
    $sortby['alphabetical'] = __( 'Sort by name' );
    return $sortby;
}