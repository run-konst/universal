<?php

// правильный способ подключить стили и скрипты
add_action( 'wp_enqueue_scripts', 'enqueue_universal_style' );
function enqueue_universal_style() {
	wp_enqueue_style( 'style', get_stylesheet_uri(), null, time(), null );
	wp_enqueue_style( 'swiper', get_template_directory_uri(  ) . '/assets/css/swiper-bundle.min.css', null, time(), null );
    wp_enqueue_style( 'universal-theme', get_template_directory_uri(  ) . '/assets/css/universal-theme.css', 'style', time(), null );
	wp_enqueue_script( 'swiper', get_template_directory_uri(  ) . '/assets/js/swiper-bundle.min.js', null, time(), true);
	wp_enqueue_script( 'script', get_template_directory_uri(  ) . '/assets/js/script.js', null, time(), true);
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
	add_image_size( 'small-thumb', 336, 195, true ); 
	add_image_size( 'smaller-thumb', 263, 180, true );
	add_image_size( 'medium-thumb', 1140, 600, true );
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
			add_action('wp_enqueue_scripts', array( $this, 'add_downloader_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_downloader_widget_style' ) );
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
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Downloader_Widget

// регистрация Downloader_Widget в WordPress
function register_downloader_widget() {
	register_widget( 'Downloader_Widget' );
}
add_action( 'widgets_init', 'register_downloader_widget' );

// Виджет тегов

add_filter( 'widget_tag_cloud_args', 'edit_widget_tag_cloud_args' );
function edit_widget_tag_cloud_args($args) {
	$args['unit'] = 'px';
	$args['smallest'] = '14';
	$args['largest'] = '14';
	$args['number'] = '12';
	return $args;
};


// Виджет соцсетей

class Social_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'social_widget', 
			'Социальные сети',
			array( 'description' => 'Социальные сети', 
					'classname' => 'social-widget', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_social_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_social_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$facebook = $instance['facebook'];
		$instagram = $instance['instagram'];
		$youtube = $instance['youtube'];
		$twitter = $instance['twitter'];

		echo $args['before_widget'];
		echo  '<h2 class="social-widget__heading">Наши соцсети</h2><ul class="social-widget__list">';
		if ( ! empty( $facebook ) ) { echo '<li class="social-widget__item"><a class="social-widget__link social-facebook" target="_blank" href="' . $facebook . '"></a></li>'; }
		if ( ! empty( $instagram ) ) { echo '<li class="social-widget__item"><a class="social-widget__link social-instagram" target="_blank" href="' . $instagram . '"></a></li>'; }
		if ( ! empty( $youtube ) ) { echo '<li class="social-widget__item"><a class="social-widget__link social-youtube" target="_blank" href="' . $youtube . '"></a></li>'; }
		if ( ! empty( $twitter ) ) { echo '<li class="social-widget__item"><a class="social-widget__link social-twitter" target="_blank" href="' . $twitter . '"></a></li></ul>'; }
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$facebook = @ $instance['facebook'] ?: 'http://';
		$instagram = @ $instance['instagram'] ?: 'http://';
		$youtube  = @ $instance['youtube'] ?: 'http://';
		$twitter   = @ $instance['twitter'] ?: 'http://';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'facebook' ); ?>"><?php _e( 'Ссылка на facebook:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'facebook' ); ?>" name="<?php echo $this->get_field_name( 'facebook' ); ?>" type="text" value="<?php echo esc_attr( $facebook ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'instagram' ); ?>"><?php _e( 'Ссылка на instagram:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'instagram' ); ?>" name="<?php echo $this->get_field_name( 'instagram' ); ?>" type="text" value="<?php echo esc_attr( $instagram ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'youtube' ); ?>"><?php _e( 'Ссылка на youtube:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'youtube' ); ?>" name="<?php echo $this->get_field_name( 'youtube' ); ?>" type="text" value="<?php echo esc_attr( $youtube ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter' ); ?>"><?php _e( 'Ссылка на twitter:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter' ); ?>" name="<?php echo $this->get_field_name( 'twitter' ); ?>" type="text" value="<?php echo esc_attr( $twitter ); ?>">
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
		$instance['facebook'] = ( ! empty( $new_instance['facebook'] ) ) ? strip_tags( $new_instance['facebook'] ) : '';
		$instance['instagram'] = ( ! empty( $new_instance['instagram'] ) ) ? strip_tags( $new_instance['instagram'] ) : '';
		$instance['youtube'] = ( ! empty( $new_instance['youtube'] ) ) ? strip_tags( $new_instance['youtube'] ) : '';
		$instance['twitter'] = ( ! empty( $new_instance['twitter'] ) ) ? strip_tags( $new_instance['twitter'] ) : '';

		return $instance;
	}

	// скрипт виджета
	function add_social_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_social_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Social_Widget

// регистрация Social_Widget в WordPress
function register_social_widget() {
	register_widget( 'Social_Widget' );
}
add_action( 'widgets_init', 'register_social_widget' );


// Виджет недавних статей

class Recent_Posts_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', 
			'Недавние статьи',
			array( 'description' => 'Недавние статьи', 
					'classname' => 'recent-posts-widget', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_recent_posts_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_recent_posts_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$title = $instance['title'];
		$count = $instance['count'];

		//var_dump($instance);

		echo $args['before_widget'];
		if ( ! empty( $title ) ) { echo  '<h2 class="widgettitle">' . $title . '</h2>';
			if ( ! empty( $count ) ) {
				global $post;

                    $myposts = get_posts([ 
                        'numberposts' => $count,
                    ]);
					echo  '<div class="recent-posts-widget__container">';
                    if( $myposts ){
						$i = 1;
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>
							<a class="recent-posts-widget__post" href="<?php the_permalink(); ?>">
								<img src="<?php the_post_thumbnail_url('homepage-thumb'); ?>" alt="<?php the_title(); ?>" class="recent-posts-widget__img">
								<div class="recent-posts-widget__info">
									<h3 class="recent-posts-widget__heading"><?php echo mb_strimwidth(get_the_title(), 0, 30, "..."); ?></h3>
									<span class="recent-posts-widget__date">
									<?php
									$time_diff = human_time_diff( get_post_time('U'), current_time('timestamp') );
									echo "$time_diff назад";
									?>
									</span>
									<span class="recent-posts-widget__count"><?php echo $i ?></span>		
								</div>
							</a>
							
                            <?php
							$i++;
                        }
                    } else {
                        // Постов не найдено
                    }
					echo '</div>';
                    wp_reset_postdata(); // Сбрасываем $post
			}		
		}
		echo $args['after_widget'];
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		$title = @ $instance['title'] ?: 'Недавние статьи';
		$count = @ $instance['count'] ?: '7';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество статей:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
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
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		return $instance;
	}

	// скрипт виджета
	function add_recent_posts_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_recent_posts_widget_style() {
		// фильтр чтобы можно было отключить стили
		if( ! apply_filters( 'show_my_widget_style', true, $this->id_base ) )
			return;
		?>
		<style type="text/css">
			.my_widget a{ display:inline; }
		</style>
		<?php
	}

} 
// конец класса Recent_Posts_Widget

// регистрация Recent_Posts_Widget в WordPress
function register_recent_posts_widget() {
	register_widget( 'Recent_Posts_Widget' );
}
add_action( 'widgets_init', 'register_recent_posts_widget' );
