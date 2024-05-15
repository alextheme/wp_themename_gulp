<?php

if ( !class_exists('Yaba')) {
    class Yaba {

        /**
         * Перейменувати ключі масиву з "attribute_pa_color" га "pa_color"
         */
        public static function replace_array_keys($src_array, $prefix = 'attribute_') {
            $new_array = array_map(function($key) use ($prefix, $src_array) {
                $new_key = str_replace($prefix, '', $key);
                return [$new_key => $src_array[$key]];
            }, array_keys($src_array));

            return call_user_func_array('array_merge', $new_array);
        }

        public static function compare_arrays($default_attr, $variation_attributes): int {
            $counts = count($default_attr) === count($variation_attributes);
            $difference = count( array_diff_assoc($default_attr, $variation_attributes ) ) === 0;
            return $counts && $difference;
        }

        public static function products_title() {
            if (is_shop()) {
                if ( array_key_exists('orderby', $_GET) && $_GET['orderby'] === 'date' ) {
                    return 'Neue Produkte';
                }

                if ( array_key_exists('filterby', $_GET) && $_GET['filterby'] === 'featured' ) {
                    return 'Hot Deals';
                }
            }

            return false;
        }
    }
}
