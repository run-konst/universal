        <footer class="footer">
            <div class="container">
                <div class="footer__container">
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
                        <span class="footer__copyright">
                            <?php echo '&copy; ' . date('Y') . ' ' . get_bloginfo( 'name' ); ?>
                        </span>                     
                    </div>
                </div>

            </div>
        </footer>
        <?php wp_footer(); ?>
    </body>
</html>