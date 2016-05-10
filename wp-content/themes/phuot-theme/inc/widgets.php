<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/15/16
 * Time: 1:52 PM
 */

/**
 * @param string $template
 * @param array $args
 * @return string
 */
if (!function_exists('widget_blade_include')):
    function widget_blade_include($template, $args)
    {
        hpbk_custom_blade_include($template, $args, 'widgets');
    }
endif;


class Custom_Widget_About_Me extends WP_Widget
{
    protected static $fields = [
        'title', 'image', 'intro',
        'social_facebook', 'social_google', 'social_instagram'
    ];

    /**
     * Render nội dung của content lên trang Wordpress
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $args Các tham số gồm có 'before_title', 'after_title',
     *                        'before_widget', và 'after_widget'.
     * @param array $instance The settings for the particular instance of the widget.
     */
    public function widget($args, $instance)
    {
        $title = apply_filters('widget_title', $instance['title']);
        foreach (static::$fields as $field)
            if ($field !== 'title') {
                $$field = isset($instance[$field]) ? $instance[$field] : '';
            }

        $params = array();
        foreach (static::$fields as $field) {
            $params[$field] = $$field;
        }
        $params = array_merge($params, array('args' => $args));
        widget_blade_include('widget-aboutme.blade.php', $params);
    }

    /**
     * Updates a particular instance of a widget.
     *
     * This function should check that `$new_instance` is set correctly. The newly-calculated
     * value of `$instance` should be returned. If false is returned, the instance won't be
     * saved/updated.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $new_instance New settings for this instance as input by the user via
     *                            WP_Widget::form().
     * @param array $old_instance Old settings for this instance.
     * @return array Settings to save or bool false to cancel saving.
     */
    public function update($new_instance, $old_instance)
    {
        $allowed_tags = "<b>,<i>";

        $instance = array();
        foreach (static::$fields as $field) {
            if ($field === 'intro')
                $instance['intro'] = (!empty($new_instance['intro'])) ? strip_tags($new_instance['intro'], $allowed_tags) : '';
            else
                $instance[$field] = (!empty($new_instance[$field])) ? strip_tags($new_instance[$field]) : '';
        }
        add_action('admin_notices', array($this, 'update_completed_notice'));
        return $instance;
    }

    /**
     * Hiển thị form cập nhật thông tin trên wp admin
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     * @return string Default return is 'noform'.
     */
    public function form($instance)
    {
        if (isset($instance['title']) and (!empty($instance['title']))) {
            $title = $instance['title'];
        } else {
            $title = __('About Me', THEME_TEXTDOMAIN);
        }
        foreach (static::$fields as $field)
            if ($field !== 'title') {
                if (isset($instance[$field]) and (!empty($instance[$field])))
                    $$field = $instance[$field];
                else
                    $$field = '';
            }

        $params = array();
        foreach (static::$fields as $field) {
            $params[$field] = $$field;
        }
        $params = array_merge($params, array('obj' => $this));

        widget_blade_include('widget-aboutme-form.blade.php', $params);

    }

    public function default_widget_title($title)
    {
        if (empty($title))
            return __('About Me', THEME_TEXTDOMAIN);
        return $title;
    }

    /**
     * Reference: https://paulund.co.uk/add-upload-media-library-widgets
     */
    public function enable_upload_media()
    {
        wp_register_script('hpbk-admin-upload-media-script', get_leaf_script('/dist/scripts/admin-upload-media.js'));

        wp_enqueue_style('thickbox');
        wp_enqueue_script('media-upload');
        wp_enqueue_script('thickbox');
        wp_enqueue_script('hpbk-admin-upload-media-script');
    }

    public function update_completed_notice()
    {
        $plugin_name = __('About Me', THEME_TEXTDOMAIN);
        ?>
        <div class="updated notice">
            <p><?php echo sprintf(__("Plugin <b>%s</b> has been updated!", THEME_TEXTDOMAIN), $plugin_name); ?></p>
        </div>
        <?php
    }

    public function __construct()
    {
        /**
         * Các tham số
         * 1. Định danh widget
         * 2. Tên hiển thị của Widget
         * 3. Giới thiệu ngắn về Widget
         * 4. Là cái gì kệ mẹ nó, đếch quan tâm
         */
        parent::__construct(
            static::class,
            __('About Me', THEME_TEXTDOMAIN),
            array(
                'classname' => 'phuot-aboutme',
                'description' => __('Just a simple widget that allow you to introduce about yourself', THEME_TEXTDOMAIN),
            ));

        add_filter('widget_title', array($this, 'default_widget_title'));
        add_action('admin_enqueue_scripts', array($this, 'enable_upload_media'));
    }
}

if (!function_exists('hpbk_load_widgets')):
    function hpbk_load_widgets()
    {
        register_widget(Custom_Widget_About_Me::class);
    }
endif;
add_action('widgets_init', 'hpbk_load_widgets');