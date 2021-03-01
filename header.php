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
<header class="header">
    <div class="container">
        <nav class="header__nav">
            <?php   
                if( has_custom_logo() ){
                    the_custom_logo();
                }
                else {
                    echo "Universal";
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