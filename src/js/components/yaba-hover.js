import { onWindowResize } from "../utils/index.js";
import {race} from "../../../../../../wp-includes/js/dist/redux-routine.js";
const $ = jQuery

const yabaHover = () => {
    /**
     * Hover ul.products li.product (archive page)
     */
    function distanceBetweenElements(topEl, bottomEl) {
        if (!topEl || !bottomEl) return 0

        const topRect = topEl.getBoundingClientRect();
        const bottomRect = bottomEl.getBoundingClientRect();
        const res = bottomRect.top - topRect.bottom;
        return res;
    }

    function setPaddingToBetweenElements() {
        let hotProductsClass = '.js-slick-hot_products'
        let hotProductMaxHeight = 0

        // Додаємо падінг між елементами на основі попередньої між ними відстані
        // щоб ціна не скакала вгору
        $('ul.products li.product')
            // .each((_, product) => {
            //     const pLink = $(product).find('.product_item__wrapper > .woocommerce-loop-product__link')[0]
            //     $(pLink).css({ paddingBottom: 0 })
            // })
            .each((_, product) => {
                if (product.closest(hotProductsClass)) {
                    hotProductMaxHeight = Math.max(hotProductMaxHeight, product.getBoundingClientRect().height)
                }
            })
            .each((_, product) => {
                const pLink = $(product).find('.product_item__wrapper > .woocommerce-loop-product__link')[0]
                const pPrice = $(product).find('.price')[0]
                let padding = Math.round( distanceBetweenElements(pLink, pPrice) )

                if (padding === 0) {
                    if (product.closest(hotProductsClass)) {
                        padding = hotProductMaxHeight - product.getBoundingClientRect().height
                    }
                }

                $(pLink).css({ paddingBottom: padding + 'px' })
            })
    }

    const productsLists = document.querySelectorAll('ul.products')
    const products = document.querySelectorAll('ul.products li.product')

    productsLists.forEach(productsList => {
        productsList.addEventListener('mouseenter', beforeHoverHandler)
        productsList.addEventListener('mouseleave', beforeHoverHandler)

        // Визначити висоту і записати в атрибут футера з кнопками у карточки продукту
        productsList.querySelectorAll('li.product').forEach(product => {
            const productFooter = product.querySelector('.product_item__footer')
            const productFooterHeight = productFooter.getBoundingClientRect().height
            productFooter.setAttribute('data-height', Math.round(productFooterHeight))
        })

        productsList.querySelectorAll('li.product').forEach(product => {
            product.querySelector('.product_item__footer').style.height = (window.innerWidth <= 1024) ? 'auto' : 0
        })
    })

    function beforeHoverHandler(event) {
        if (window.innerWidth <= 1024) return

        const list = event.target

        if (event.type === 'mouseenter') {

            const listRect = list.getBoundingClientRect()
            list.style.width = listRect.width + 'px'
            list.style.height = listRect.height + 'px'

            const itemPositions = []

            for (const item of list.children) {
                itemPositions.push({
                    top: item.offsetTop,
                    left: item.offsetLeft,
                    width: item.getBoundingClientRect().width,
                })
            }

            let i = 0
            for (const item of list.children) {
                item.classList.add('js-pos-absolute')
                const rect = itemPositions[i]
                item.style.top = rect.top + 'px'
                item.style.left = rect.left + 'px'
                item.style.width = rect.width + 'px'
                i++
            }

            ////////////////////////////////////////////////
            products.forEach(product => {
                product.addEventListener('mouseenter', hoverHandler)
                product.addEventListener('mouseleave', hoverHandler)
            })
        }
    }

    const productsListResize = () => {

        productsLists.forEach(list => {
            for (const item of list.children) {
                item.classList.remove('js-pos-absolute')
                item.style = '' // remove inline css styles set via JS
            }
            list.style.width = 'auto'
            list.style.height = '100%'
        })
    }

    const hoverHandler = (event) => {
        if (window.innerWidth <= 1024) return

        const product = event.target
        const productFooter = product.querySelector('.product_item__footer')

        if (event.type === 'mouseenter') {
            product.style.zIndex = 20
            productFooter.style.height = productFooter.getAttribute('data-height') + 'px'
            product.classList.add('js-product-hover')
        }

        if (event.type === 'mouseleave') {
            productFooter.style.height = 0
            product.style.zIndex = 0
            product.classList.remove('js-product-hover')
        }
    }


    const resize = () => {
        setPaddingToBetweenElements()
        productsListResize()
    }
    onWindowResize(resize)

}

export default yabaHover