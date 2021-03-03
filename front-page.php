<?php get_header(); ?>

<main>
    <h1 class="visually-hidden">Главная страница Universal</h1>
    <section class="hero">
        <div class="container">
            <div class="hero__container">
            <?php
                global $post;

                $myposts = get_posts([ 
                    'numberposts' => 1,
                ]);

                if( $myposts ){
                    foreach( $myposts as $post ){
                        setup_postdata( $post );
                        ?>

                        <article class="hero__left topic">
                            <img src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="topic__thumb">
                            <?php $author_id = get_the_author_meta( 'ID' ); ?>
                            <a href=" <?php echo get_author_posts_url( $author_id ); ?>" class="topic-author">
                                <img class="topic-author__avatar" src="<?php echo get_avatar_url( $author_id ); ?>" alt="Аватар пользователя">
                                <div class="topic-author__info">
                                    <h3 class="topic-author__name"><?php the_author(); ?></h3>
                                    <span class="topic-author__rank">Разработчик</span>
                                </div>
                            </a>
                            <div class="topic__info">
                                <?php the_category(); ?>
                                <h2 class="topic__heading"><?php the_title(); ?></h2>
                                <a href="<?php the_permalink(); ?>" class="topic__button">Читать далее</a>
                            </div>
                        </article>
                        
                        <?php 
                    }
                } else {
                    // Постов не найдено
                }

                wp_reset_postdata(); // Сбрасываем $post
            ?>
                <div class="hero__right recomend">
                    <h3 class="recomend__heading">Рекомендуем</h3>
                        <ul class="recomend__list">
                        <?php
                            global $post;

                            $myposts = get_posts([ 
                                'numberposts' => 5,
                                'offset' => 1,
                            ]);
                            if( $myposts ){
                                foreach( $myposts as $post ){
                                    setup_postdata( $post );
                                    ?>
                                    
                                        <li class="recomend__item">
                                            <?php the_category(); ?>
                                            <a href="<?php the_permalink(); ?>" class="recomend__link">
                                                <h4 class="recomend__text"><?php echo wp_trim_words( get_the_title(), 5); ?></h4>
                                            </a>
                                        </li>

                                    <?php 
                                }
                            } else {
                                // Постов не найдено
                            }

                            wp_reset_postdata(); // Сбрасываем $post
                        ?>
                        </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="articles">
        <div class="container">
            <ul class="articles__list">
                <?php
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 4,
                    ]);

                    if( $myposts ){
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>

                                <li class="articles__item">
                                    <a href="<?php the_permalink(); ?>" class="articles__link">
                                        <h3 class="articles__heading"><?php echo mb_strimwidth(get_the_title(), 0, 50, "..."); ?></h3>
                                        <img src="<?php the_post_thumbnail_url('homepage-thumb'); ?>" alt="<?php the_title(); ?>" class="articles__img">
                                    </a>
                                </li>

                            <?php 
                        }
                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata(); // Сбрасываем $post
                ?>
            </ul>
        </div>
    </section>
</main>

<?php get_footer(); ?>