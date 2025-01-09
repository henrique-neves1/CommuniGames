<?php
namespace app\components;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\Exceptions\MqttClientException;

class MqttComponent extends \yii\base\Component
{
    public $host;
    public $port;
    public $username;
    public $password;
    public $clientId;

    private $client;

    public function init()
    {
        parent::init();
        try {
            $this->client = new MqttClient($this->host, $this->port, $this->clientId);
            $this->client->connect($this->username, $this->password);
        } catch (MqttClientException $e) {
            \Yii::error('Failed to connect to MQTT broker: ' . $e->getMessage());
        }
    }

    public function publish($topic, $message, $qos = 0, $retain = false)
    {
        try {
            $this->client->publish($topic, $message, $qos, $retain);
        } catch (MqttClientException $e) {
            \Yii::error('Failed to publish message: ' . $e->getMessage());
        }
    }

    public function subscribe($topic, callable $callback, $qos = 0)
    {
        try {
            $this->client->subscribe($topic, $callback, $qos);
        } catch (MqttClientException $e) {
            \Yii::error('Failed to subscribe to topic: ' . $e->getMessage());
        }
    }

    public function __destruct()
    {
        if ($this->client !== null) {
            $this->client->disconnect();
        }
    }
}
?>