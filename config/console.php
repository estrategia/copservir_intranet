<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

return [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'gii'],
    'controllerNamespace' => 'app\commands',
    'on beforeAction' => function ($event) {
        date_default_timezone_set('America/Bogota');
    },
    'modules' => [
        'gii' => 'yii\gii\Module',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['application'],
                    'logFile' => '@app/runtime/logs/console_error.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 50,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'categories' => ['application'],
                    'logFile' => '@app/runtime/logs/console_warning.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['application'],
                    'logFile' => '@app/runtime/logs/console_info.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/console_profile.log',
                    'logVars' => [],
                    'levels' => ['profile'],
                    'categories' => ['yii\db\Command::query'],
                    'prefix' => function($message) {
                    return '';
                    }
                ]
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
];
