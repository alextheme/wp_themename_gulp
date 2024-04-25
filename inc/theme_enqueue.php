<?php

function _themename_scripts() {
	wp_enqueue_style( '_themename-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_enqueue_style( '_themename-stylesheet', get_template_directory_uri() . '/assets/css/bundle.css', array(), _S_VERSION, 'all' );

    wp_enqueue_style ( 'add_google_font1' , 'https://fonts.googleapis.com/css2?family=Nunito:wght@200..1000&display=swap' , false );
    wp_enqueue_style ( 'add_google_font2' , 'https://fonts.googleapis.com/css2?family=Hammersmith+One&display=swap' , false );

    wp_enqueue_script( '_themename-scripts', get_template_directory_uri() . '/assets/js/bundle.js', array('jquery'), _S_VERSION, true );
    wp_enqueue_script('jquery-form');
}

add_action( 'wp_enqueue_scripts', '_themename_scripts' );
