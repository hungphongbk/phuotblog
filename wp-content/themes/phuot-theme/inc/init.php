<?php

function hpbk_setup()
{

    // Make theme available for translation
    // Community translations can be found at https://github.com/cutlass/cutlass-translations
    load_theme_textdomain(THEME_TEXTDOMAIN, get_stylesheet_directory() . '/lang');

    // Register wp_nav_menu() menus
    // http://codex.wordpress.org/Function_Reference/register_nav_menus
    register_nav_menus(array(
        'primary_navigation' => __('Primary Navigation', THEME_TEXTDOMAIN)
    ));

    // Add post thumbnails
    // http://codex.wordpress.org/Post_Thumbnails
    // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
    // http://codex.wordpress.org/Function_Reference/add_image_size
    add_theme_support('post-thumbnails');

    // Add post formats
    // http://codex.wordpress.org/Post_Formats
    add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio'));

    // Add HTML5 markup for captions
    // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
    add_theme_support('html5', array('caption'));

    // Tell the TinyMCE editor to use a custom stylesheet
    //add_editor_style('/assets/css/editor-style.css');

    /**
     * Add feature CustomizeHeader
     * Cho phép Admin chọn hình ảnh hiển thị trên header của site
     */
    add_theme_support('custom-header', array(
        'width' => 1600,
        'height' => 400,
        'flex_height' => true
    ));
}

add_action('after_setup_theme', 'hpbk_setup');

/**
 * Register sidebars
 */
function hpbk_widgets_init()
{
    register_sidebar(array(
        'name' => __('Primary', THEME_TEXTDOMAIN),
        'id' => 'sidebar-primary',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));

    register_sidebar(array(
        'name' => __('Footer', THEME_TEXTDOMAIN),
        'id' => 'sidebar-footer',
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'hpbk_widgets_init');
