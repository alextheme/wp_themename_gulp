<?php

/* Template Name: Template Home Page */

get_header();

do_action( 'woocommerce_before_main_content' );

global $post;

if (function_exists('get_field')) { ?>

    <section class="home_section hero">
        <div class="section_header hero_header">
            <h2 class="section_title">The sweetest store in Germany</h2>
            <a href="#">Alle Marken</a>
        </div>

        <?php $hero_slider = get_field('hero_slider', 'option'); ?>
        <?php $hero_brands = get_field('hero_brands', 'option'); ?>

        <?php if (count($hero_slider) > 0) { ?>
        <div class="hero_slider">
            <ul class="hero_slider_list js-hero_slider">
                <?php foreach ($hero_slider as $item) { ?>
                <li class="hero_slider_item">
                    <a href="<?php echo esc_url( $item['link'] ); ?>">
                        <img src="<?php echo esc_url( $item['image'] ); ?>" alt="">
                    </a>
                </li>
                <?php } ?>
            </ul>
        </div>
        <?php } ?>

        <?php if (count($hero_brands) > 0) { ?>
            <div class="hero_brands">
                <ul class="hero_brands_list">
                    <?php for ($i = 0; $i < 2; $i++) { ?>
                        <?php foreach ($hero_brands as $item) { ?>
                            <li class="hero_brands_item">
                                <a href="<?php echo esc_url( $item['link'] ); ?>">
                                    <img src="<?php echo esc_url( $item['image'] ); ?>" alt="">
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        <?php } ?>

    </section><!-- .hero -->

    <section class="home_section home_cat">
        <div class="section_header home_cat_header">
            <h2 class="section_title">The sweetest store in Germany</h2>
            <a href="#">Alle Kategorien</a>
        </div>

        <?php wp_nav_menu(
            array(
                'theme_location' => 'category_section',
                'container_class' => 'home_category_section',
                'walker' => new Yaba_Categories_Section(),
            )
        ) ?>
    </section>

    <section class="home_section hot_products">
        <div class="section_header hot_products_header">
            <h2 class="section_title">Hot Deals</h2>
            <a href="#">Alle Hot-Deals</a>
        </div>

        <div class="hot_products_slider js-slick-hot_products">
            <?php echo do_shortcode('[featured_products columns=6]')?>
        </div>
    </section>

<?php }

do_action( 'woocommerce_after_main_content' );

get_footer();
