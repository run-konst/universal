<?php
add_action( 'init', 'register_post_types' );
function register_post_types(){
	register_post_type( 'lesson', [
		'label'  => null,
		'labels' => [
			'name'               => 'Уроки', // основное название для типа записи
			'singular_name'      => 'Урок', // название для одной записи этого типа
			'add_new'            => 'Добавить урок', // для добавления новой записи
			'add_new_item'       => 'Добавление урока', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Редактирование урока', // для редактирования типа записи
			'new_item'           => 'Новый урок', // текст новой записи
			'view_item'          => 'Смотреть урок', // для просмотра записи этого типа.
			'search_items'       => 'Искать уроки', // для поиска по этим типам записи
			'not_found'          => 'Не найдено', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'Не найдено в корзине', // если не было найдено в корзине
			'parent_item_colon'  => '', // для родителей (у древовидных типов)
			'menu_name'          => 'Уроки', // название меню
		],
		'description'         => 'Раздел с видеоуроками',
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
		'supports'            => [ 'title', 'editor', 'thumbnail','excerpt', 'custom-fields'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
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
			'name'              => _x( 'Genres', 'taxonomy general name' ),
			'singular_name'     => _x( 'Genre', 'taxonomy singular name' ),
			'search_items'      =>  __( 'Search Genres' ),
			'all_items'         => __( 'All Genres' ),
			'parent_item'       => __( 'Parent Genre' ),
			'parent_item_colon' => __( 'Parent Genre:' ),
			'edit_item'         => __( 'Edit Genre' ),
			'update_item'       => __( 'Update Genre' ),
			'add_new_item'      => __( 'Add New Genre' ),
			'new_item_name'     => __( 'New Genre Name' ),
			'menu_name'         => __( 'Genre' ),
		),
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'the_genre' ), // свой слаг в URL
	));

	// Добавляем НЕ древовидную таксономию 'teacher' (как метки)
	register_taxonomy('teacher', 'lesson',array(
		'hierarchical'  => false,
		'labels'        => array(
			'name'                        => _x( 'Teachers', 'taxonomy general name' ),
			'singular_name'               => _x( 'Teacher', 'taxonomy singular name' ),
			'search_items'                =>  __( 'Search Teachers' ),
			'popular_items'               => __( 'Popular Teachers' ),
			'all_items'                   => __( 'All Teachers' ),
			'parent_item'                 => null,
			'parent_item_colon'           => null,
			'edit_item'                   => __( 'Edit Teacher' ),
			'update_item'                 => __( 'Update Teacher' ),
			'add_new_item'                => __( 'Add New Teacher' ),
			'new_item_name'               => __( 'New Teacher Name' ),
			'separate_items_with_commas'  => __( 'Separate teachers with commas' ),
			'add_or_remove_items'         => __( 'Add or remove teachers' ),
			'choose_from_most_used'       => __( 'Choose from the most used teachers' ),
			'menu_name'                   => __( 'Teachers' ),
		),
		'show_ui'       => true,
		'query_var'     => true,
		'rewrite'       => array( 'slug' => 'the_teacher' ), // свой слаг в URL
	));
}