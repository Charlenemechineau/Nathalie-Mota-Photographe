<?php 
function register_my_menus(){}
        array(
        'primary' => __( 'menu-primary' ),
        'footer' => __( 'Footer-menu' )
        )
    ;


function theme_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css');
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/assets/js/scripts.js' ,array(), '1.0.0', true);
}
    add_action('wp_enqueue_scripts', 'theme_enqueue_styles');