<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header <?php echo get_post_type(); ?>__header" style="
    background-image: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url('<?php the_post_thumbnail_url(); ?>');">
        <div class="container">
            <div class="post__header-top">
                <?php 
                foreach( get_the_category() as $category ) {
                    printf(
                        '<a href="%s" class="cat-link cat-%s">%s</a>',
                        esc_url(get_category_link($category)),
                        esc_html($category -> slug),
                        esc_html($category -> name),
                    ); 
                }
                ?>
                <div class="post__header-nav">
                    <a href="<?php echo get_home_url(); ?>" class="home-link">
                        <svg class="home-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#home"></use>
                        </svg>
                        <span>На главную</span>
                    </a>
                    <?php
                    the_post_navigation(
                        array(
                            'prev_text' => 
                            '<svg class="prev-icon">
                                <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                            </svg><span>' . esc_html__( 'Назад', 'universaltheme' ) . '</span>',
                            'next_text' => '<span>' . esc_html__( 'Вперед', 'universaltheme' ) . '</span>
                            <svg class="next-icon">
                                <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                            </svg>',
                        )
                    );
                    ?>        
                </div>        
            </div>

            <?php
            if ( is_singular() ) :
                the_title( '<h1 class="post__title">', '</h1>' );
            else :
                the_title( '<h2 class="post__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
            ?>
            <p class="post__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 30); ?></p>
            <div class="post-info">
                <svg class="clock-icon">
                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#clock"></use>
                </svg>
                <span class="post-info-item"><?php the_time('j F, G:i'); ?></span>
                <svg class="like-icon">
                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#like"></use>
                </svg>
                <span class="post-info-item"><?php comments_number('0', '1', '%'); ?></span>
                <svg class="comment-icon">
                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                </svg>
                <span class="post-info-item"><?php comments_number('0', '1', '%'); ?></span>
            </div>        
        </div>
	</header>

    <div class="entry-content">
		<?php
		the_content(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'universal-example' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			)
		);

		wp_link_pages(
			array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universal-example' ),
				'after'  => '</div>',
			)
		);
		?>
	</div><!-- .entry-content -->

    <footer class="entry-footer">
        <?php
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'universal-example' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( '%1$s', 'universal-example' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
        ?>
    </footer><!-- .entry-footer -->

</article>