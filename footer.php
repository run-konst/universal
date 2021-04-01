        <footer class="footer">
            <div class="container">
                <div class="footer__container">
                    <?php if( ! is_page( 'thankyou' ) ) : ?>
                        <form class="subscribe" action="https://app.getresponse.com/add_subscriber.html" accept-charset="utf-8" method="post">
                            <h3 class="subscribe__title">Подпишитесь на нашу рассылку</h3>
                            <div class="subscribe__wrapper">
                                <!-- Поле Email (обязательно) -->
                                <input class="subscribe__input" type="text" name="email" placeholder="Email" required>
                                <!-- Токен списка -->
                                <!-- Получить API ID на: https://app.getresponse.com/campaign_list.html -->
                                <input type="hidden" name="campaign_token" value="BHWmA">
                                <!-- Добавить подписчика в цикл на определенный день (по желанию) -->
                                <input type="hidden" name="start_day" value="0">
                                <!-- Страница благодарности (по желанию) -->
                                <input type="hidden" name="thankyou_url" value="<?php echo home_url('thankyou') ?>"/>
                                <!-- Кнопка подписаться -->
                                <button class="subscribe__btn" type="submit">Подписаться</button>
                            </div>
                        </form>
                    <?php endif; ?>
                    <?php
                    if ( ! is_active_sidebar( 'footer-sidebar' ) ) {
                        return;
                    }
                    ?>

                    <div class="footer-sidebar">
                        <?php dynamic_sidebar( 'footer-sidebar' ); ?>
                    </div>
                    <div class="footer__nav">
                        <?php
                            $logo_img = '';
                            if( $custom_logo_id = get_theme_mod('custom_logo') ){
                                $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                                    'class'    => 'custom-logo',
                                    'itemprop' => 'logo',
                                ) );
                            }
                            if( has_custom_logo() ){
                                if (is_front_page()) {
                                    echo '<div class="site-logo">' . $logo_img  . '</div>';
                                } else {
                                    echo '<div class="site-logo">' . get_custom_logo() . '</div>';
                                }
                            }
                            wp_nav_menu( [
                                'theme_location'  => 'footer_menu',
                                'container'       => false,
                                'menu_class'      => 'footer__pages', 
                                'echo'            => true,
                            ] );
                            $instance = array(
                                'facebook' => 'http://facebook.com',
                                'instagram' => 'http://instagram.com',
                                'youtube' => 'http://youtube.com',
                                'twitter' => 'http://twitter.com',
                            );
                            the_widget( 'Social_Widget', $instance, $args );
                        ?>                                            
                    </div>
                    <div class="footer__bottom">
                        <?php dynamic_sidebar( 'footer-text' ); ?>
                        <div class="footer__right">
                            <span class="footer__copyright">
                                <?php echo '&copy; ' . date('Y') . ' ' . get_bloginfo( 'name' ); ?>
                            </span>
                            <?php
                                $email = get_post_meta( 98, 'email', true );
                                if ($email) { ?>
                                    <a class="contact-field__mail" href="mailto:<?php the_field('email', 98); ?>"><?php the_field('email', 98); ?></a>
                                <?php }
                            ?>
                        </div>                    
                    </div>
                </div>

            </div>
        </footer>
        <?php wp_footer(); ?>
    </body>
</html>