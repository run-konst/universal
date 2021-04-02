<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="container lesson__container">
        <header class="entry-header <?php echo get_post_type(); ?>__header">
            <!-- Navigation -->
            <div class="lesson__header-top">
                <?php 
                $taxonomies = get_the_taxonomies( );
                $genre = $taxonomies['genre'];
                echo $genre; 
                ?>
                <div class="lesson__header-nav">
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
        </header> 
        <main>
            <!-- Title -->
            <?php
            if ( is_singular() ) :
                the_title( '<h1 class="lesson__title">', '</h1>' );
            else :
                the_title( '<h2 class="lesson__title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
            endif;
            ?>

            <div class="lesson__video">
                <?php 
                $link = get_field('video_link');
                if (strpos($link, 'youtube.com')) {
                    $id = explode('?v=', $link );
                ?>
                    <iframe width="100%" height="641" src="https://www.youtube.com/embed/<?php echo end($id); ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <?php
                } elseif (strpos($link, 'vimeo.com')) {
                    $id = explode('vimeo.com/', $link );
                ?>
                    <iframe src="https://player.vimeo.com/video/<?php echo end($id); ?>" width="100%" height="641" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                <?php
                } else {
                    ?>
                        <iframe src="<?php the_field('video_link'); ?>" width="100%" height="641" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                    <?php
                }
                ?>
            </div>

            <!-- Info -->
            <div class="post-info lesson__info">
                <svg class="clock-icon">
                    <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#clock"></use>
                </svg>
                <span class="post-info-item"><?php the_time('j F, G:i'); ?></span>
            </div>
        </main>
        <footer class="post-footer">
            <div class="post-footer__social">
                <h2 class="post-footer__social-title">Поддержите репостом</h2>
                <?php meks_ess_share(); ?>
            </div>
        </footer>
    </div>

</article>