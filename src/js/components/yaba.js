import * as select2 from "select2";
import { onWindowResize } from "../utils/index.js";
import * as slick from "slick-slider";
import * as zoom from "jquery-zoom";
const $ = jQuery

const yaba = () => {

    // Button Plus / Minus
    $(document).on( 'click', 'button.plus, button.minus', function() {
        var qty = $( this ).parent( '.quantity' ).find( '.qty' );
        var val = parseFloat(qty.val());
        var max = parseFloat(qty.attr( 'max' ));
        var min = parseFloat(qty.attr( 'min' ));
        var step = parseFloat(qty.attr( 'step' ));
        if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max <= val ) ) {
                qty.val( max ).change();
            } else {
                qty.val( val + step ).change();
            }
        } else {
            if ( min && ( min >= val ) ) {
                qty.val( min ).change();
            } else if ( val > 1 ) {
                qty.val( val - step ).change();
            }
        }

        if ($( this ).closest( '.product_item__quantity' ).length) {
            $( this ).closest( '.product' ).find( '.button.add_to_cart_button' )
                .attr('data-quantity', qty.val() )
        }
    });


    $('form.woocommerce-ordering select.orderby').hide().select2()

    // Open Filters
    $(document).on( 'click', '.wp-block-heading', function () {
        $(this).toggleClass('wp-block-heading--open_drop_down')
    })

    // Open Search Mobile
    $(document).on('click', '.header__search_mob', function () {
        $('.header__search_form_wrap').toggleClass('header__search_form_wrap--open')
    })

    // Close elements
    $(document.body).on('click', function (e) {
        const $this = $(e.target)

        // Close Filters
        $('.wp-block-heading').each((_, elem) => {
            if ($(elem).parent()[0] !== $this.closest('.wc-blocks-filter-wrapper')[0]) {
                $(elem).removeClass('wp-block-heading--open_drop_down')
            }
        })

        // Close Search Mobile
        if ( ! ( $this.closest('.header__search_form_wrap').length ||
                 $this.closest('.header__search_mob').length )
        ) {
            $('.header__search_form_wrap').removeClass('header__search_form_wrap--open')
        }
    })

    // Sliders
    ;(() => {
        const sliderAutoplay = true

        onWindowResize(() => {
            if (window.innerWidth > 768) {
                $('.js-hero_slider li a img').each( (_, item) => {
                    if (item.src !== item.dataset.url_desctop) {
                        item.src = item.dataset.url_desctop
                    }
                })
            }
        })

        $('.js-hero_slider').slick({
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
            infinite: true,
            swipe: true,
            dots: true,
            autoplay: sliderAutoplay,
            autoplaySpeed: 2100,

            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                    }
                }
            ]
        })

        $('.js-hero_brands_slider').slick({
            slidesToShow: 5,
            slidesToScroll: 2,
            arrows: false,
            infinite: true,
            variableWidth: true,
            swipe: true,
            dots: false,
            autoplay: sliderAutoplay,
            autoplaySpeed: 1800,
        })

        $('.js-slick-home_products ul.products').slick({
            slidesToShow: 6,
            slidesToScroll: 3,
            arrows: true,
            infinite: true,
            swipe: true,
            dots: true,
            autoplay: sliderAutoplay,
            autoplaySpeed: 5000,

            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                }
            ]
        })

        $('.js-slick-products .featured_products_mobile ul.products').slick({
            slidesToShow: 2,
            slidesToScroll: 2,
            arrows: false,
            infinite: true,
            swipe: true,
            dots: true,
            autoplay: sliderAutoplay,
            autoplaySpeed: 1800,
        })
    })()

    // Home About Show Content
    ;(() => {
        const button = $('.js-home_about_show_more')
        const content = button.parent().find('.home_about__content_text')

        button.data('content_height', content.height())
        content.height('auto')
        button.data('content_full_height', content.height())
        content.height(button.data('content_height'))

        button.on('click', function() {
            const item = $(this).parent()
            if (item.hasClass('home_about__content--show')) {
                item.removeClass('home_about__content--show')
                item.find('.home_about__content_text').height($(this).data('content_height'))
            } else {
                item.addClass('home_about__content--show')
                item.find('.home_about__content_text').height($(this).data('content_full_height'))
            }
        })
    })()

    // Home Accordion questions-answers
    ;(() => {
        const items = $('.js-home_accordion').find('.acc_item')

        items.each(function() {
            const button = $(this).find('.acc_header')
            const content = $(this).find('.acc_content')
            button.data( 'content_height', $(content).height() )
            content.height(0)

            button.on('click', function () {
                const item = $(this).parent()

                if (item.hasClass('home_accordion__item--open')) {
                    item.removeClass('home_accordion__item--open')
                    item.find('.acc_content').height(0)
                } else {
                    items.removeClass('home_accordion__item--open')
                    items.find('.acc_content').height(0)

                    item.addClass('home_accordion__item--open')
                    item.find('.acc_content').height($(this).data('content_height'))
                }
            })
        })
    })()

    // Product Variations Events
    ;(() => {
        const priceSelector = '.product .summary .product_single_price_wrapper > .price'

        // Set Price Html for Default Variation
        if (typeof yabaVariationData !== 'undefined') {
            if (yabaVariationData['default_variation_id'] > 0) {
                $( priceSelector ).replaceWith(yabaVariationData['default_variation_price_html'])
            } else {
                $( priceSelector ).replaceWith(yabaVariationData['price_base_html'])
            }
        }

        // Reset Variations
        $('.reset_variations').on('click', () => {
            $('.variations_form__var_item').removeClass('variations_form__var_item--active')

            const priceHtml = typeof yabaVariationData !== 'undefined' ? yabaVariationData['price_base_html'] : ''
            if (priceHtml) {
                $( priceSelector ).replaceWith( priceHtml )
            }
        })

        $('.js-variation_item').on('click', 'button', function (e) {
            e.preventDefault()

            $('.variations_form__var_item--active').removeClass('variations_form__var_item--active')
            $(this).parent().addClass('variations_form__var_item--active')

            const jsonData = $(this).data('json_data')

            const attributes = Object.keys( jsonData['attributes'] )
                .filter(value => /^attribute_/.test( value ))
                .map(attrKey => ({
                    key: attrKey.replace('attribute_', ''),
                    value: jsonData['attributes'][attrKey]
                }))

            $('select#' + attributes[0].key).val(attributes[0].value).trigger('change')
            $('select#' + attributes[1].key).val(attributes[1].value).trigger('change')

            $( priceSelector ).replaceWith(jsonData['price_html'])

            imageZoomFunc()
        })

    })()

    // Image Zoom
    $('.woocommerce-product-gallery__image a').on('click', e => e.preventDefault())
    const imageZoomFunc = () => {
        if (window.imageZoomInstans) {
            window.imageZoomInstans = null
            $('.zoomImg').remove()

            createImageZoomInstans()
        } else {
            setTimeout(() => {
                createImageZoomInstans()
            }, 300)
        }
    }
    imageZoomFunc()
    const createImageZoomInstans = () => {
        const url = $('.woocommerce-product-gallery__image img').attr( 'data-large_image' )
        window.imageZoomInstans = $('.woocommerce-product-gallery__image').zoom({
            url : url,
            duration: 300,
            on: 'mouseover', //mouseover, grab, click, toggle
        })
    }

    // Woocommerce Events :TODO temp JS - Detect Woocommerce Events
    ;(() => {
        jQuery(document.body).on(
            "init_checkout " +
            "payment_method_selected " +
            "update_checkout " +
            "updated_checkout " +
            "checkout_error " +
            "applied_coupon_in_checkout " +
            "removed_coupon_in_checkout " +
            "adding_to_cart " +
            "added_to_cart " +
            "removed_from_cart " +
            "wc_cart_button_updated " +
            "cart_page_refreshed " +
            "cart_totals_refreshed " +
            "wc_fragments_loaded " +
            "init_add_payment_method " +
            "wc_cart_emptied " +
            "updated_wc_div " +
            "updated_cart_totals " +
            "country_to_state_changed " +
            "updated_shipping_method " +
            "applied_coupon " +
            "removed_coupon " +

            "wc_fragments_refreshed " +
            "wc_fragments_ajax_error " +
            "wc_fragment_refresh " +
            "wc_fragments_loaded ",
            (e, params) => console.log(e.type)
        )
        $( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).on( 'init', (e, params) => console.log(e.type));

    })()
}

export default yaba;