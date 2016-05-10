<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/7/16
 * Time: 1:02 AM
 */
class PhuotShortcodeManager
{
    private static $instance;

    private $registeredShortcodes = [
        'rateit'
    ];

    /**
     * @return mixed
     */
    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new static();
            self::$instance->initialize();
        }
        return self::$instance;
    }

    public function initialize()
    {
        foreach ($this->registeredShortcodes as $registeredShortcode) {
            add_shortcode($registeredShortcode, array($this, $registeredShortcode . 'Shortcode'));
        }
    }

    /**
     * @param array $attrs
     * @param null|string $content
     * @return string
     */
    public function rateitShortcode($attrs, $content = null)
    {
        $attrStr = "class = 'rateit'";
        foreach ($attrs as $key => $value) {
            $attrStr.=" data-rateit-$key='$value'";
        }
        return "<div $attrStr>$content</div>";
    }
}

PhuotShortcodeManager::getInstance();