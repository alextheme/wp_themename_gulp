import svg4everybody from "svg4everybody";

import {GLOBAL_VARS} from './utils/constants.js';
import {jqDocumentReady} from './utils/index.js';
import header from './components/header.js';
import yaba from './components/yaba.js';

jqDocumentReady(() => {
    header();
    yaba();
})
