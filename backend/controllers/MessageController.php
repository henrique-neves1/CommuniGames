<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use PhpMqtt\Client\MqttClient;
class MessageController extends Controller
{
    public function actionIndex()
    {
        $users = \common\models\User::find()->all();
        return $this->render('index', ['users' => $users]);
    }

    public function actionSend()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $username = Yii::$app->request->post('username');
        $message = Yii::$app->request->post('message');

        if (!$username) {
            return ["status" => "error", "message" => "No user selected."];
        }

        if (!$message) {
            return ["status" => "error", "message" => "Message is empty."];
        }
        try {
            $mqtt = new MqttClient("127.0.0.1", 1883, 'admin');
            $mqtt->connect();
            $mqtt->publish($username, "admin: $message", 0);
            $mqtt->disconnect();

            return ["status" => "success"];
        } catch (\Exception $e) {
            return ["status" => "error", "message" => $e->getMessage()];
        }
    }
}