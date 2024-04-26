import { onWindowResize } from "../utils/index.js";
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
        // Додаємо падінг між елементами на основі попередньої між ними відстані
        // щоб ціна не скакала вгору
        $('ul.products li.product')
            .each((_, product) => {
                const topEl = $(product).find('> .woocommerce-loop-product__link')[0]
                $(topEl).css({ paddingBottom: 0 })
            })
            .each((_, product) => {
                const topEl = $(product).find('> .woocommerce-loop-product__link')[0]
                const bottomEl = $(product).find('.price')[0]
                $(topEl).css({ paddingBottom: distanceBetweenElements(topEl, bottomEl) + 'px' })
            })
    }

    const productsLists = document.querySelectorAll('ul.products')
    const products = document.querySelectorAll('ul.products li.product')

    productsLists.forEach(productsList => {
        productsList.addEventListener('mouseenter', beforeHoverHandler)
        productsList.addEventListener('mouseleave', beforeHoverHandler)
    })

    products.forEach(product => {
        const productFooter = product.querySelector('.product_item__footer')
        const productFooterHeight = productFooter.getBoundingClientRect().height
        productFooter.setAttribute('data-height', productFooterHeight)
    })

    function setHeight() {
        products.forEach(product => {
            product.querySelector('.product_item__footer').style.height = (window.innerWidth <= 1024) ? 'auto' : 0
        })
    }
    setHeight()

    function beforeHoverHandler(event) {
        if (window.innerWidth <= 1024) return

        const list = event.target

        if (event.type == 'mouseenter') {

            const listRect = list.getBoundingClientRect()
            list.style.width = listRect.width + 'px'
            list.style.height = listRect.height + 'px'

            const itemPositions = []

            for (const item of list.children) {
                itemPositions.push({
                    top: item.offsetTop,
                    left: item.offsetLeft
                })
            }

            let i = 0
            for (const item of list.children) {
                const rect = itemPositions[i]
                item.style.top = rect.top + 'px'
                item.style.left = rect.left + 'px'
                item.classList.add('product__jsPositionAbsolute')
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
                item.style.top = 'unset'
                item.style.left = 'unset'
                item.classList.remove('product__jsPositionAbsolute')
            }
            list.style.width = '100%'
            list.style.height = '100%'
        })
    }

    const hoverHandler = (event) => {
        if (window.innerWidth <= 1024) return

        const product = event.target
        const productFooter = product.querySelector('.product_item__footer')

        if (event.type === 'mouseenter') {
            product.style.zIndex = 3
            productFooter.style.height = productFooter.getAttribute('data-height') + 'px'
        }

        if (event.type === 'mouseleave') {
            productFooter.style.height = 0
            product.style.zIndex = 0
        }
    }


    const resize = () => {
        setPaddingToBetweenElements()
        productsListResize()
        setHeight()
    }
    onWindowResize(resize)

}

export default yabaHover