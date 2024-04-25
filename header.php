<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>


<header class="header">
    <div class="header_in">

        <div class="header__row">
            <button class="header__top_button">Händler Account anfragen</button>
        </div>

        <div class="header__row">
            <div class="header__col_left">

                <?php /* Alle Produkte */
                if (function_exists('wc_get_page_id')) {
                    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) ); ?>
                    <a class="header__link_shop" href="<?php echo esc_url($shop_page_url); ?>" aria-label="Alle Produkte">
                        <span class="icon-menu"></span>
                        <span class="label">Alle Produkte</span>
                        <span class="icon-arrow_down"></span>
                    </a>
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
                <a class="header__link header__hot_deals" href="/hot-deals" aria-label="hot deals">
                    <span class="icon-hot"></span>
                    <span class="label">Hot Deals</span>
                </a>

                <?php /* Wishlist */ ?>
                <?php //echo do_shortcode("[ti_wishlist_products_counter]" ) ?>
                <a class="header__link header__wunschliste" href="http://localhost/yaba/wishlist/" aria-label="Wunschliste">
                    <span class="icon-heart"></span>
                    <span class="label">Wunschliste</span>
                </a>

                <?php /* Mini Cart Link */ ?>
                <div class="header__link_wrapper header__mini_cart">
                    <a class="header__lnk" href="#<?php //echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) )?>" aria-label="Warenkorb">
                        <span class="icon-shop"></span>
                        <span class="label">Warenkorb</span>
                        <?php if (function_exists('is_cart') && !is_cart()) { ?>
                            <span class="header__mini_cart_count">
                                <?php echo WC()->cart->get_cart_contents_count(); ?>
                                <?php //echo count(WC()->cart->get_cart()); ?>
                            </span>
                        <?php } ?>
                    </a>
                    <?php dynamic_sidebar('header-widget-mini-cart') ?>
                </div>

                <?php /* Profil */ ?>
                <a class="header__link header__profil" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) )?>" aria-label="Profil">
                    <span class="icon-profil"></span>
                    <span class="label">Profil</span>
                </a>

            </div>
        </div>
    </div>
    </div>
</header>
