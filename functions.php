<?php

foreach (glob(get_template_directory() . '/inc/*.php') as $file) {
	require $file;
}

if ( ! function_exists( 'universal_theme_setup' ) ) :
	function universal_theme_setup() {

        // Добавление title
		add_theme_support( 'title-tag' );

        // Добавление миниатюр
		add_theme_support( 'post-thumbnails', array('post') );
        
        // Добавление логотипа
        add_theme_support(
			'custom-logo',
			array(
				'width'       => 163,
				'flex-height' => true,
                'header-text' => 'Universal'
			)
		);

		//Регистрация меню
		register_nav_menus( [
			'header_menu' => 'Меню в шапке',
			'footer_menu' => 'Меню в подвале'
		] );
	}
endif;

add_action( 'after_setup_theme', 'universal_theme_setup' );

// Виджет тегов

add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args' );
function edit_widget_tag_cloud_args($args) {
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '12';
	return $args;
};