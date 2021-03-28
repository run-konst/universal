<?php 
/*
Template Name: Страница контакты
Template Post Type: page
*/
?>

<?php get_header(); ?>

<main class="contacts-page">
    <div class="container">
        <h1 class="contacts-page__title"><?php the_title(); ?></h1>
        <div class="contacts-page__content">
            <div class="contacts-page__left">
                <form class="contact-form" method="POST">
                    <p class="contact-form__heading">Через форму обратной связи</p>
                    <input class="contact-form__item" type="text" name="contact_name" placeholder="Ваше имя">
                    <input class="contact-form__item" type="email" name="contact_email" placeholder="Ваш Email">
                    <textarea name="contact_comment" class="contact-form__textarea contact-form__item" placeholder="Ваш вопрос"></textarea>
                    <button class="contact-form__btn" type="submit">
                        <span>Отправить</span>
                        <svg class="arrow-icon">
                            <use xlink:href="<?php echo get_template_directory_uri(); ?>/assets/images/sprite.svg#arrow"></use>
                        </svg>
                    </button>            
                </form>
                <?php echo do_shortcode('[contact-form-7 id="341" title="Contact form"]'); ?>
            </div>
            <div class="contacts-page__right">
                <p class="contact-form__heading">Или по этим контактам</p>
                <div class="contact-field">
                    <a class="contact-field__mail" href="mailto:<?php the_field('email'); ?>"><?php the_field('email'); ?></a>
                    <address class="contact-field__address"><?php the_field('address'); ?></address>
                    <a class="contact-field__phone" href="tel:<?php the_field('phone'); ?>"><?php the_field('phone'); ?></a>                
                </div>          
            </div>
        </div>
    </div>
</main>



<?php get_footer(); ?>