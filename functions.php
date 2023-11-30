<?php
// Fonction pour enregistrer les emplacements de menu
function register_my_menus() {
    register_nav_menus(
        array(
            'primary' => __( 'Menu principal' ),
            'footer' => __( 'Menu du pied de page' )
        )
    );
}

// Appeler la fonction pour enregistrer les menus
add_action('init', 'register_my_menus');

// Fonction pour charger les styles et scripts du thème
function theme_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('mota-ajax-script', get_stylesheet_directory_uri() . '/ajax.js', array('jquery'), '1.0', true);
}

// Appeler la fonction pour charger les styles et scripts
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');


   