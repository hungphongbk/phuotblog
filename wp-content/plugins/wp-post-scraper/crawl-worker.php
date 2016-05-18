<?php
/**
 * Created by PhpStorm.
 * User: hungphongbk
 * Date: 5/17/16
 * Time: 11:08 AM
 */

require_once __DIR__ . '/config.php';

$queue = new WPPostScraperQueue(WPPS_QUEUE_NAME, array(
    'region' => 'ap-southeast-1',
    'credentials' => array(
        'key' => AWS_ACCESS_KEY_ID,
        'secret' => AWS_SECRET_ACCESS_KEY
    )
));
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