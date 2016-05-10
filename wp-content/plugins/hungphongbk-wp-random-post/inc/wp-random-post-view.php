<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/28/16
 * Time: 2:06 PM
 */
class WPRandomPostView
{
    /**
     * @var WPRandomPostView
     */
    private static $instance;

    public static function getInstance()
    {
        if (empty(static::$instance))
            static::$instance = new static();
        return static::$instance;
    }

    /**
     * @param string $templateName
     * @return void
     */
    public function render($templateName)
    {
        $filename = HPBK_WPRP_BASE_PATH . "views/$templateName.php";
        include $filename;
    }
}