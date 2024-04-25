import svg4everybody from "svg4everybody"

import {GLOBAL_VARS} from './utils/constants.js'
import {jqDocumentReady} from './utils/index.js'
import header from './components/header.js'
import yaba from './components/yaba.js'
import yabaAjax from './components/yaba-ajax.js'
import yabaHover from "./components/yaba-hover.js";

jqDocumentReady(() => {
    header()
    yaba()
    yabaAjax()
    yabaHover()
})
