import * as select2 from "select2";
const $ = jQuery

const yaba = () => {
    $('.product_item__quantity').on( 'click', '.plus, .minus', function() {
        var qty = $( this ).closest( '.product_item__quantity' ).find( '.qty' );
        var addToCartBtn = $( this ).closest( '.product' ).find( '.button.add_to_cart_button' );
        var val   = parseFloat(qty.val());
        var max = parseFloat(qty.attr( 'max' ));
        var min = parseFloat(qty.attr( 'min' ));
        var step = parseFloat(qty.attr( 'step' ));

        if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max <= val ) ) {
                qty.val( max );
            } else {
                qty.val( val + step );
            }
        } else {
            if ( min && ( min >= val ) ) {
                qty.val( min );
            } else if ( val > 1 ) {
                qty.val( val - step );
            }
        }

        console.log(addToCartBtn)

        addToCartBtn.attr('data-quantity', qty.val() )
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

    //
    function distanceBetweenElements(topEl, bottomEl) {
        const topRect = topEl.getBoundingClientRect();
        const bottomRect = bottomEl.getBoundingClientRect();

        const res = bottomRect.top - topRect.bottom;

        return res;
    }

    // Hover ul.products li.product (archive page)
    let shadowElement = null
    let hoverElement = null
    $('ul.products li.product').hover(
        function () {
            // При ховері додаємо падінг між елементами на основі попередньої між ними відстані
            // щоб ціна не скакала вгору
            const topEl = $(this).find('> .woocommerce-loop-product__link')[0]
            const bottomEl = $(this).find('.add_to_cart_wrap')[0]
            $(topEl).css({ 'padding-bottom': distanceBetweenElements(topEl, bottomEl) + 'px' })

            const { top, left } = $(this).position()
            shadowElement = $(this).clone().css({ opacity: 0, userSelect: 'none', pointerEvents: 'none' })
            $(this).before(shadowElement)
            $(this).addClass('product__m_hover')
            $(this).css({ top, left })
            const productFooter = $(this).find('.product_item__footer')
            productFooter.css({ height: 'auto' })
            const productFooterHeight = productFooter.height()
            productFooter.css({ height: 0 })

            console.log(productFooterHeight)

        },

        function () {
            $(this).removeClass('product__m_hover')
            $(this).find('.product_item__footer').css({ height: 0 })
            const topEl = $(this).find('> .woocommerce-loop-product__link')[0]
            $(topEl).css({
                'padding-bottom': 0
            })
            shadowElement.remove()
            shadowElement = null
        })




}

export default yaba;