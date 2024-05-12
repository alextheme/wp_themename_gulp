<?php
/**
 * Shop breadcrumb
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/global/breadcrumb.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     2.3.0
 * @see         woocommerce_breadcrumb()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! empty( $breadcrumb ) ) {

    if ( Yaba::products_title() ) {
        $breadcrumb[ array_key_last( $breadcrumb ) ][0] = Yaba::products_title();
    }

    $is_wishlist_page = -1;

    foreach ( $breadcrumb as $i => $bread ) {
        $array = array_filter(explode('/', parse_url($bread[1])['path']));
        $path = end($array);

        if ( $path === 'mein-konto' ) {
            $breadcrumb[$i][0] = 'Mein Konto';
        }

        if ( $path === 'wunschzettel' ) {
            $is_wishlist_page = $i;
        }
    }

    if ( is_user_logged_in() && $is_wishlist_page >= 0 ) {
        $last_element = array_pop( $breadcrumb );
        $breadcrumb[] = array('Mein Konto', get_permalink( get_option('woocommerce_myaccount_page_id') ) );
        $breadcrumb[] = $last_element;
    }

	echo $wrap_before;

	foreach ( $breadcrumb as $key => $crumb ) {

		echo $before;

		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}

		echo $after;

		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}

	echo $wrap_after;

}
