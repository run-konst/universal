<?php
add_action( 'init', 'register_post_types' );
function register_post_types(){
	register_post_type( 'lesson', [
		'label'  => null,
		'labels' => [
			'name'               => __( 'Lessons', 'universaltheme' ), // основное название для типа записи
			'singular_name'      => __( 'Lesson', 'universaltheme' ), // название для одной записи этого типа
			'add_new'            => __( 'Add lesson', 'universaltheme' ), // для добавления новой записи
			'add_new_item'       => __( 'Adding a lesson', 'universaltheme' ), // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => __( 'Edit lesson', 'universaltheme' ), // для редактирования типа записи
			'new_item'           => __( 'New lesson', 'universaltheme' ), // текст новой записи
			'view_item'          => __( 'View lesson', 'universaltheme' ), // для просмотра записи этого типа.
			'search_items'       => __( 'Search lessons', 'universaltheme' ), // для поиска по этим типам записи
			'not_found'          => __( 'Not found', 'universaltheme' ), // если в результате поиска ничего не было найдено
			'not_found_in_trash' => __( 'Not found in trash', 'universaltheme' ), // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => __( 'Lessons', 'universaltheme' ), // название меню
		],
		'description'         => __( 'Section with video lessons', 'universaltheme' ),
		'public'              => true,
		// 'publicly_queryable'  => null, // зависит от public
		// 'exclude_from_search' => null, // зависит от public
		// 'show_ui'             => null, // зависит от public
		// 'show_in_nav_menus'   => null, // зависит от public
		'show_in_menu'        => true, // показывать ли в меню адмнки
		// 'show_in_admin_bar'   => null, // зависит от show_in_menu
		'show_in_rest'        => true, // добавить в REST API. C WP 4.7
		'rest_base'           => null, // $post_type. C WP 4.7
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'capability_type'   => 'post',
		//'capabilities'      => 'post', // массив дополнительных прав для этого типа записи
		//'map_meta_cap'      => null, // Ставим true чтобы включить дефолтный обработчик специальных прав
		'hierarchical'        => false,
		'supports'            => [ 'title', 'editor', 'thumbnail','excerpt', 'custom-fields', 'comments'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [],
		'has_archive'         => true,
		'rewrite'             => true,
		'query_var'           => true,
	] );
}

// хук, через который подключается функция
// регистрирующая новые таксономии (create_lesson_taxonomies)
add_action( 'init', 'create_lesson_taxonomies' );

// функция, создающая 2 новые таксономии "genres" и "writers" для постов типа "lesson"
function create_lesson_taxonomies(){

	// Добавляем древовидную таксономию 'genre' (как категории)
	register_taxonomy('genre', array('lesson'), array(
		'hierarchical'  => true,
		'labels'        => array(
			'name'              => __( 'Genres', 'universaltheme' ),
			'singular_name'     => __( 'Genre', 'universaltheme' ),
			'search_items'      =>  __( 'Search Genres', 'universaltheme' ),
			'all_items'         => __( 'All Genres', 'universaltheme' ),
			'parent_item'       => __( 'Parent Genre', 'universaltheme' ),
			'parent_item_colon' => __( 'Parent Genre:', 'universaltheme' ),
			'edit_item'         => __( 'Edit Genre', 'universaltheme' ),
			'update_item'       => __( 'Update Genre', 'universaltheme' ),
			'add_new_item'      => __( 'Add New Genre', 'universaltheme' ),
			'new_item_name'     => __( 'New Genre Name', 'universaltheme' ),
			'menu_name'         => __( 'Genres', 'universaltheme' ),
		),
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'the_genre' ), // свой слаг в URL
	));

	// Добавляем НЕ древовидную таксономию 'teacher' (как метки)
	register_taxonomy('teacher', 'lesson',array(
		'hierarchical'  => false,
		'labels'        => array(
			'name'                        => __( 'Teachers', 'universaltheme' ),
			'singular_name'               => __( 'Teacher', 'universaltheme' ),
			'search_items'                =>  __( 'Search Teachers', 'universaltheme' ),
			'popular_items'               => __( 'Popular Teachers', 'universaltheme' ),
			'all_items'                   => __( 'All Teachers', 'universaltheme' ),
			'parent_item'                 => null,
			'parent_item_colon'           => null,
			'edit_item'                   => __( 'Edit Teacher', 'universaltheme' ),
			'update_item'                 => __( 'Update Teacher', 'universaltheme' ),
			'add_new_item'                => __( 'Add New Teacher', 'universaltheme' ),
			'new_item_name'               => __( 'New Teacher Name', 'universaltheme' ),
			'separate_items_with_commas'  => __( 'Separate teachers with commas', 'universaltheme' ),
			'add_or_remove_items'         => __( 'Add or remove teachers', 'universaltheme' ),
			'choose_from_most_used'       => __( 'Choose from the most used teachers', 'universaltheme' ),
			'menu_name'                   => __( 'Teachers', 'universaltheme' ),
		),
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'the_teacher' ), // свой слаг в URL
	));
}