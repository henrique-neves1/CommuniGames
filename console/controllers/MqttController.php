<?php

namespace console\controllers;

use yii\console\Controller;

class MqttController extends Controller
{
    public function actionPublish()
    {
        $mqtt = \Yii::$app->mqtt;

        $topic = 'test/topic';
        $message = 'Hello, MQTT!';

        $mqtt->publish($topic, $message);

        return 'Message published to ' . $topic;
    }

    public function actionSubscribe()
    {
        $mqtt = \Yii::$app->mqtt;

        $topic = 'test/topic';
        $mqtt->subscribe($topic, function ($topic, $message) {
            echo sprintf('Received message on topic [%s]: %s', $topic, $message);
        });

        $mqtt->loop(true);
    }
}