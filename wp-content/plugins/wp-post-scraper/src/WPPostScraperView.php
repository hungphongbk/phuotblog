<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/13/16
 * Time: 2:15 PM
 */
class WPPostScraperView extends \Philo\Blade\Blade
{
    private static $viewDir = WP_POST_SCRAPER_PATH . '/view';
    private static $cacheDir = WP_POST_SCRAPER_PATH . '/cache';

    private static $staticInstance;

    /**
     * @return WPPostScraperView
     */
    public static function getInstance()
    {
        if(!self::$staticInstance){
            self::$staticInstance = new static(self::$viewDir, self::$cacheDir);
        }
        return self::$staticInstance;
    }

    /**
     * @param string $viewName
     */
    public function renderView($viewName){
        /** @var \Illuminate\View\Factory $view */
        $view = $this->view();
        echo $view->make($viewName)->render();
    }
}