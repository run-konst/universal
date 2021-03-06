<?php

// правильный способ подключить стили и скрипты
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri(), null, time(), null );
    wp_enqueue_style( 'universal-theme', get_template_directory_uri(  ) . '/assets/css/universal-theme.css', 'style', time(), null );
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


## отключаем создание миниатюр файлов для указанных размеров

add_filter( 'intermediate_image_sizes', 'delete_intermediate_image_sizes' );
function delete_intermediate_image_sizes( $sizes ){
	// размеры которые нужно удалить
	return array_diff( $sizes, [
		'medium_large',
		'large',
		'1536x1536',
		'2048x2048',
	] );
}

// Добавляем миниатюры

if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'homepage-thumb', 65, 65, true ); 
}

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
}
add_action( 'widgets_init', 'universal_theme_widgets_init' );

// Виджет загрузки файла

class Downloader_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'downloader_widget', 
			'Файл для скачивания',
			array( 'description' => 'Файл для скачивания', 
					'classname' => 'downloader-widget', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_my_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_my_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = wp_trim_words( $instance['title'], 5);
		$description = wp_trim_words( $instance['description'], 5);
		$link = $instance['link'];

		//var_dump($instance);

		echo $args['before_widget'];
		if ( ! empty( $title ) ) { echo  '<h2 class="downloader-widget__heading">' . $title . '</h2>'; }
		if ( ! empty( $description ) ) { echo  '<p class="downloader-widget__text">' . $description . '</p>'; }
		if ( ! empty( $link ) ) { echo  '<a class="downloader-widget__link" download href="' . $link . '"><span class="downloader-widget__link-content">Скачать</span></a>'; }
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Название файла';
		$description = @ $instance['description'] ?: 'Описание файла';
		$link = @ $instance['link'] ?: 'http://';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e( 'Описание:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" type="text" value="<?php echo esc_attr( $description ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'link' ); ?>"><?php _e( 'Ссылка на файл:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" type="text" value="<?php echo esc_attr( $link ); ?>">
		</p>
		<?php 
	}

	/**
	 * Сохранение настроек виджета. Здесь данные должны быть очищены и возвращены для сохранения их в базу данных.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance новые настройки
	 * @param array $old_instance предыдущие настройки
	 *
	 * @return array данные которые будут сохранены
	 */
	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['description'] = ( ! empty( $new_instance['description'] ) ) ? strip_tags( $new_instance['description'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_downloader_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_downloader_widget_style() {
			return;
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );