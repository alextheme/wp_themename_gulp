<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>


<header class="header">
    <div class="header_in">
        <div class="header__row">

            <?php if (function_exists('wc_get_cart_url')) { ?>
            <div class="header__link_shop">
                <a href="<?php echo esc_url(wc_get_cart_url()); ?>">
                    <span class="icon_wrap">
                        <svg class="icon icon_basket icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#spin' ?>"></use>
                        </svg>
                    </span>
                    <span>Alle Producte</span>
                </a>
            </div>
            <?php } ?>

            <?php // Search Form
            if (function_exists('aws_get_search_form')) {
                aws_get_search_form();
            } ?>

            <div class="header__logo">
                <a href="<?php echo esc_url(home_url('/')) ?>">
                    <?php if (the_field('logo_color', 'option')) { ?>
                        <img src="<?php the_field('logo_color', 'option'); ?>" alt="ale producte icon">
                    <?php } else { ?>
                        <span class="icon_wrap">
                            <svg class="icon icon_basket icon--size_mod">
                                <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#logo' ?>"></use>
                            </svg>
                        </span>
                    <?php } ?>
                </a>
            </div>

            <div class="header__hot_deals">
                <a href="/hot-deals">
                    <span class="icon_wrap">
                        <svg class="icon icon_basket icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#percent' ?>"></use>
                        </svg>
                    </span>
                    <span>Hot Deals</span>
                </a>
            </div>

            <div class="header__wunschliste">
                <a href="#">
                    <span class="icon_wrap">
                        <svg class="icon icon_basket icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#percent' ?>"></use>
                        </svg>
                    </span>
                    <span>Wunschliste</span>
                </a>
            </div>

            <div class="header__warenkorb">
                <a href="#">
                    <span class="icon_wrap">
                        <svg class="icon icon_basket icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#shop' ?>"></use>
                        </svg>
                    </span>
                    <span>Warenkorb</span>
                </a>
                <span class="header__warenkorb_cnt">
                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                    <?php //echo count(WC()->cart->get_cart()); ?>
                </span>
            </div>

            <div class="header__profil">
                <a href="#">
                    <span class="icon_wrap">
                        <svg class="icon icon_basket icon--size_mod">
                            <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#profil' ?>"></use>
                        </svg>
                    </span>
                    <span>Profil</span>
                </a>
            </div>
        </div>

        <div class="header__row">
            <?php
            $args = array(
                'theme_location' => 'header_menu',
                'depth' => 1,
                'container' => 'nav',
                'container_class' => 'header__nav',
                'menu_class' => 'header_menu__list notranslate',
            );

            $header_menu = wp_nav_menu($args);
            ?>
        </div>
    </div>
    </div>
</header>

<div class="wrapper">
    <div class="base">