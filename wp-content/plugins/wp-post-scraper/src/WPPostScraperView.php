<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/13/16
 * Time: 2:15 PM
 */
class WPPostScraperView extends \Philo\Blade\Blade
{
    private static $viewDir = WPPS_PATH . '/view';
    private static $cacheDir = WPPS_PATH . '/cache';

    private static $staticInstance;

    /**
     * @return WPPostScraperView
     */
    public static function getInstance()
    {
        if (!self::$staticInstance) {
            self::$staticInstance = new static(self::$viewDir, self::$cacheDir);
        }
        return self::$staticInstance;
    }

    /**
     * @param string $viewName
     * @param array $data
     */
    public function renderView($viewName, $data = [])
    {
        /** @var \Illuminate\View\Factory $view */
        $view = $this->view();
        echo $view->make($viewName, $data)->render();
    }
}