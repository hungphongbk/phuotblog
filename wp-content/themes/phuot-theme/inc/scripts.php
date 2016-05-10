<?php

if (!function_exists('hpbk_fonts_url')) :
    /**
     * Register Google fonts for Twenty Fifteen.
     *
     * @since Twenty Fifteen 1.0
     *
     * @return string Google fonts URL for the theme.
     */
    function hpbk_fonts_url()
    {
        $fonts = array(
            'Noto Serif:400italic,700italic,400,700'
        );
        $subsets = 'latin,latin-ext,vietnamese';

        $fonts_url = add_query_arg(array(
            'family' => urlencode(implode('|', $fonts)),
            'subset' => urlencode($subsets),
        ), 'https://fonts.googleapis.com/css');
        return $fonts_url;
    }
endif;


function get_leaf_script($filename)
{
    $path = get_stylesheet_directory() . $filename;
    if (file_exists($path)) return get_stylesheet_directory_uri() . $filename;;
    return get_template_directory_uri() . $filename;
}

/**
 * Scripts and stylesheets
 */
function hpbk_scripts()
{
    /**
     * The build task in Gulp renames production assets with a hash
     * Read the asset names from assets-manifest.json
     */
    $assets = array();
    if (WP_ENV === 'development') {
        $assets = array(
            'vendor-css' => '/dist/css/vendor.css',
            'css' => '/dist/css/main.css',
            'js' => '/dist/scripts/main.js'
        );
    }

    wp_enqueue_style('hpbk_vendor_css', get_leaf_script($assets['vendor-css']), false, null);
    wp_enqueue_style('hpbk_fonts', hpbk_fonts_url(), array(), null);
    wp_enqueue_style('hpbk_css', get_leaf_script($assets['css']), false, null);
    wp_enqueue_script('hpbk_js', get_leaf_script($assets['js']), array(), null, true);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

}

add_action('wp_enqueue_scripts', 'hpbk_scripts', 100);

// http://wordpress.stackexchange.com/a/12450
function hpbk_jquery_local_fallback($src, $handle = null)
{
    static $add_jquery_fallback = false;

    if ($add_jquery_fallback) {
        echo '<script>window.jQuery || document.write(\'<script src="' . get_template_directory_uri() . '/src/vendor/jquery/dist/jquery.min.js?1.11.1"><\/script>\')</script>' . "\n";
        $add_jquery_fallback = false;
    }

    if ($handle === 'jquery') {
        $add_jquery_fallback = true;
    }

    return $src;
}

add_action('wp_head', 'hpbk_jquery_local_fallback');