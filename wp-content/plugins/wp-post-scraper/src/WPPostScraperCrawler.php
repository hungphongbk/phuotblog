<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/13/16
 * Time: 6:15 PM
 */

use \Symfony\Component\DomCrawler\Crawler as DomCrawler;

class WPPostScraperCrawler
{
    /**
     * URL to thw website will be crawled
     *
     * @var string
     */
    public $url;

    /**
     * The receipt handle from SQS, used to identify the message when interacting with the queue
     *
     * @var string
     */
    public $receipt_handle;

    /**
     * WPPostScraperCrawler constructor.
     * Construct the object with message data and optional receipt_handle if relevant
     *
     * @param string|array $data
     * @param string $receipt_handle
     */
    public function __construct($data, $receipt_handle = '')
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }

        $this->url = $data['url'];
        $this->receipt_handle = $receipt_handle;
    }

    /**
     * Returns the data of the message as a JSON string
     * @return string
     */
    public function asJson()
    {
        return json_encode(array(
            "url" => $this->url
        ));
    }

    public function process()
    {
        $base = 'http://www.cuongchan.com/kinh-nghiem/';
        $client = new \Guzzle\Http\Client($base);
        $url = str_replace($base, "", $this->url);
        echo "[Crawler] GET: $url\n";

        $request = $client->get($url);
        $response = $request->send();
        $crawler = new \Symfony\Component\DomCrawler\Crawler($response->getBody(true));

        $filter = $crawler->filter("li.list-post>article");
        if (iterator_count($filter) == 0) {
            //post content here
            $this->crawl_single_post($crawler->filter(".inner-post-entry"));
        } else {
            //post category here, iterate over items
            $filter->each(function ($content) {
                $this->crawl_category_items($content);
            });

            //category navigation
            $pagination = $crawler->filter(".older>a");
            if ($pagination->count() > 0) {
                WPPostScraperQueue::sendNewMessage(new WPPostScraperCrawler(array(
                    "url" => $pagination->attr("href")
                )));
            }
        }
    }

    /**
     * @param string|DomCrawler $content
     */
    private function crawl_category_items($content)
    {
        /**
         * @var DomCrawler $crawler
         */
        if (is_string($content))
            $crawler = new \Symfony\Component\DomCrawler\Crawler($content);
        else
            $crawler = $content;

        //get original post ID
        $original_id = $crawler->attr("id");
        if ($original_id != null)
            $original_id = str_replace("post-", "", $original_id);

        //get original post title and link
        $filter = $crawler->filter(".grid-title>a");

        $title = $filter->text();
        $link = $filter->attr("href");
        echo "[Crawler]: crawled with ID = $original_id, title = \"$title\"\n";

        $queue = WPPostScraperQueue::sendNewMessage(new WPPostScraperCrawler(array(
            "url" => $link
        )));
    }

    /**
     * @param string|DomCrawler $content
     */
    private function crawl_single_post($content)
    {
        /**
         * @var DomCrawler $crawler
         */
        if (is_string($content))
            $crawler = new \Symfony\Component\DomCrawler\Crawler($content);
        else
            $crawler = $content;

        $body = $crawler->filter('.inner-post-entry')->html();
        $body_length = strlen($body);
        echo "[Crawler]: body length = $body_length\n";
    }
}