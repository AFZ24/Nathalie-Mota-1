<?php
// Ajouter le support de la barre d'administration
function mon_theme_setup() {
    add_theme_support('admin-bar', array('callback' => '__return_true'));
}
add_action('after_setup_theme', 'mon_theme_setup');


// Enregistrer le menu principal
function register_my_menu() {
    register_nav_menu('main-menu', __('Menu principal', 'text-domain'));
}
add_action('after_setup_theme', 'register_my_menu');

// Enqueue le fichier JavaScript si nécessaire
function mon_theme_enqueue_scripts() {
    wp_enqueue_script(
        'mon-fichier-js',
        get_template_directory_uri() . '/functions.js',
        array(),
        filemtime(get_template_directory() . '/functions.js'),
        true
    );
}
add_action('wp_enqueue_scripts', 'mon_theme_enqueue_scripts');

