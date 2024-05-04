<div class="ic-cart-sidebar-wrapper">
    <div class="ic-cart-sidebar-wrapper_header">
        <p><?php _e( 'Your Cart', 'wordpress' ); ?></p>
        <div class="ic-cart-header-btn-close"><i class="ri-close-line"></i></div>
    </div>
    <div class="ic-cart-sidebar-wrapper_body">
<!--            <div class="widget_shopping_cart_content"></div>-->
        <?php woocommerce_mini_cart( [ 'list_class' => 'my-css-class' ] ); ?>
    </div>
</div>

<footer class="footer">
    <div class="footer_in">
        <div class="footer__row">
            <div class="footer__col">
                <a class="footer__logo" href="<?php echo esc_url(home_url('/')) ?>" aria-label="logo">
                    <?php if ( get_field('logo_color', 'option') ) { ?>
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

            <div class="footer__col">
                <h3 class="footer__col_title">Beliebte Kategorien</h3>

                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_category',
                    'menu_class' => 'footer__list categories',
                    'container' => false,
                ))
                ?>
            </div>

            <div class="footer__col">
                <h3 class="footer__col_title">Officials</h3>
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'footer_menu',
                    'menu_class' => 'footer__list officials',
                    'container' => false,
                ))
                ?>
                <button class="footer__button footer__button--mob">Händler Account anfragen</button>
            </div>

            <div class="footer__col">
                <h3 class="footer__col_title">Dein Kontakt zu uns</h3>
                <a class="footer__link tel" href="tel:+6517489523"><?php the_field('phone', 'option'); ?></a>
                <a class="footer__link mail" href="mailto:examle@gmail.com"><?php the_field('email', 'option'); ?></a>
                <p class="footer__descr"><?php the_field('description', 'option'); ?></p>
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

                <button class="footer__button footer__button--desktop">Händler Account anfragen</button>
            </div>
        </div>

        <div class="footer__row">
            <ul class="footer__pays">
                <?php
                $array_pays_icons = array( 'visa', 'mastercard', 'gpay', 'paypal', 'apay' );
                $array_pays_icons = get_field('pay_services', 'option');

                foreach ($array_pays_icons as $icon) { ?>

                    <li>
                        <span class="pay_service pay_service__<?= $icon ?>" aria-label="pay service <?= $icon ?>">
                            <span class="icon_wrap">
                                <svg class="icon icon--size_mod">
                                    <use xlink:href="<?php echo get_template_directory_uri() . '/assets/images/icons/sprite.svg#' . $icon ?>"></use>
                                </svg>
                            </span>
                        </span>
                    </li>

                <?php } ?>

            </ul>
            <p class="footer__copyright"><?php the_field('copyright', 'option'); ?></p>
        </div>
    </div>

</footer>

<?php wp_footer(); ?>

</body>
</html>
