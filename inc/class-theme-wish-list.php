<?php

class _themename_WishList {

    function __construct() {
        $this->register();
    }

    public function register() {
        add_action( 'wp_ajax_add_wish_list', [ $this, 'add_wish_list' ] );
        add_action( 'wp_ajax_remove_wish_list', [ $this, 'remove_wish_list' ] );
    }

    public function add_wish_list() {

        if ( isset($_POST['shppb_user_id']) && isset($_POST['shppb_product_id']) ) {
            $product_id = intval( $_POST ['shppb_product_id'] );
            $user_id = intval( $_POST['shppb_user_id'] );

            if( $product_id > 0 && $user_id > 0 ) {
                if ( add_user_meta( $user_id, 'shppb_wishlist_product', $product_id ) ) {
                    echo 'Success! Product added to wish list';
                } else {
                    echo 'Failed';
                }
            }
        }

        wp_die();
    }

    public function remove_wish_list() {

        if ( isset($_POST['shppb_user_id']) && isset($_POST['shppb_product_id']) ) {
            $product_id = intval( $_POST ['shppb_product_id'] );
            $user_id = intval( $_POST['shppb_user_id'] );

            if( $product_id > 0 && $user_id > 0 ) {
                if ( delete_user_meta( $user_id, 'shppb_wishlist_product', $product_id ) ) {
                    echo 3; // Success!!
                } else {
                    echo 2; // Failed
                }
            } else {
                echo 1; // Bad
            }
        } else {
            echo 1; // Bad
        }

        wp_die();
    }

    public function in_wish_list( $user_id, $product_id ) {
        global $wpdb;
        $result = $wpdb->get_results("SELECT * FROM $wpdb->usermeta WHERE meta_key='shppb_wishlist_product' AND meta_value=" . $product_id . " AND user_id=" . $user_id );
        if (isset($result[0]->meta_value) && $result[0]->meta_value == $product_id) {
            return true;
        } else {
            return false;
        }
    }

}

$_themename_wishList = new _themename_WishList();