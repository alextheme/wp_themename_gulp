<?php if(!defined('ABSPATH')) die('No direct access allowed');

/*
  Template Name: Template Wishlist
 */

get_header( 'wishlist' );

/**
 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
 * @hooked woocommerce_breadcrumb - 20
 * @hooked WC_Structured_Data::generate_website_data() - 30
 */
do_action( 'woocommerce_before_main_content' ); ?>

    <header class="woocommerce-products-header">
        <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
            <h1 class="woocommerce-products-header__title page-title"><?php esc_html_e( 'Wishlist', '_tyemename' ); ?></h1>
        <?php endif; ?>
    </header>

<?php

if ( woocommerce_product_loop() ) {

    /**
     * @hooked woocommerce_output_all_notices - 10
     * @hooked woocommerce_result_count - 20
     * @hooked woocommerce_catalog_ordering - 30
     */
//    do_action( 'woocommerce_before_shop_loop' );

    woocommerce_product_loop_start();

    if (is_user_logged_in()) {
        $user_id = get_current_user_id();
        $wishlist_items = get_user_meta($user_id, 'yaba_wishlist_product');

        if (count($wishlist_items) > 0) {
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => -1,
                'post__in' => $wishlist_items,
                'order_by' => 'post__in'
            );
            $wish_products = new WP_Query($args);


            if ( $wish_products->have_posts() ) {
                while ( $wish_products->have_posts() ) {
                    $wish_products->the_post();

                    do_action( 'woocommerce_shop_loop' );

                    wc_get_template_part( 'content', 'product' );
                }
            }
        } else {
            esc_html_e('No Products in Wishlist', '_themename');
        }

    }
    woocommerce_product_loop_end();

    /**
     * @hooked woocommerce_pagination - 10
     */
    do_action( 'woocommerce_after_shop_loop' );
} else {
    /**
     * @hooked wc_no_products_found - 10
     */
    do_action( 'woocommerce_no_products_found' );
}

/**
 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
 */
do_action( 'woocommerce_after_main_content' );


get_footer( 'wishlist' );


