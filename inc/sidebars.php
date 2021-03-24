<?php

// Регистрируем сайдбары

function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Основной сайдбар', 'universaltheme' ),
			'id'            => 'sidebar-grid',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universaltheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Недавние статьи', 'universaltheme' ),
			'id'            => 'sidebar-articles',
			'description'   => esc_html__( 'Добавьте виджеты сюда.', 'universaltheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Меню в подвале', 'universaltheme' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'Добавьте меню сюда.', 'universaltheme' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title' => '<h2 class="footer-menu__title %2$s">',
			'after_title'  => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Текст в подвале', 'universaltheme' ),
			'id'            => 'footer-text',
			'description'   => esc_html__( 'Добавьте текст сюда.', 'universaltheme' ),
			'before_widget' => '<div id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Статьи на странице поста', 'universaltheme' ),
			'id'            => 'post-posts',
			'description'   => esc_html__( 'Добавьте статьи сюда', 'universaltheme' ),
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );
