<?php

function theme_enqueue_styles() {
    wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css');
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/asset/js/scripts.js' ,array(), '1.0.0', true);
}