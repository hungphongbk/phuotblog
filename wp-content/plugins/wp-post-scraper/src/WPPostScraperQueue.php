<?php

/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/17/16
 * Time: 10:50 AM
 */
class WPPostScraperQueue
{

    private $name;

    private $url;

    //private $aws_credentials;

    private $sqs_client;

    private static $aws_credentials;

    /**
     * @return mixed
     */
    protected static function getAwsCredentials()
    {
        return self::$aws_credentials;
    }

    /**
     * @param mixed $aws_credentials
     */
    public static function setAwsCredentials($aws_credentials)
    {
        self::$aws_credentials = $aws_credentials;
    }

    /**
     * WPPostScraperQueue constructor.
     * @param $name
     */
    public function __construct($name)
    {
        try {
            $this->name = $name;

            $this->sqs_client = \Aws\Sqs\SqsClient::factory(static::getAwsCredentials());

            $this->url = $this->sqs_client->getQueueUrl(array(
                "QueueName" => $this->name
            ))->get("QueueUrl");
        } catch (Exception $e) {
            echo "Error getting the queue Url: " . ($e->getMessage()) . "\n";
        }
    }

    /**
     * @param WPPostScraperCrawler $message
     * @return bool
     */
    public function send(WPPostScraperCrawler $message)
    {
        try {
            $this->sqs_client->sendMessage(array(
                "QueueUrl" => $this->url,
                "MessageBody" => $message->asJson()
            ));
        } catch (Exception $ex) {
            echo "Error sending crawl message to queue: " . $ex->getMessage();
            return false;
        }
        return true;
    }

    /**
     * @return bool|WPPostScraperCrawler
     */
    public function receive()
    {
        try {
            $result = $this->sqs_client->receiveMessage(array(
                "QueueUrl" => $this->url
            ));

            if (empty($result['Messages'])) return false;

            $num = count($result['Messages']);
            $result_message = $result['Messages'][$num - 1];
            return new WPPostScraperCrawler($result_message['Body'], $result_message['ReceiptHandle']);
        } catch (Exception $e) {
            echo 'Error receiving crawl message from queue ' . $e->getMessage();
            return false;
        }
    }

    public function delete(WPPostScraperCrawler $message)
    {
        try {
            $this->sqs_client->deleteMessage(array(
                "QueueUrl" => $this->url,
                "ReceiptHandle" => $message->receipt_handle
            ));

            return true;
        } catch (Exception $e) {
            echo 'Error deleting crawl message from queue ' . $e->getMessage();
            return false;
        }
    }

    public function release(WPPostScraperCrawler $message)
    {
        try {
            $this->sqs_client->changeMessageVisibility(array(
                "QueueUrl" => $this->url,
                "ReceiptHandle" => $message->receipt_handle,
                "VisibilityTimeout" => 0
            ));

            return true;
        } catch (Exception $e) {
            echo 'Error releasing job back to queue ' . $e->getMessage();
            return false;
        }
    }

    /**
     * @param WPPostScraperCrawler $message
     */
    public static function sendNewMessage($message)
    {
        $queue = new WPPostScraperQueue(WPPS_QUEUE_NAME);
        $queue->send($message);
    }
}