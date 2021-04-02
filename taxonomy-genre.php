<?php get_header(); ?>

<main class="category-page">
    <div class="container">
        <h2 class="category-page__title"><?php single_cat_title(); ?></h2>
        <ul class="lesson-list">
        <?php while ( have_posts() ){ the_post(); ?>

            <li class="lesson-list__item">
            <div class="lesson-list__top">
                <h3 class="lesson-list__title">
                    <a href="<?php the_permalink(); ?>" class="lesson-list__link"><?php the_title(); ?></a>
                </h3>          
            </div>               
                <div class="lesson-list__info">
                    <strong class="lesson-list__author">                    
                        <?php 
                        $taxonomies = get_the_taxonomies( );
                        $teacher = $taxonomies['teacher'];
                        echo $teacher; 
                        ?>
                    </strong>
                    <span class="lesson-list__date"><?php the_time('j F'); ?></span>                 
                </div>
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