<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Junges\Kafka\Producers\Producer;

class KafkaController extends Controller
{

    public function sendMessages()
    {
        $config = ProducerConfig::getInstance();
        $config->setMetadataRefreshIntervalMs(10000);
        $config->setMetadataBrokerList('localhost:9092');
        $config->setBrokerVersion('2.6.0');
        $config->setRequiredAck(1);
        $config->setIsAsyn(false);
        $config->setProduceInterval(500);

        $producer = new Producer();
        $producer->setRequireAck(ProduceRequest::ACK_LOCAL_WRITE);
        $producer->setMessages(1000);

        $topic = 'my_topic';
        $message = 'Hello, Kafka!';

        for ($i = 1; $i <= 1000; $i++) {
            $producer->send([
                [
                    'topic' => $topic,
                    'value' => $message . ' ' . $i,
                ],
            ]);
        }

        return "Sent 1000 messages to Kafka successfully!";
    }


}
