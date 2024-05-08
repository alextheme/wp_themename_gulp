<?php

/* Template Name: Template Home Page */

get_header();  ?>

<div id="home_page" class="content-area home_page">
    <main id="main" class="site-main">

<?php if (function_exists('get_field')) { ?>

    <section class="section hero">
        <div class="section_in">

            <div class="section_header">
                <h2 class="section_title">The sweetest store in Germany</h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) )?>">Alle Marken</a>
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

<!--            <div class="section_footer">-->
<!--                <a href="--><?php //echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) )?><!--">Alle Marken</a>-->
<!--            </div>-->

        </div>
    </section><!-- .hero -->

    <?php if (count($hero_brands) > 0) { ?>
        <div class="hero_brands">
            <ul class="hero_brands_list">
                <?php for ($i = 0; $i < 3; $i++) { ?>
                    <?php foreach ($hero_brands as $item) { ?>
                        <li class="hero_brands_item">
                            <a href="<?php echo esc_url( $item['link'] ); ?>">
                                <img src="<?php echo esc_url( $item['image'] ); ?>" alt="">
                            </a>
                        </li>
                    <?php } ?>
                <?php } ?>
            </ul>
        </div><!-- .hero_brands -->
    <?php } ?>

    <section class="section home_cat">
        <div class="section_in">

            <div class="section_header">
                <h2 class="section_title">The sweetest store in Germany</h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) )?>">Alle Kategorien</a>
            </div>

            <?php
            $category_styles = get_field( 'home_category_nav_styles', 'option' );
            if ($category_styles && count($category_styles) > 0) {
            ?>
            <style>
                <?php $inx = 0; foreach ($category_styles as $style) {
                    $clr = $category_styles[ $inx ]['color'];
                    $bgr = $category_styles[ $inx ]['background_image'];
                    ?>
                .home_cat .menu .menu-item:nth-child(<?= $inx + 1 ?>) {
                    border-color: <?= $clr; ?>;
                    background: <?= $clr; ?>;
                    background-image: url("<?= $bgr; ?>");
                    background-image: url("<?= $bgr; ?>"), linear-gradient(#fff, <?= $clr; ?>);
                }
                <?php $inx++; } ?>
            </style>
            <?php } ?>

            <?php wp_nav_menu(
                array(
                    'theme_location' => 'category_section',
                    'container_class' => 'home_nav_category',
                    'walker' => new Yaba_Categories_Section(),
                )
            ) ?>

            <div class="section_footer">
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) )?>">Alle Kategorien</a>
            </div>
        </div>
    </section><!-- .home_cat -->

    <section class="section hot_products">
        <div class="section_in">
            <div class="section_header">
                <h2 class="section_title">Hot Deals</h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '?filterby=featured' )?>">Alle Hot Deals</a>
            </div>

            <?php echo do_shortcode( '[products visibility="featured" limit=12 class="products_slider js-slick-home_products"]' )?>

            <div class="section_footer">
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '?filterby=featured' )?>">Alle Hot Deals</a>
            </div>
        </div>

        <div class="hot_products__decors">
            <span></span>
            <span></span>
        </div>
    </section><!-- .hot_products -->

    <section class="section new_products">
        <div class="section_in">
            <div class="section_header">
                <h2 class="section_title">Neue Produkte</h2>
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '/?orderby=date' ); ?>">Alle neuen Produkte</a>
            </div>

            <?php echo do_shortcode( '[products visibility="visible" orderby="date" order="DESC" limit=12 class="products_slider js-slick-home_products"]' )?>

            <div class="section_footer">
                <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) . '/?orderby=date' ); ?>">Alle neuen Produkte</a>
            </div>
        </div>

        <div class="new_products__decors">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </section><!-- .new_products -->

    <section class="section features_section">

        <?php $features = get_field('features', 'option'); ?>
        <?php if (count($features) > 0) { ?>
        <div class="features_list__wrapper">

            <ul class="features_list">
            <?php $i = 0; $border_pos = array('left', 'top', 'bottom', 'right'); $border_style = ''; ?>
            <?php foreach ($features as $feature) { ?>
                <?php $border_style .= "border-{$border_pos[$i % 4]}-color: {$features[$i]['color']};"; ?>

                <li class="feature_item" data-color="<?php echo esc_attr( $feature['color'] ); ?>">
                    <div class="feature_item__in"
                         style="
                             border-color: <?= esc_attr( $features[$i]['color'] ); ?>;
                             background: linear-gradient(135deg, #ffffff 0%, <?= esc_attr( $features[$i]['color'] ); ?> 100%);
                             ">
                        <h3 class="feature_item__title"><?php echo esc_html( $feature['title'] ); ?></h3>
                        <div class="feature_item__description"><?php echo wp_kses_post( $feature['description'] ); ?></div>
                        <div class="features_item__icon">
                            <img src="<?php echo esc_html( $feature['icon'] ); ?>" alt="">
                        </div>
                        <?php if ($i === 0) { ?>
                            <div class="feature_logo__bottom_bg">
                                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/home/feature_bg.png') ?>" alt="">
                            </div>
                            <div class="feature_logo">
                                <div class="feature_logo__border"></div>
                                <div class="feature_logo__mask"></div>
                                <a class="feature_logo__link" href="<?php echo esc_url(home_url('/')) ?>" aria-label="logo">
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
                        <?php } $i++; ?>
                    </div>
                </li>
            <?php } ?>
        </ul>

            <div class="feature_logo__bg_mob">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/home/feature_bg.png') ?>" alt="">
            </div>

            <style id="border_style">
                .feature_logo__border {
                    <?= esc_attr( $border_style ); ?>
                }
            </style>
        </div>
        <?php } ?>

    </section><!-- .features_section -->

    <section class="section home_category_buttons">
        <div class="section_in">
            <div class="section_header">
                <h2 class="section_title">We have candy of every kind </h2>
                <p class="section_description">Wonach suchst du?</p>
            </div>

            <?php wp_nav_menu(
                array(
                    'theme_location' => 'category_section',
                    'container_class' => 'home_nav_category_buttons',
                )
            ) ?>

            <a href="#" class="home_category_button__more_categories">mehr Kategorien</a>
            <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) )?>" class="home_category_button__all_products">Alle Produkte</a>
        </div>

        <ul class="home_category_buttons__decors">
           <?php for ($j = 1; $j <= 6; $j++) { ?>
               <li><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/home/buttons_section_decors/' . $j . '.png' )?>" alt=""></li>
           <?php } ?>
        </ul>
    </section><!-- .home_category_buttons -->

    <section class="section home_about">
        <div class="section_in">
            <div class="home_about__top_decor">
                <spqn class="line"></spqn>
                <a class="home_about__link" href="<?php echo esc_url(home_url('/')) ?>" aria-label="logo">
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
                <span class="line"></span>
            </div>
            <div class="home_about__content">
                <h3 class="home_about__content_title">Yaba Land of Candy – Ihr Süßigkeiten-Online-Shop für Süßwaren aus aller Welt.</h3>
                <div class="home_about__content_text">
                    <?php echo wp_kses_post( get_field( 'about', 'option' ) ); ?>
                </div>
                <button type="button" class="home_about__content_button js-home_about_show_more">
                    <span>Mehr anzeigen</span>
                    <span>Ausblenden</span>
                </button>
            </div>
        </div>
    </section><!-- .home_about -->

    <section class="section home_accordion">
        <div class="section_in">
            <?php
            $questions = get_field('question_accordion', 'option');

            if (count($questions) > 0) { ?>
                <div class="home_accordion__wrap">

                    <ul class="home_accordion__list js-home_accordion">
                        <?php foreach ($questions as $question) { ?>
                            <li class="home_accordion__item acc_item">
                                <button class="acc_header" type="button">
                                    <h3><?php echo $question['question']; ?></h3>
                                </button>
                                <div class="acc_content">
                                    <div class="acc_content_wrapper"><?php echo $question['answer']; ?></div>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
            <?php } ?>
        </div>
    </section><!-- .home_accordion -->

<?php } ?>

    </main>
</div>

<?php

get_footer();
