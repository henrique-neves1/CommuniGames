<?php
return [
    'id' => 'app-common-tests',
    'basePath' => dirname(__DIR__),
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=communigames',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'user' => [
            'class' => \yii\web\User::class,
            'identityClass' => 'common\models\User',
        ],
    ],
];
