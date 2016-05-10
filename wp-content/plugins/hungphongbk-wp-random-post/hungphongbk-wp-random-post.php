<?php
/**
 * Plugin Name: WP Random Post
 * Description: This plugin allow site redirects to randomize post via specific slug
 * Version: 1.0.0
 * Author: Phong Truong Hung
 * Text Domain: wprandompost
 */

if (!defined('HPBK_WPRP_BASE_PATH'))
    define('HPBK_WPRP_BASE_PATH', plugin_dir_path(__FILE__));
if (!defined('HPBK_WPRP_BASE_NAME'))
    define('HPBK_WPRP_BASE_NAME', plugin_basename(dirname(__FILE__)));
if (!defined('HPBK_WPRP_TEXTDOMAIN'))
    define('HPBK_WPRP_TEXTDOMAIN', 'hungphongbk-wp-random-post');

require_once('inc/wp-random-post-controller.php');
require_once('inc/wp-random-post-view.php');
$controller = WPRandomPostController::getInstance();
register_activation_hook(__FILE__, array($controller, 'plugin_installing'));
register_deactivation_hook(__FILE__, array($controller, 'plugin_uninstalling'));