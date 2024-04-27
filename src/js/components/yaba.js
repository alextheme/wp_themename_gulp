import * as select2 from "select2";
import { onWindowResize } from "../utils/index.js";
import * as slick from "slick-slider";
import * as zoom from "jquery-zoom";
const $ = jQuery

const yaba = () => {
    // $('.product_item__quantity').on( 'click', '.plus, .minus', function() {
    //     var qty = $( this ).closest( '.product_item__quantity' ).find( '.qty' );
    //     var addToCartBtn = $( this ).closest( '.product' ).find( '.button.add_to_cart_button' );
    //     var val   = parseFloat(qty.val());
    //     var max = parseFloat(qty.attr( 'max' ));
    //     var min = parseFloat(qty.attr( 'min' ));
    //     var step = parseFloat(qty.attr( 'step' ));
    //
    //     if ( $( this ).is( '.plus' ) ) {
    //         if ( max && ( max <= val ) ) {
    //             qty.val( max );
    //         } else {
    //             qty.val( val + step );
    //         }
    //     } else {
    //         if ( min && ( min >= val ) ) {
    //             qty.val( min );
    //         } else if ( val > 1 ) {
    //             qty.val( val - step );
    //         }
    //     }
    //
    //     console.log(addToCartBtn)
    //var addToCartBtn = $( this ).closest( '.product' ).find( '.button.add_to_cart_button' );
    //     addToCartBtn.attr('data-quantity', qty.val() )
    // });

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
    $('.wp-block-heading').on( 'click', function () {
        $(this).toggleClass('wp-block-heading--open_drop_down')
    })

    // Open Search Mobile
    $('.header__search_mob').on('click', function () {
        $('.header__search_form_wrap').toggleClass('header__search_form_wrap--open')
    })

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

    $('.js-slick-products .featured_products_mobile ul.products').slick({
        slidesToShow: 2,
        slidesToScroll: 2,
        arrows: false,
        infinite: true,
        swipe: true,
        dots: true,
    })

    $('.js-hero_slider').slick({
        slidesToShow: 2,
        slidesToScroll: 2,
        arrows: false,
        infinite: true,
        swipe: true,
        dots: true,

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

    $('.js-slick-hot_products ul.products').slick({
        slidesToShow: 6,
        slidesToScroll: 2,
        arrows: false,
        infinite: true,
        swipe: true,
        dots: true,

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




    const productVariationsEvents = () => {
        const setColHeight = () => {
            if (window.innerWidth <= 1024) return

            $('.product .woocommerce-product-gallery')
                .css( { height: $('.product .summary').outerHeight() } )

            $('.product .woocommerce-product-gallery a')
                .css( { height: $('.product .summary').outerHeight() } )
        }
        onWindowResize(() => { setTimeout(() => setColHeight(), 200) })

        if (typeof variationData !== 'undefined') {

            if (variationData.default_variation_id > 0) {
                console.log(1)
                $('.product .summary > .price').replaceWith(variationData['price_html'])
            } else {
                console.log(2)
                $('.product .summary > .price').replaceWith(variationData['price_base_html'])
            }

        } else {
            console.log(3)
            // $('.product .summary > .price').css({ opacity: 1 })
        }

        $('.reset_variations').on('click', () => {
            $('.variations_form__var_item').removeClass('variations_form__var_item--active')

            const priceHtml = typeof variationData !== 'undefined' ? variationData['price_base_html'] : ''
            if (priceHtml) {
                $('.product .summary > .price').replaceWith( priceHtml )
            }
        })

        $('.variations_form__var_list .variations_form__var_item').on('click', 'button', function (e) {
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

            $('.product .summary > .price').replaceWith(jsonData['price_html'])

            //imageZoom(jsonData['image'])
        })
    }
    productVariationsEvents()

    window.imageZoomInstans = null

    const imageZoom = img => {
        const image = $('.woocommerce-product-gallery__image')
        const imgIns = image.find('img')
        const src = imgIns.length ? imgIns.attr('src') : undefined
        imgIns.on('click', e => e.preventDefault())
        console.log('111')
        if (!src) return

        const url = img || ( typeof variationData !== 'undefined'
            ? variationData['image'] : imgIns.attr('src') )

        console.log('222')
        const iimg = $(imageZoomInstans).find('img.zoomImg')
        // if (iimg.length) {
        //     iimg.attr('src', url)
        // } else {
        //     imageZoomInstans = image
        //         // .wrap('<span class="zoomImgWrapper" style="display:block"></span>')
        //         // .css('display', 'block')// for img
        //         // .parent()
        //         // .on('click', e => e.preventDefault())
        //         .zoom({
        //             url : url,
        //             duration: 300,
        //             /*on: 'mouseover', //mouseover, grab, click, toggle */ })
        // }

    }
    // imageZoom()

    // Events
    const checkWoocommerceEvents = () => {
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
    }
    checkWoocommerceEvents()


    const resize = () => {

    }
    onWindowResize(resize)
}

export default yaba;