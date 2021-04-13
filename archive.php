<?php get_header(); ?>

<main class="category-page">
    <div class="container">
    <?php if(function_exists('the_breadcrumbs')) the_breadcrumbs(); ?>
        <h2 class="category-page__title"><?php single_cat_title(); ?></h2>
        <ul class="category-page__list">
        <?php while ( have_posts() ){ the_post(); ?>

            <li class="category-page-card">
                <a href="<?php the_permalink(); ?>" class="category-page-card__link">
                    <img src="<?php the_post_thumbnail_url('smaller-thumb'); ?>" alt="<?php the_title(); ?>" class="category-page-card__img">
                    <div class="category-page-card__info">
                        <h3 class="category-page-card__title"><?php echo wp_trim_words( get_the_title(), 5); ?></h3>
                        <p class="category-page-card__excerpt"><?php echo wp_trim_words( get_the_excerpt(), 10); ?></p>
                        <div class="articles-grid-2__info category-page-card__author">
                            <?php $author_id = get_the_author_meta( 'ID' ); ?>
                            <img src="<?php echo get_avatar_url( $author_id ); ?>" alt="Аватар пользователя" class="articles-grid-2__avatar">
                            <div class="articles-grid-2__author-info">
                                <strong class="articles-grid-2__author category-page-card__author-name"><?php the_author(); ?></strong>
                                <div class="category-page-card__stats">
                                    <span class="category-page-card__date"><?php the_time('j F'); ?></span>
                                    <svg class="comment-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#comment"></use>
                                    </svg>
                                    <span class="category-page-card__comments"><?php comments_number('0', '1', '%'); ?></span>
                                    <svg class="like-icon">
                                        <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#like"></use>
                                    </svg>
                                    <span class="category-page-card__likes">42</span>
                                </div>
                            </div>
                        </div>                    
                    </div>
                </a>
            </li>
            
        <?php } ?>
        <?php if ( ! have_posts() ){ ?>
            Записей нет.
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
</main>

<?php get_footer(); ?>