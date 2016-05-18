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

if (!defined('WPPS_MAIN')) {
    define('WPPS_MAIN', __FILE__);
}

require_once __DIR__ . '/config.php';

$instance = new WPPostScraper();

register_activation_hook(__FILE__, array($instance, 'WPPostScraper_activate'));
register_deactivation_hook(__FILE__, array($instance, 'WPPostScraper_deactivate'));