<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/17/16
 * Time: 11:07 AM
 */
if (!defined('WPPS_PATH')) {
    define('WPPS_PATH', dirname(__FILE__));
}
if (!defined('WPPS_QUEUE_NAME')) {
    define('WPPS_QUEUE_NAME', 'hpbk-wp-queue');
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

if (!(defined('AWS_ACCESS_KEY_ID') && defined('AWS_SECRET_ACCESS_KEY'))) {
    define('AWS_ACCESS_KEY_ID', 'AKIAJHET6EOIMHVKBYXQ');
    define('AWS_SECRET_ACCESS_KEY', '8JnM+WCTMhyrYtp9ngGbBH36QpdlzwPXnrk9Sbes');
}

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/src/CrawledPost.php';
require_once __DIR__ . '/src/Database.php';
require_once __DIR__ . '/src/WPPostScraper.php';
require_once __DIR__ . '/src/WPPostScraperCrawler.php';
require_once __DIR__ . '/src/WPPostScraperQueue.php';
require_once __DIR__ . '/src/WPPostScraperView.php';