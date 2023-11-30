<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <!-- Début de l'en-tête du site -->
    <header class="site-header">

        <div class="container">

            <!-- Logo du site -->
            <div class="site-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>">
                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/logo.png" alt="Logo">
                </a>
            </div>

            <!-- Navigation du site -->
            <nav class="site-navigation">
                
                <!-- Liste de navigation principale -->
                <ul class="menu">
                    <?php
                    // Affichage du menu principal//
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_class' => 'main-menu',
                    ));
                    ?>
                </ul>
            </nav>

        </div>
    </header>
    <!-- Fin de l'en-tête du site -->