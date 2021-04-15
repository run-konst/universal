<?php

// Регистрируем сайдбары

function universal_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Main sidebar', 'universaltheme' ),
			'id'            => 'sidebar-grid',
			'description'   => esc_html__( 'Add widgets here.', 'universaltheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Recent posts', 'universaltheme' ),
			'id'            => 'sidebar-articles',
			'description'   => esc_html__( 'Add widgets here.', 'universaltheme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer menu sidebar', 'universaltheme' ),
			'id'            => 'footer-sidebar',
			'description'   => esc_html__( 'Add menus here.', 'universaltheme' ),
			'before_widget' => '<section id="%1$s" class="footer-menu %2$s">',
			'after_widget'  => '</section>',
			'before_title' => '<h2 class="footer-menu__title %2$s">',
			'after_title'  => '</h2>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Footer text', 'universaltheme' ),
			'id'            => 'footer-text',
			'description'   => esc_html__( 'Add text here.', 'universaltheme' ),
			'before_widget' => '<div id="%1$s" class="footer-text %2$s">',
			'after_widget'  => '</div>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar on the post page', 'universaltheme' ),
			'id'            => 'post-posts',
			'description'   => esc_html__( 'Add articles here', 'universaltheme' ),
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar on the search page', 'universaltheme' ),
			'id'            => 'search__sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'universaltheme' ),
			'before_widget' => '<div id="%1$s" class="%2$s">',
			'after_widget'  => '</div>',
		)
	);
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );
