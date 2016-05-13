<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/13/16
 * Time: 6:15 PM
 */
use Guzzle\Http\Client;

class WPPostScraperCrawler
{
    private $baseUrl;

    /**
     * @var array
     */
    private static $instance;

    /**
     * @param string $url
     * @return WPPostScraperCrawler
     */
    public static function getInstance($url)
    {
        if (!self::$instance[$url])
            self::$instance[$url] = new static($url);
        return self::$instance[$url];
    }

    function __construct($clientUrl)
    {
        $this->baseUrl = $clientUrl;
        $this->client = new Client($this->baseUrl);
    }

    /**
     * @var \Guzzle\Http\Client
     */
    private $client;

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    public function crawl($url, $callback)
    {
        $response = $this->client->get($url)->send();

        return $callback(new \Symfony\Component\DomCrawler\Crawler($response->getBody(true)));
    }
}