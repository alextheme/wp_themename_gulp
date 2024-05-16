<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/js-image-zoom@0.7.0/js-image-zoom.js" type="application/javascript"></script>
    <?php wp_head(); ?>
</head>

<?php
$body_class = '';
if (array_key_exists('filterby', $_GET) && $_GET['filterby'] === 'featured') {
    $body_class = 'featured_products';
}
?>

<body <?php body_class( $body_class ); ?>>
<?php wp_body_open(); ?>


<header class="header">
    <div class="header_in">

        <div class="header__row">
            <a href="<?php echo esc_url( get_field( 'request_a_dealer_account', 'option' )['page_link'] ); ?>" class="header__top_button">Händler Account anfragen</a>
        </div>

        <div class="header__row">
            <div class="header__col_left">

                <?php /* Alle Produkte */
                if (function_exists('wc_get_page_id')) {
                    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) ); ?>
                    <button type="button" class="header__link_menu js-header__link_menu" href="<?php echo esc_url($shop_page_url); ?>" aria-label="Alle Produkte">
                        <span class="icon-menu"></span>
                        <span class="label">Alle Produkte</span>
                        <span class="icon-arrow_down"></span>
                    </button>
                <?php } ?>

                <?php // Search Form //get_search_form();
                if (function_exists('aws_get_search_form')) { ?>
                    <div class="header__search_form_wrap">
                        <?php aws_get_search_form(); ?>
                    </div>
                <?php } ?>

            </div>

            <div class="header__col_center">
                <a class="header__logo" href="<?php echo esc_url(home_url('/')) ?>" aria-label="logo">
                    <?php if ( get_field('logo_color', 'option') ) { ?>
                        <img src="<?php the_field('logo_color', 'option'); ?>" alt="ale producte icon">
                    <?php } else { ?>
                        <span class="icon_wrap">
                            <svg class="icon icon--size_mod">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#logo' ?>"></use>
                            </svg>
                        </span>
                    <?php } ?>
                </a>
            </div>

            <div class="header__col_right">

                <?php /* Search Button Mob */ ?>
                <a class="header__link header__search_mob" href="#" aria-label="search button">
                    <span class="icon-search"></span>
                </a>

                <?php /* Hot Deals */ ?>
                <a class="header__link header__hot_deals" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '?filterby=featured' )?>" aria-label="hot deals">
                    <span class="icon-hot"></span>
                    <span class="label">Hot Deals</span>
                </a>

                <?php /* Wishlist */ ?>
                <?php //echo do_shortcode("[ti_wishlist_products_counter]" ) ?>
                <a class="header__link header__wunschliste" href="<?php echo esc_url( get_home_url() . '/wunschzettel' ); ?>" aria-label="Wunschliste">
                    <span class="icon-heart"></span>
                    <span class="label">Wunschliste</span>
                </a>

                <?php /* Mini Cart Link */
                if (!is_cart()) { ?>
                    <div class="header__link_wrapper header__mini_cart">
                        <a class="header__mini_cart_button ic-cart-header-btn" href="#" aria-label="Warenkorb">
                            <span class="icon-shop"></span>
                            <span class="label">Warenkorb</span>
                            <?php if (function_exists('is_cart') && !is_cart()) { ?>
                                <span class="header__mini_cart_count">
                                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                                    <?php //echo count(WC()->cart->get_cart()); ?>
                                </span>
                            <?php } ?>
                        </a>
                        <?php //dynamic_sidebar('header-widget-mini-cart') ?>
                    </div>
                <?php } ?>

                <?php /* Profil */ ?>

                <a class="header__link header__profil" href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) )?>" aria-label="Profil">
                    <span class="icon-profil"></span>
                    <span class="label">Profil</span>
                </a>

            </div>
        </div>
    </div>

    <nav id="header_nav_menu_category">
        <?php wp_nav_menu(
            array(
                'theme_location' => 'header_menu',
                'container_class' => 'menu_category',
                'walker' => new Yaba_Categories_Section(),
            )
        ) ?>

        <div class="header_nav_menu_footer">
            <div class="header_nav_menu_footer__in">
                <a class="footer__link tel" href="tel:+6517489523"><?php the_field('phone', 'option'); ?></a>
                <a class="footer__link mail" href="mailto:examle@gmail.com"><?php the_field('email', 'option'); ?></a>
                <ul class="footer__socials">
                    <?php
                    $array_socials = get_field('socials_links', 'option');

                    foreach ($array_socials as $social => $link) {
                        if ($link) { ?>
                            <li>
                                <a href="<?= esc_url($link) ?>" aria-label="link <?= $social ?>">
                                    <span class="icon-<?php echo $social; ?>"></span>
                                </a>
                            </li>
                        <?php } } ?>

                </ul>
                <a class="footer__button footer__button--mobile_menu" href="<?php echo esc_url( get_field( 'request_a_dealer_account', 'option' )['page_link'] ); ?>">Händler Account anfragen</a>
            </div>
        </div>
    </nav>
</header>
