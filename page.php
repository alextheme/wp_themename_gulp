<?php get_header(); ?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">

        <?php if ( have_posts() ) : while ( have_posts() ) : the_post();  ?>

            <!-- Вивід постів, функцій цикла: the_title() і т.п -->
            <?php
            $page_name = '';
            if (function_exists('is_account_page') && is_account_page()) $page_name = 'my_account_page';
            if (function_exists('is_cart') && is_cart()) $page_name = 'cart_page';
            if (is_page('cart-classic')) $page_name = 'cart_classic_page';
            if (function_exists('is_checkout') && is_checkout()) $page_name = 'checkout_page';
            ?>

            <section class="section <?php echo esc_attr($page_name); ?>">
                <div class="section_in">

                <?php if (!is_page([
                    'my-account',
                    'wishlist',
                    'cart', '_cart', 'cart-classic',
                    'checkout', '_checkout',
                ])) { ?>
                    <h2><?php the_title(); ?></h2>
                <?php } ?>

                <?php the_content(); ?>

                </div>
            </section>

        <?php endwhile; else: ?>
            Записів немає
        <?php endif; ?>


    </main>
</div>

<?php get_footer(); ?>
