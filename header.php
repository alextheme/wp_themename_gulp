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

                <?php /* Alle Producte */
                if (function_exists('wc_get_page_id')) {
                    $shop_page_url = get_permalink( wc_get_page_id( 'shop' ) ); ?>
                    <a class="header__link_shop" href="<?php echo esc_url($shop_page_url); ?>" aria-label="Alle Producte">
                        <span class="icon_wrap">
                            <svg class="icon icon--size_mod">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#spin' ?>"></use>
                            </svg>
                        </span>
                        <span class="label">Alle Producte</span>
                        <span class="icon_wrap_2">
                            <svg class="icon icon--size_mod">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#small_arrow_down' ?>"></use>
                            </svg>
                        </span>
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
                    <span class="icon_wrap">
                        <svg class="icon icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#search_m' ?>"></use>
                        </svg>
                    </span>
                </a>


                <?php /* Hot Deals */ ?>
                <a class="header__link header__hot_deals" href="/hot-deals" aria-label="hot deals">
                    <span class="icon_wrap">
                        <svg class="icon icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#percent' ?>"></use>
                        </svg>
                    </span>
                    <span class="label">Hot Deals</span>
                </a>

                <?php /* Wunschliste */ ?>
                <a class="header__link header__wunschliste" href="#" aria-label="Wunschliste">
                    <span class="icon_wrap">
                        <svg class="icon icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#heart' ?>"></use>
                        </svg>
                    </span>
                    <span class="label">Wunschliste</span>
                </a>

                <?php /* Warenkorb */ ?>
                <a class="header__link header__warenkorb" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'cart' ) ) )?>" aria-label="Warenkorb">
                    <span class="icon_wrap">
                        <svg class="icon icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#shop' ?>"></use>
                        </svg>
                    </span>
                    <span class="label">Warenkorb</span>
                    <span class="header__warenkorb_cnt">
                        <?php echo WC()->cart->get_cart_contents_count(); ?>
                        <?php //echo count(WC()->cart->get_cart()); ?>
                    </span>
                </a>


                <?php /* Profil */ ?>
                <a class="header__link header__profil" href="<?php echo esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) )?>" aria-label="Profil">
                    <span class="icon_wrap">
                        <svg class="icon icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#profil' ?>"></use>
                        </svg>
                    </span>
                    <span class="label">Profil</span>
                </a>

            </div>






        </div>

        <div class="header__row">

<!--            --><?php
//            $args = array(
//                'theme_location' => 'header_menu',
//                'depth' => 1,
//                'container' => 'nav',
//                'container_class' => 'header__nav',
//                'menu_class' => 'header_menu__list notranslate',
//            );
//
//            $header_menu = wp_nav_menu($args);
//            ?>
        </div>

    </div>
    </div>
</header>
