<?php get_header(); ?>

<main class="search__results">
    <div class="container">
        <h2 class="search__title">Результаты поиска по запросу: <?php echo get_search_query(); ?></h2>
        
        <div class="news-column__container">
            <div class="news-column__left search__left">
                <ul class="search__list">

                <?php while ( have_posts() ){ the_post(); ?>
                    <li class="news-column__item">
                        <img src="
                        <?php if (has_post_thumbnail()) {
                            the_post_thumbnail_url('small-thumb');
                        } else {
                            echo get_template_directory_uri(  ) . '/assets/images/no-image.jpg';
                        } ?>" alt="<?php the_title(); ?>
                        " class="news-column__img">
                        <div class="news-column__article">
                            <?php 
                            foreach( get_the_category() as $category ) {
                                printf(
                                    '<a href="%s" class="news-column__cat-link cat-link cat-%s">%s</a>',
                                    esc_url(get_category_link($category)),
                                    esc_html($category -> slug),
                                    esc_html($category -> name)
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

                <?php } ?>

                </ul>
                <?php 
                $args = array(
                    'mid_size'     => 2,     // количество страниц вокруг текущей
                    'prev_text'    => '
                    <svg class="next-icon">
                    <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                    </svg>
                    <span>Назад</span>',
                    'next_text'    => '
                    <span>Вперед</span>
                    <svg class="next-icon">
                    <use xlink:href="' . get_template_directory_uri() . '/assets/images/sprite.svg#arrow"></use>
                    </svg>',
                );
                the_posts_pagination($args); 
                ?>
            </div>                    
            <div class="news-column__right">
                <aside class="search__sidebar">
                    <?php dynamic_sidebar( 'search__sidebar' ); ?>
                </aside>                  
            </div> 
            <?php if ( ! have_posts() ){ ?>
                Записей нет.
            <?php } ?>       
        </div>
    </div>
</main>

<?php get_footer(); ?>