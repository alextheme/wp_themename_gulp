<?php

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', '1.0.0' );
}

require_once get_template_directory() . '/inc/theme_functions.php';

require_once get_template_directory() . '/inc/theme_enqueue.php';

require_once get_template_directory() . '/inc/theme_setup.php';

require_once get_template_directory() . '/inc/woocommerce_hook.php';
