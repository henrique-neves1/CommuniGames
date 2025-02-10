<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'api' => [
            'class' => 'backend\modules\api\ModuleAPI',
        ]
    ],
    'components' => [
        'mqtt' => [
            'class' => 'app\components\MqttComponent',
            'host' => 'mqtt.example.com',
            'port' => 1883,
            'username' => 'your-username',
            'password' => 'your-password',
            'clientId' => 'Yii2Client_' . uniqid(),
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule','controller' => 'api/game',
                    'extraPatterns' => [
                        'GET names' => 'names',
                        'GET prices' => 'prices',
                        'GET count' => 'count',
                        'GET {id}/name' => 'namebyid',
                        'GET {id}/price' => 'pricebyid',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/user','pluralize' => false,
                    'extraPatterns' => [
                        'GET usernames' => 'usernames',
                        'GET {id}/username' => 'usernamebyid',
                        'GET count' => 'count',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/profile',
                    'extraPatterns' => [
                        'GET names' => 'names',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/cart','pluralize' => false,
                    'extraPatterns' => [
                        'GET {id}' => 'databyid',
                        'GET profile/{profile_id}' => 'databyprofile',
                        'POST profile/{profile_id}/game/{game_id}' => 'add',
                        'PUT {id}/quantity/{quantity}' => 'updatequantity',
                        'DELETE {id}' => 'removeitem'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\d+>',
                        '{profile_id}' => '<profile_id:\\d+>',
                        '{game_id}' => '<game_id:\\d+>',
                        '{quantity}' => '<quantity:\\d+>'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule', 'controller' => 'api/chatbot','pluralize' => false,
                    'extraPatterns' => [
                        'GET eco/{param}' => 'eco',
                    ],
                    'tokens' => [
                        '{param}' => '<param:>',
                    ]
                ]
            ],
        ],
    ],
    'params' => $params,
];
