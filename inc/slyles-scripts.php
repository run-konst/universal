<?php

add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri(), null, time(), null );
	wp_enqueue_style( 'swiper', get_template_directory_uri(  ) . '/assets/css/swiper-bundle.min.css', null, time(), null );
    wp_enqueue_style( 'universal-theme', get_template_directory_uri(  ) . '/assets/css/universal-theme.css', 'style', time(), null );
	wp_enqueue_script( 'swiper', get_template_directory_uri(  ) . '/assets/js/swiper-bundle.min.js', null, time(), true);
	wp_enqueue_script( 'script', get_template_directory_uri(  ) . '/assets/js/script.js', null, time(), true);
}