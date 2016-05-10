<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 4/28/16
 * Time: 1:53 PM
 */
class WPRandomPostController
{
    /**
     * @var WPRandomPostController
     */
    private static $instance;
    /**
     * @var WPRandomPostView
     */
    private $view;
    const PLUGIN_TEXTDOMAIN = HPBK_WPRP_TEXTDOMAIN;
    const MENU_SLUG = 'wp-random-post-menu';
    const OPTION_GROUP_ID = 'wp-random-post-option-group';
    const OPTION_NAME = 'wp_random_post_option_random_slug';

    public static function getInstance()
    {
        if (empty(static::$instance))
            static::$instance = new static();
        return static::$instance;
    }


    /**
     * WPRandomPostController constructor.
     */
    public function __construct()
    {
        $this->view = WPRandomPostView::getInstance();

        add_action('init', array($this, 'init_plugin'));
        if (is_admin()):
            add_action('admin_menu', array($this, 'init_admin'));
            add_action('admin_init', array($this, 'init_admin_page'));
        else:
            add_action('template_redirect', array($this, 'redirect_page'));
        endif;

    }

    /**
     * Kích hoạt khi Plugin được cài đặt và kích hoạt thành công
     */
    public function plugin_installing()
    {

    }

    /**
     * Kích hoạt khi Plugin bị deactivate
     */
    public function plugin_uninstalling()
    {

    }

    /**
     * Thiết lập tính năng đa ngôn ngữ cho Plugin (hỗ trợ VN/EN)
     */
    public function init_plugin()
    {
        $lang_path = HPBK_WPRP_BASE_NAME . '/lang/';
        $loaded = load_plugin_textdomain(self::PLUGIN_TEXTDOMAIN, false, $lang_path);
        if (!$loaded) {
            echo '<div class="error">Sample Localization: ' . __('Could not load the localization file: ' . $lang_path, self::PLUGIN_TEXTDOMAIN) . '</div>';
            return;
        }
    }

    /**
     * Thêm menu vào phía dưới mục "Cài đặt"
     */
    public function init_admin()
    {
        add_options_page(__('WP Random Post', self::PLUGIN_TEXTDOMAIN),
            __('WP Random Post Settings', self::PLUGIN_TEXTDOMAIN),
            'manage_options',
            self::MENU_SLUG,
            array($this, 'admin_options_page'));
    }

    /**
     * Tạo bảng cài đặt trong wp-admin cho Plugin
     */
    public function init_admin_page()
    {
        register_setting(self::OPTION_GROUP_ID,
            self::OPTION_NAME,
            array($this, 'sanitize'));
        add_filter(
            "update_option_" . self::OPTION_NAME,
            array($this, 'random_slug_callback'),
            10, 2);

        add_settings_section(
            'setting_section_id',
            '',
            array($this, 'section_info'),
            self::MENU_SLUG
        );
        add_settings_field(
            'random_slug',
            __('Random Slug', self::PLUGIN_TEXTDOMAIN),
            array($this, 'random_slug_input'),
            self::MENU_SLUG,
            'setting_section_id'
        );
    }

    /**
     * Render bảng cài đặt
     */
    public function admin_options_page()
    {
        $this->view->render('option-page');
    }

    /**
     * Chuẩn hoá lại các thông tin đã nhập
     * @param array $input
     * @return array
     */
    public function sanitize($input)
    {
        return $input;
    }

    /**
     * Khởi tạo ô Input cho Random Slug
     */
    public function random_slug_input()
    {
        $options = get_option(self::OPTION_NAME);
        $random_slug = isset($options['random_slug']) ? esc_attr($options['random_slug']) : '';
        ?>
        <input type="text" id="random_slug" name="<?php echo self::OPTION_NAME . "[random_slug]" ?>"
               value="<?php echo $random_slug ?>">
        <?php
    }

    /**
     * Handle sự thay đổi của trường Random Slug
     * @param string $old_value
     * @param string $new_value
     */
    public function random_slug_callback($old_value, $new_value)
    {
        if (!isset($new_value['random_slug']) or empty($new_value['random_slug']))
            return;
        $old_slug = $old_value['random_slug'];
        $new_slug = $new_value['random_slug'];
        if ($old_slug === $new_slug) return;


        /** @var WP_Post $old_page */
        $old_page = get_page_by_title($old_slug);
        if ($old_page) {
            wp_delete_post($old_page->ID, true);
        }

        /**
         * Insert a page with title=$new_slug
         * @var WP_Post $the_page
         */
        $the_page = get_page_by_title($new_slug);
        if (!$the_page) {
            $_p = array(
                'post_title' => $new_slug,
                'post_content' => 'fuck you',
                'post_status' => 'publish',
                'post_type' => 'page',
                'ping_status' => 'closed',
                'post_category' => array(1)
            );
            wp_insert_post($_p);
        }
    }

    /**
     * In chuỗi mô tả chi tiết chức năng của mục cài đặt
     * (cụ thể ở đây là chuỗi đường dẫn ngẫu nhiên)
     */
    public function section_info()
    {
        print sprintf(__('Your site will be redirected automatically to a random post when you access to %s/{%s}', self::PLUGIN_TEXTDOMAIN),
            get_site_url(),
            str_replace(' ', '_', __('Random Slug', self::PLUGIN_TEXTDOMAIN)));
    }

    /**
     * Tìm một post ngẫu nhiên, và redirect đến nó
     * @return void
     */
    public function redirect_page()
    {
        $options = get_option(self::OPTION_NAME);
        if (isset($options['random_slug']) and (!empty($options['random_slug']))) {
            $random_slug = $options['random_slug'];

            $posts = get_posts(array('numberposts' => -1));
            /**
             * @var WP_Post $post
             */
            $post = $posts[rand(0, count($posts))];

            if (is_page($random_slug)) {
                wp_redirect(get_post_permalink($post->ID));
                exit();
            }
        }
    }
}