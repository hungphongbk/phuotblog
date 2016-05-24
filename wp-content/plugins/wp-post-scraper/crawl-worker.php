<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/17/16
 * Time: 11:08 AM
 */

$short_options = "k:";
$short_options .= "s:";
$short_options .= "r::";

$options = getopt($short_options);

require_once __DIR__ . '/config.php';

WPPostScraperQueue::setAwsCredentials(array(
    'region' => isset($options['r']) ? $options['r'] : 'ap-southeast-1',
    'credentials' => array(
        'key' => $options['k'],
        'secret' => $options['s']
    )
));
$queue = new WPPostScraperQueue(WPPS_QUEUE_NAME);
echo "MessageQueue initialized!\n";
while (true) {
    $message = $queue->receive();
    if ($message) {
        try {
            $message->process();
            $queue->delete($message);
        } catch (Exception $e) {
            $queue->release($message);
            echo $e->getMessage();
        }
    } else {
        // Wait 20 seconds if no jobs in queue to minimise requests to AWS API
        echo "Waiting for incoming message...\n";
        sleep(5);
    }
}