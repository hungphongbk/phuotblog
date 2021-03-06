<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/12/16
 * Time: 5:28 PM
 */
use \Symfony\Component\DomCrawler\Crawler;

class WPPostScraper
{
    const PLUGIN_TEXTDOMAIN = 'wp-post-scraper';
    private $adminPageSlug = '/wpps-admin-page.php';
    private $settings = [
        'aws-credentials-access-key',
        'aws-credentials-secret'
    ];

    /**
     * @var WPPostScraperView
     */
    private $view;

    /**
     * @var integer
     */
    private $pid;


    /**
     * @param string $actionName
     * @return string
     */
    public static function getAction($actionName)
    {
        return md5($actionName);
    }

    function __construct()
    {
        if (!$this->view)
            $this->view = WPPostScraperView::getInstance();

        if (is_admin()) {
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
        // Load languages
        $lang_path = WPPS_PATH . '/lang/';
        load_plugin_textdomain(self::PLUGIN_TEXTDOMAIN, false, $lang_path);

        // Define AJAX post action
        $crawlAction = static::getAction('crawl');
        add_action('wp_ajax_' . $crawlAction, array($this, 'adminPage_crawl'));
        add_action('wp_ajax_' . static::getAction('aws_form'), array($this, 'adminPage_getAwsInputForm'));

        // Add settings
        foreach ($this->settings as $setting) {
            register_setting('wp-post-scraper-settings-group', $setting);
        }
    }

    public function adminPage_adminMenu()
    {
        $hook_suffixes = array();
        $hook_suffixes[] = add_menu_page(
            __('WP Post Scraper Settings', self::PLUGIN_TEXTDOMAIN),
            __('WP Post Scraper', self::PLUGIN_TEXTDOMAIN),
            'manage_options',
            $this->adminPageSlug,
            array($this, 'adminPage_content'));

        foreach ($hook_suffixes as $hook_suffix) {
            add_action('load-' . $hook_suffix, array($this, 'adminPage_enqueueScripts'));
        }
    }

    public function adminPage_content()
    {
        $this->view->renderView('index', array(
            'aws_exists' => $this->checkForAws()
        ));
    }

    public function adminPage_enqueueScripts()
    {
        $src = plugins_url('assets/build/main.js', WPPS_MAIN);
        wp_enqueue_script('wp_post_scraper_js', $src, array('jquery'));

        wp_localize_script('wp_post_scraper_js', 'ajaxObj', array(
            "ajaxUrl" => admin_url('admin-ajax.php')
        ));
    }

    /**
     *
     */
    public function adminPage_crawl()
    {
        $workerAction = isset($_REQUEST['worker']) ? $_REQUEST['worker'] : '';

        echo $workerAction . "\n";
        if (!empty($workerAction)) {
            if ($workerAction == 'start') {
                $aws_credentials = $this->getAwsCredentials();
                WPPostScraperQueue::setAwsCredentials(array(
                    'region' => 'ap-southeast-1',
                    'credentials' => $aws_credentials
                ));

                $command = "php " . WPPS_PATH . "/crawl-worker.php";
                $command .= " -k " . $aws_credentials['key'] . " -s " . $aws_credentials['secret'];
                $log_file = WPPS_PATH . "/log.txt";
                $this->pid = (int)exec("$command >$log_file 2>&1 & echo $!");
                echo "background worker started with pid = $this->pid";

                $message = new WPPostScraperCrawler(array(
                    "url" => "http://www.cuongchan.com/kinh-nghiem/"
                ));

                WPPostScraperQueue::sendNewMessage($message);
            } else {
                echo "PID = $this->pid\n";
                if ($this->pid == 0) {
                    echo "no process running!";
                } else {
                    exec("kill $this->pid 2>&1", $status);
                    echo "background process terminated :)\n";
                    echo implode("\n", $status);
                    $this->pid = 0;
                }
            }
        }
        /*header("Content-Type: Application/json");
        $url = isset($_REQUEST['crawl_url']) ? $_REQUEST['crawl_url'] : '';
        $base = "http://www.cuongchan.com/ky-su/";

        $result = WPPostScraperCrawler::getInstance($base)->crawl($url, function (Crawler $crawler) use ($base, $url) {
            $rs = array();
            if ($url == "") {
                $filter = $crawler->filter("li.list-post");
                if (iterator_count($filter) > 1) {
                    foreach ($filter as $i => $content) {
                        $crawler = new \Symfony\Component\DomCrawler\Crawler($content);
                        $filtered = $crawler->filter(".grid-title>a");
                        $title = $filtered->text();
                        $link = str_replace($base, "", $filtered->attr("href"));
                        $admin_url = admin_url('admin-ajax.php?action=' . static::getAction('crawl') . '&crawl_url=' . urlencode($link));

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $admin_url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        $body = curl_exec($ch);
                        curl_close($ch);

                        $rs[$i] = array(
                            "title" => $title,
                            "link" => $link,
                            "admin_url" => $admin_url,
                            "body" => $body
                        );
                    }
                }
            } else {
                $rs['body'] = $crawler->filter('.inner-post-entry')->html();
            }

            return $rs;
        });

        echo json_encode($result);*/
        exit(0);
    }

    /**
     * Get AWS Input Form
     */
    public function adminPage_getAwsInputForm()
    {
        $this->view->renderView('part.aws', array(
            'aws_exists' => false
        ));

        exit(0);
    }

    /**
     * @return bool
     */
    public function checkForAws()
    {
        $aws_access_key = get_option('aws-credentials-access-key');
        if (!$aws_access_key) return false;

        $force_reveal = false;
        if (isset($_GET['force-reveal-credentials'])) $force_reveal = true;

        return !$force_reveal;
    }

    /**
     * @return array
     */
    public function getAwsCredentials()
    {
        return array(
            'key' => get_option('aws-credentials-access-key'),
            'secret' => get_option('aws-credentials-secret')
        );
    }
}