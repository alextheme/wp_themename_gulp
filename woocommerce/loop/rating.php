<?php
/**
 * Loop Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://woo.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}
?>

<div class="product__header">
    <a class="product__rating_link" href="<?php echo get_the_permalink() ?>#respond">
        <?php echo wc_get_rating_html( $product->get_average_rating() ); // WordPress.XSS.EscapeOutput.OutputNotEscaped. ?>
    </a>
    <button class="product__favorite_btn button_add_to_wish_list"><!-- product__favorite_btn--active -->
        <span class="icon_wrap">
            <svg class="icon icon--size_mod">
                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#heart2' ?>"></use>
            </svg>
        </span>
    </button>
</div>


