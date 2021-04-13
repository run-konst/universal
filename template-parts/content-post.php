<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <header class="entry-header <?php echo get_post_type(); ?>__header" style="
    background-image: linear-gradient(0deg, rgba(38, 45, 51, 0.75), rgba(38, 45, 51, 0.75)), url('<?php the_post_thumbnail_url(); ?>');">
        <div class="container post__container">

            <!-- Category and navigation -->
            <div class="post__header-top">
                <?php 
                foreach( get_the_category() as $category ) {
                    printf(
                        '<a href="%s" class="cat-link cat-%s">%s</a>',
                        esc_url(get_category_link($category)),
                        esc_html($category -> slug),
                        esc_html($category -> name)
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

            <!-- Title -->
            <?php
            if ( is_singular() ) :
                the_title( '<h1 class="post__title">', '</h1>' );
            else :
                the_title( '<h2 class="post__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
            ?>

            <!-- Excerpt and info -->
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

            <!-- Author -->
            <div class="post-author">
                <?php $author_id = get_the_author_meta( 'ID' ); ?>
                <div class="post-author__info">
                    <img class="post-author__avatar" src="<?php echo get_avatar_url( $author_id ); ?>" alt="Аватар пользователя">
                    <h3 class="post-author__name"><?php the_author(); ?></h3>
                    <span class="post-author__rank">Разработчик</span>
                    <span class="post-author__post-count"><?php plural_form(count_user_posts($author_id), array('статья', 'статьи', 'статей')); ?></span>
                </div>
                <a href="<?php echo get_author_posts_url( $author_id ); ?>" class="post-author__link">Страница автора</a>
            </div>

        </div>
	</header>

    <div class="post-content">
        <div class="container">
            <div class="invisible-block-right"></div>
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
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'universaltheme' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div>
	</div>

    <footer class="post-footer">
        <div class="container">
            <?php
                $tags_list = get_the_tag_list( '', esc_html_x( '', 'list item separator', 'universaltheme' ) );
                if ( $tags_list ) {
                    /* translators: 1: list of tags. */
                    printf( '<div class="post-footer__tags">' . esc_html__( '%1$s', 'universaltheme' ) . '</div>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                }                
            ?>
            <div class="post-footer__social">
                <h2 class="post-footer__social-title">Поддержите репостом</h2>
                <?php meks_ess_share(); ?>
            </div>
        </div>
        
    </footer><!-- .entry-footer -->

</article>
 <?php dynamic_sidebar( 'post-posts' ); ?>