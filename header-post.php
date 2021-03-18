<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="header header-light">
    <div class="container">
        <nav class="header__nav">
            <?php
                // Получаем логотип без ссылки
                $logo_img = '';
                if( $custom_logo_id = get_theme_mod('custom_logo') ){
                    $logo_img = wp_get_attachment_image( $custom_logo_id, 'full', false, array(
                        'class'    => 'custom-logo',
                        'itemprop' => 'logo',
                    ) );
                }

                if( has_custom_logo() ){
                    if (is_front_page()) {
                        echo '<div class="site-logo">' . $logo_img . 
                        '<span class="site-name">' . get_bloginfo( 'name' ) . '</span></div>';
                    } else {
                        echo '<div class="site-logo">' . get_custom_logo() . 
                        '<a href="' . get_home_url() . '" class="home-link">
                        <span class="site-name">' . get_bloginfo( 'name' ) . '</span></a></div>';
                    }
                }
                else {
                    echo '<span class="site-name">' . get_bloginfo( 'name' ) . '</span>';
                }

                wp_nav_menu( [
                    'theme_location'  => 'header_menu',
                    'container'       => false,
                    'menu_class'      => 'header__menu', 
                    'echo'            => true,
                ] );
                echo get_search_form();
            ?>
        </nav>
    </div>
</header>