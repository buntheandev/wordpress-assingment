<?php

add_action('wp_enqueue_scripts', 'wpdocs_scripts_method');

/*
 * Enqueue a script with the correct path.
 */
function wpdocs_scripts_method()
{
    wp_enqueue_script(
        'fonts_awesome',
        'https://use.fontawesome.com/releases/v5.15.1/js/all.js',
        ''
    );

    wp_enqueue_style(
        'google_fonts',
        'https://fonts.googleapis.com/css?family=Battambang:400,700&amp;subset=khmer'
    );
    wp_enqueue_style(
        'google_fonts_2',
        'https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic'
    );

    wp_enqueue_style(
        'custom_style',
        get_template_directory_uri() . '/css/custom.css'
    );

    wp_enqueue_style(
        'main_style',
        get_template_directory_uri() . '/css/styles.css'
    );
}

add_theme_support('post-thumbnails');

register_nav_menus(array(
    'pluginbuddy_mobile' => 'PluginBuddy Mobile Navigation Menu',
));


// Our custom post type function
function create_posttype()
{

    register_post_type(
        'Products',
        // CPT Options
        array(
            'labels' => array(
                'name' => ('products'),
                'singular_name' => ('porduct')
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'products'),
            'show_in_rest' => true,

        )
    );
}
// Hooking up our function to theme setup
add_action('init', 'create_posttype');
