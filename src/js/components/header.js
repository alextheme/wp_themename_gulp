import {onWindowResize, onWindowScroll} from '../utils/index.js';
import {css} from "../utils/functions.js";
const $ = jQuery

const header = () => {
    const closeOnClickOutsideElement = (element$, fn = null) => {
        document.addEventListener('click', e => {
            const r = element$.getBoundingClientRect();
            const x = e.clientX;
            const y = e.clientY;

            if (!(x >= r.left && x <= r.right && y >= r.top && y <= r.bottom)) {
                if (fn instanceof Function) {
                    fn();
                }
            }
        });
    }

    // Scroll Menu Events

    let prevScrollPos = 0;

    onWindowScroll(() => {
        const bodyElement = document.body
        const currentScrollPos = document.documentElement.scrollTop || bodyElement.scrollTop

        if (currentScrollPos > 20) {
            bodyElement.classList.add('body--scrolled_down')
        } else {
            bodyElement.classList.remove('body--scrolled_down')
        }

        if (prevScrollPos < currentScrollPos && currentScrollPos > 150) {
            bodyElement.classList.add('body--go_scroll_up')
            bodyElement.classList.remove('body--open_menu_category')
        } else {
            bodyElement.classList.remove('body--go_scroll_up')
        }

        prevScrollPos = currentScrollPos;
    })


    $(document).on('click', '.js-header__link_menu', function (event) {
        event.preventDefault()
        $(document.body).toggleClass('body--open_menu_category')
    })


    // Close elements
    $(document.body).on('click', function (e) {
        const $this = $(e.target)

        // Close Menu Header
        if ( ! ( $this.closest('.js-header__link_menu').length ||
            $this.closest('#header_nav_menu_category').length )
        ) {
            $(document.body).removeClass('body--open_menu_category')
        }
    })


    /** Search Block */
    document.querySelectorAll('.searchTrigger').forEach(button$ => {

        button$.addEventListener('click', () => {
            if (document.body.classList.contains('body--open_search_field')) {
                document.body.classList.remove('body--open_search_field');
            } else {
                document.body.classList.add('body--open_search_field');
            }
        });

        // Close on click outside the Search elemtn
        closeOnClickOutsideElement(document.querySelector('.aws-container'), () => {
            document.body.classList.remove('body--open_search_field');
        });
    });

    /** Menu Trigger */
    const bodyState = 'body--open_menu_state';
    const body$ = document.body;
    const elements$ = document.querySelectorAll('.scrollbarOffset');
    const elements = Array.from(elements$).map(el$ => {
        const value = window.getComputedStyle(el$, null).getPropertyValue('padding-right');
        const match = value.match(/\d+(\.\d+)?/);
        const numericValue = match ? parseFloat(match[0]) : null;
        return [el$, numericValue];
    });

    document.querySelectorAll('.menuTrigger').forEach(menuButton$ => {
        menuButton$.addEventListener('click', () => {
            const innerWidth = window.innerWidth;
            const clientWidth = document.documentElement.clientWidth;

            if (body$.classList.contains(bodyState)) {
                body$.classList.remove(bodyState);
                elements.forEach(el => el[0].style.paddingRight = el[1] + 'px' );
            } else {
                body$.classList.add(bodyState);
                const scrollbarWidth = innerWidth - clientWidth;
                elements.forEach(el => el[0].style.paddingRight = el[1] + scrollbarWidth + 'px' );
            }
        });
    });
};

export default header;