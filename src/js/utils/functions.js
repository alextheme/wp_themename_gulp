export const css = (element, style) => {
    for (const property in style)
        element.style[property] = style[property];

    // variant 1
    // note.style.cssText += 'color:red;background-color:yellow';

    // variant 2 use this function
    // css(document.querySelector('.note'), {
    //     'background-color': 'yellow',
    //     color: 'red'
    // });
}

export const removeClassStartsWith = (node, className) => {
    [...node.classList].forEach(v => {
        if (v.startsWith(className)) {
            node.classList.remove(v)
        }
    })
}

export const setCookie = (key, value) => {
    document.cookie = "" + key + "=" + value + "; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
}

export const getCookies = key => {
    return document.cookie
        .split("; ")
        .find(row => row.startsWith("" + key + "="))
        ?.split("=")[1];
}

// Отримати реальні значення прописані в стилях (наприклад в %) а не в вираховані в пікселях
function getComputedCSSValue(ele, prop) {
    var resolvedVal = window.getComputedStyle(ele)[prop];
    //does this return a pixel based value?
    if (/px/.test(resolvedVal)) {
        var origDisplay = ele.style.display;
        ele.style.display = 'none';
        var computedVal = window.getComputedStyle(ele)[prop];
        //restore original display
        ele.style.display = origDisplay;
        return computedVal;
    } else {
        return resolvedVal;
    }
}