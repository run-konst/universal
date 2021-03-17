<?php get_header(); ?>

<main>
    <h1 class="visually-hidden">Главная страница Universal</h1>

    <!-- HERO -->

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
                                <a href="<?php the_permalink(); ?>" class="read-more-button topic__button">
                                    <span>Читать далее</span>
                                    <svg class="arrow-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#arrow"></use>
                                    </svg>
                                </a>
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
    
    <!-- ARTICLES -->

    <section class="articles">
        <div class="container">
            <ul class="articles__list">
                <?php
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 4,
                        'category_name' => 'articles',
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
    
    <!-- ARTICLES GRID -->

    <section class="articles-grid">
        <div class="container">
            <div class="articles-grid__container">
                <ul class="articles-grid__left">
                <?php
                // задаем нужные нам критерии выборки данных из БД
                $args = array(
                    'posts_per_page' => 7,
                    'category__not_in' => '21',
                    'tag' => 'Фриланс, трудоустройство'
                );

                $query = new WP_Query( $args );

                // Цикл
                if ( $query->have_posts() ) {
                    $i = 0;                    
                    while ( $query->have_posts() ) {
                        $query->the_post();
                        $i++;
                        switch ($i) {
                            case '1':
                                ?>
        <li class="articles-grid__item articles-grid-1">
            <a href="<?php the_permalink(); ?>" class="articles-grid-1__link">
                <div class="articles-grid-1__top">
                    <img class="articles-grid-1__img" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    <span class="articles-grid-1__category"><?php echo get_the_category()[0]->name; ?></span>
                    <h3 class="articles-grid-1__heading"><?php echo wp_trim_words( get_the_title(), 10); ?></h3>
                    <p class="articles-grid-1__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15); ?></p>
                </div>
                <div class="articles-grid-1__info">
                    <?php $author_id = get_the_author_meta( 'ID' ); ?>
                    <img src="<?php echo get_avatar_url( $author_id ); ?>" alt="Аватар пользователя" class="articles-grid-1__avatar">
                    <strong class="articles-grid-1__author"><?php the_author(); ?>:</strong>
                    <span class="articles-grid-1__cite"><?php echo wp_trim_words( get_the_author_meta('description'), 4); ?></span>
                    <span class="articles-grid-1__comments"><?php comments_number('0', '1', '%'); ?></span>                                                
                </div>
            </a>
        </li>
                                <?php
                                break;

                            case '2':
                                ?>
        <li class="articles-grid__item articles-grid-2">
            <a href="<?php the_permalink(); ?>" class="articles-grid-2__link">
                <img class="articles-grid-2__img" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <span class="articles-grid-2__tag">
                    <?php 
                        $tags = get_the_tags();
                        if ($tags) {
                            echo $tags[0]->name;
                        }
                    ?>
                </span>
                <span class="articles-grid-2__category"><?php echo get_the_category()[0]->name; ?></span>
                <h3 class="articles-grid-2__heading"><?php echo wp_trim_words( get_the_title(), 10); ?></h3>
                <div class="articles-grid-2__info">
                    <?php $author_id = get_the_author_meta( 'ID' ); ?>
                    <img src="<?php echo get_avatar_url( $author_id ); ?>" alt="Аватар пользователя" class="articles-grid-2__avatar">
                    <div class="articles-grid-2__author-info">
                        <strong class="articles-grid-2__author"><?php the_author(); ?></strong>
                        <span class="articles-grid-2__date"><?php the_time('j F'); ?></span>
                        <span class="articles-grid-2__comments"><?php comments_number('0', '1', '%'); ?></span>
                        <span class="articles-grid-2__likes">42</span>
                    </div>
                </div>                
            </a>
        </li>
                                <?php
                                break;

                            case '3':
                                ?>
        <li class="articles-grid__item articles-grid-3">
            <a href="<?php the_permalink(); ?>" class="articles-grid-3__link">
                <img class="articles-grid-3__img" src="<?php the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                <h3 class="articles-grid-3__heading"><?php echo wp_trim_words( get_the_title(), 10); ?></h3>               
            </a>
        </li>
                                <?php
                                break;
                            
                            default:
                                ?>
        <li class="articles-grid__item articles-grid-default">
            <a href="<?php the_permalink(); ?>" class="articles-grid-default__link">
                <h3 class="articles-grid-default__heading"><?php echo mb_strimwidth(get_the_title(), 0, 20, "..."); ?></h3>
                <p class="articles-grid-default__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 7); ?></p>
                <span class="articles-grid-default__date"><?php the_time('j F'); ?></span>              
            </a>
        </li>
                                <?php
                                break;
                        }
                    }
                } else {
                    // Постов не найдено
                }
                // Возвращаем оригинальные данные поста. Сбрасываем $post.
                wp_reset_postdata();
                
                ?>
                </ul>
                <div class="articles-grid__right">
                    <?php get_sidebar('grid'); ?>
                </div>
            </div>
        </div>                    
    </section>
    
    <!-- INVESTIGATION -->

    <?php
        global $post;

        $myposts = get_posts([ 
            'numberposts' => 1,
            'category_name' => 'investigation',
        ]);

        if( $myposts ){
            foreach( $myposts as $post ){
                setup_postdata( $post );
                ?>

                <section class="investigation" style="background: linear-gradient(0deg, rgba(64, 48, 61, 0.35), rgba(64, 48, 61, 0.35)), url('<?php the_post_thumbnail_url(); ?>') no-repeat center center">
                    <div class="container investigation__container">
                        <h2 class="investigation__heading"><?php the_title(); ?></h2>
                        <a href="<?php the_permalink(); ?>" class="read-more-button">
                            <span>Читать статью</span>
                            <svg class="arrow-icon">
                                <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#arrow"></use>
                            </svg>
                        </a>
                    </div>
                </section>

                <?php 
            }
        } else {
            // Постов не найдено
        }

        wp_reset_postdata(); // Сбрасываем $post
    ?>
    
    <!-- NEWS COLUMN -->

    <section class="news-column">
        <div class="container">
            <div class="news-column__container">
                <ul class="news-column__left">
                <?php
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 6,
                        'tag' => 'Фриланс, трудоустройство'
                    ]);

                    if( $myposts ){
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>

                            <li class="news-column__item">
                                <img src="<?php the_post_thumbnail_url('small-thumb'); ?>" alt="<?php the_title(); ?>" class="news-column__img">
                                <div class="news-column__article">
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
                                    <a href="<?php the_permalink(); ?>" class="news-column__link">
                                        <h2 class="news-column__heading"><?php the_title(); ?></h2>
                                    </a>
                                    <p class="news-column__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 20); ?></p>
                                    <div class="news-column__info">
                                        <span class="news-column__date"><?php the_time('j F'); ?></span>
                                        <span class="news-column__comments"><?php comments_number('0', '1', '%'); ?></span>
                                        <span class="news-column__likes">42</span>
                                    </div>
                                </div>                            
                            </li>

                            <?php 
                        }
                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata(); // Сбрасываем $post
                ?>
                </ul>
                <div class="news-column__right">
                    <?php get_sidebar('articles'); ?>                    
                </div>        
            </div>
        </div>
    </section>
    
    <!-- SPECIAL -->

    <section class="special">
        <div class="container special__container">
            <div class="special__left photo-report">
            <?php
                    global $post;

                    $myposts = get_posts([ 
                        'numberposts' => 1,
                        'category_name' => 'photoreport'
                    ]);

                    if( $myposts ){
                        foreach( $myposts as $post ){
                            setup_postdata( $post );
                            ?>
                            <!-- Slider main container -->
                            <div class="swiper-container photo-report__slider">
                            <!-- Additional required wrapper -->
                                <div class="swiper-wrapper">
                                    <?php
                                    $images = get_attached_media('image');
                                    foreach ($images as $image) {
                                    ?>
                                        <div class="swiper-slide photo-report__slide">
                                            <img class="photo-report__img" src="<?php echo $image -> guid; ?>" alt="Картинка">
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <!-- If we need pagination -->
                                <div class="swiper-pagination"></div>
                            </div>
                            <div class="photo-report__article">
                                <?php 
                                foreach( get_the_category() as $category ) {
                                    printf(
                                        '<a href="%s" class="photo-report__category">%s</a>',
                                        esc_url(get_category_link($category)),
                                        esc_html($category -> name),
                                    ); 
                                }
                                $author_id = get_the_author_meta( 'ID' ); 
                                ?>
                                <a href=" <?php echo get_author_posts_url( $author_id ); ?>" class="photo-report__author">
                                    <img class="photo-report__author-avatar" src="<?php echo get_avatar_url( $author_id ); ?>" alt="Аватар пользователя">
                                    <h3 class="photo-report__author-name"><?php the_author(); ?></h3>
                                    <span class="photo-report__author-rank">Разработчик</span>
                                </a>
                                <h2 class="photo-report__heading">
                                    <a href="<?php the_permalink(); ?>" class="photo-report__link"><?php the_title(); ?></a>
                                </h2>        
                                <a href="<?php the_permalink(); ?>" class="read-more-button">
                                    <svg class="photo-report__icon">
                                        <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#images"></use>
                                    </svg>
                                    <span>Смотреть фото</span>
                                    <span class="photo-report__count"><?php echo count($images); ?></span>
                                </a>                                
                            </div> 
                            <?php 
                        }
                    } else {
                        // Постов не найдено
                    }

                    wp_reset_postdata(); // Сбрасываем $post
                ?>            
            </div>
    
    <!-- Правая колонка -->

            <ul class="special__right">
                <?php
                // задаем нужные нам критерии выборки данных из БД
                $args = array(
                    'posts_per_page' => 1,
                    'category_name' => 'career',
                );
                $query = new WP_Query($args);

                // Цикл
                if ( $query->have_posts() ) {                   
                    while ( $query->have_posts() ) {
                        $query->the_post();
                ?>
    
                <!-- Первый пост -->

                <li class="special__article">
                    <img class="special__img" src="<?php echo get_template_directory_uri(); ?>/assets/images/career.png" alt="<?php the_title(); ?>">
                    <?php 
                    foreach( get_the_category() as $category ) {
                        printf(
                            '<a href="%s" class="special__category cat-link cat-%s">%s</a>',
                            esc_url(get_category_link($category)),
                            esc_html($category -> slug),
                            esc_html($category -> name),
                        ); 
                    }
                    ?>
                    <h3 class="special__heading"><?php echo wp_trim_words( get_the_title(), 10); ?></h3>
                    <p class="special__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 15); ?></p>
                    <a href="<?php the_permalink(); ?>" class="read-more-button special__button">
                        <span>Читать далее</span>
                        <svg class="arrow-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#arrow"></use>
                        </svg>
                    </a>
                </li>
                <?php
                    }
                } else {
                    // Постов не найдено
                }
                // Возвращаем оригинальные данные поста. Сбрасываем $post.
                wp_reset_postdata();
                
                ?>
    
                <!-- Еще 2 поста -->
                
                <?php                
                global $post;

                $myposts = get_posts([ 
                    'numberposts' => 2,
                ]);

                if( $myposts ){
                    foreach( $myposts as $post ){
                        setup_postdata( $post );
                        ?>
                        <li class="articles-grid__item articles-grid-default">
                            <a href="<?php the_permalink(); ?>" class="articles-grid-default__link">
                                <h3 class="articles-grid-default__heading"><?php echo mb_strimwidth(get_the_title(), 0, 20, "..."); ?></h3>
                                <p class="articles-grid-default__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 7); ?></p>
                                <span class="articles-grid-default__date"><?php the_time('j F'); ?></span>              
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