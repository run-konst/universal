<?php

class Recent_Posts_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'recent_posts_widget', 
			__( 'Recent posts', 'universaltheme' ),
			array( 'description' => __( 'Recent posts', 'universaltheme' ), 
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
									echo $time_diff . ' ' . __( 'ago', 'universaltheme' );
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
		$title = @ $instance['title'] ?: __( 'Recent posts', 'universaltheme' );
		$count = @ $instance['count'] ?: '7';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'universaltheme' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Number of posts:', 'universaltheme' ); ?></label> 
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
