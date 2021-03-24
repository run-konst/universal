<?php

class Post_Posts_Widget extends WP_Widget {

	// Регистрация виджета используя основной класс
	function __construct() {
		// вызов конструктора выглядит так:
		// __construct( $id_base, $name, $widget_options = array(), $control_options = array() )
		parent::__construct(
			'post_posts_widget', 
			'Статьи на странице поста',
			array( 'description' => 'Статьи на странице поста', 
					'classname' => 'post-posts-widget', )
		);

		// скрипты/стили виджета, только если он активен
		if ( is_active_widget( false, false, $this->id_base ) || is_customize_preview() ) {
			add_action('wp_enqueue_scripts', array( $this, 'add_post_posts_widget_scripts' ));
			add_action('wp_head', array( $this, 'add_post_posts_widget_style' ) );
		}
	}

	/**
	 * Вывод виджета во Фронт-энде
	 *
	 * @param array $args     аргументы виджета.
	 * @param array $instance сохраненные данные из настроек
	 */
	function widget( $args, $instance ) {
		$count = $instance['count'];
        ?>
		
<aside class="post-sidebar">
    <div class="post-sidebar__container container">
        <?php
            global $post;
            $category = get_the_category();
            $cat = $category[0] -> slug;
            $currentPost = $post -> ID;

            $myposts = get_posts([ 
                'numberposts' => $count,
                'category_name' => $cat,
                'exclude' => $currentPost
            ]);

            if( $myposts ){
                foreach( $myposts as $post ){
                    setup_postdata( $post );
                    ?>

                    <a href="<?php the_permalink(); ?>" class="post-sidebar__item">
                        <img class="post-sidebar__img" src="<?php the_post_thumbnail_url('smaller-thumb'); ?>" alt="<?php the_title(); ?>">
                        <h2 class="post-sidebar__heading"><?php echo wp_trim_words( get_the_title(), 10); ?></h2>
                        <div class="post-sidebar__info">
                            <svg>
                                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#views"></use>
                            </svg>
                            <span>1,904</span>
                            <svg>
                                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                            </svg>
                            <span><?php comments_number('0', '1', '%'); ?></span>   
                        </div>
                    </a>
                    
                    <?php 
                }
            } else {
                // Постов не найдено
            }

            wp_reset_postdata(); // Сбрасываем $post
        ?>
    </div>
</aside>

<?php
	}

	/**
	 * Админ-часть виджета
	 *
	 * @param array $instance сохраненные данные из настроек
	 */
	function form( $instance ) {
		
		$count = @ $instance['count'] ?: '4';
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'count' ); ?>"><?php _e( 'Количество статей:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" type="text" value="<?php echo esc_attr( $count ); ?>">
		</p>
		<?php
        /*
		$title = @ $instance['title'] ?: 'Недавние статьи';

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
        */
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
		/*$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';*/
		$instance['count'] = ( ! empty( $new_instance['count'] ) ) ? strip_tags( $new_instance['count'] ) : '';
		return $instance;
	}

	// скрипт виджета
	function add_post_posts_widget_scripts() {
		// фильтр чтобы можно было отключить скрипты
		if( ! apply_filters( 'show_my_widget_script', true, $this->id_base ) )
			return;

		$theme_url = get_stylesheet_directory_uri();

		wp_enqueue_script('my_widget_script', $theme_url .'/my_widget_script.js' );
	}

	// стили виджета
	function add_post_posts_widget_style() {
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

// регистрация Post_Posts_Widget в WordPress
function register_post_posts_widget() {
	register_widget( 'Post_Posts_Widget' );
}
add_action( 'widgets_init', 'register_post_posts_widget' );
