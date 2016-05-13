<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/12/16
 * Time: 5:28 PM
 */
class WPPostScraper
{
    const PLUGIN_TEXTDOMAIN = 'wp-post-scraper';
    private $adminPageSlug = '/wp-post-scraper/admin-page.php';
    /**
     * @var WPPostScraperView
     */
    private $view;

    function __construct()
    {
        if(!$this->view)
            $this->view = WPPostScraperView::getInstance();

        if(is_admin()) {
            add_action('admin_init', array($this, 'adminPage'));
            add_action('admin_menu', array($this, 'adminPage_adminMenu'));
        }
    }

    public function WPPostScraper_activate()
    {
        Database::getInstance()->initTable();

    }

    public function WPPostScraper_deactivate()
    {
        Database::getInstance()->dropTable();
    }

    public function adminPage()
    {
        $lang_path = WP_POST_SCRAPER_PATH . '/lang/';
        load_plugin_textdomain(self::PLUGIN_TEXTDOMAIN, false, $lang_path);
    }

    public function adminPage_adminMenu()
    {
        add_menu_page(
            __('WP Post Scraper Settings', self::PLUGIN_TEXTDOMAIN),
            __('WP Post Scraper', self::PLUGIN_TEXTDOMAIN),
            'manage_options',
            $this->adminPageSlug,
            array($this, 'adminPage_content'));
    }

    public function adminPage_content()
    {
        $this->view->renderView('index');
    }
}