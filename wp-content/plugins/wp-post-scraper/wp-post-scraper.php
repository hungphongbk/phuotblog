<?php

/*
Plugin Name: Wp Post Scraper
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A brief description of the Plugin.
Version: 1.0
Author: hungphongbk
Author URI: http://URI_Of_The_Plugin_Author
License: A "Slug" license name e.g. GPL2
*/

if (!defined('WP_POST_SCRAPER_PATH')) {
    define('WP_POST_SCRAPER_PATH', dirname(__FILE__));
}
// for dummy
if (!defined('DB_HOST')) {
    define('DB_HOST', 'local');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', 'wordpress');
}
if (!defined('DB_USER')) {
    define('DB_USER', 'root');
}
if (!defined('DB_PASSWORD')) {
    define('DB_PASSWORD', '');
}

// end dummy
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/WPPostScraper.php';
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/WPPostScraperView.php';

$instance = new WPPostScraper();

register_activation_hook(__FILE__, array($instance, 'WPPostScraper_activate'));
register_deactivation_hook(__FILE__, array($instance, 'WPPostScraper_deactivate'));