<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>
            <?php
            $section_classes = 'default_page';
            if (function_exists('is_account_page') && is_account_page()) {
                $section_classes = 'my_account_page';
            }
            if (function_exists('is_cart') && is_cart()) {
                $section_classes = 'cart_page';
            }
            if (function_exists('is_checkout') && is_checkout()) {
                $section_classes = 'checkout_page';
            }
            if (function_exists('is_wishlist') && is_wishlist()) {
                $section_classes = 'wishlist_page';
            }
            if (is_page_template( 'template-home-page.php' )) {
                $section_classes = 'home_page';
            }
            if ( is_page() ) {
                $path = array_filter(explode('/', $_SERVER['REQUEST_URI'] ));
                $section_classes .= ' ' . end($path) . '_page';
            }

            ?>

        <?php woocommerce_breadcrumb(); ?>
        <?php //Yaba::breadcrumbs(); ?>

            <section class="section <?php echo esc_attr($section_classes); ?>">
                <div class="section_in">

                    <?php
                    if ( str_contains( $section_classes, 'passwort-vergessen' ) ) { ?>

                        <h2>Passwort vergessen</h2>

                    <?php  } elseif (!is_page([
                        'my-account',
                        'wishlist',
    //                    'cart', '_cart', 'cart-classic',
    //                    'checkout', '_checkout',
                    ])) { ?>
                        <h2><?php the_title(); ?></h2>
                    <?php }

                if ( function_exists('is_cart') && is_cart() ) {
                    echo do_shortcode('[woocommerce_cart]');
                } elseif ( function_exists('is_checkout') && is_checkout() ) {
                    echo do_shortcode('[woocommerce_checkout]');
                } else {
                    the_content();
                } ?>



                </div>
            </section>

        <?php endwhile; else: ?>
            Es gibt keine Aufzeichnungen
        <?php endif; ?>


    </main>
</div>

<?php get_footer(); ?>
