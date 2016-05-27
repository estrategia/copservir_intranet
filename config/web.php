<?php

$params = require(__DIR__ . '/params.php');
$modulos = require(__DIR__ . '/modulos.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'es',
    'bootstrap' => ['log'],
    'components' => [
      'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'bundles' => [
                /*'yii\web\JqueryAsset' => [
                    'js' => []
                ],*/
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'h8pmv7opsbl15jp5q81qr11r42',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\intranet\models\Usuario',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'intranet/sitio/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'servidor.correo.msanchez@gmail.com',
                'password' => 'c0rr30*-*',
                //'host' => 'mailserver.copservir.com',
                //'username' => 'administradorPQRS@copservir.com',
                //'password' => 'K7521ch$',
                'port' => '587',
                //'port' => '25',
                'encryption' => 'tls',
            ]
        ],
        
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error'],
                    'categories' => ['application'],
                    'logFile' => '@app/runtime/logs/app_error.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 50,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['warning'],
                    'categories' => ['application'],
                    'logFile' => '@app/runtime/logs/app_warning.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['application'],
                    'logFile' => '@app/runtime/logs/app_info.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace'],
                ],
            ],
        ],
        /*'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],*/
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [

            //'urlFormat' => 'path',
            'showScriptName' => false,
            //'caseSensitive' => true,
            'enablePrettyUrl' => true,
            'rules' => [
                'site/page/<view:\w+>' => 'site/page/',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'defaultRoute' => 'sitio/index',
    'params' => $params,
    'modules' => [
        'intranet' => [
            'class' => 'app\modules\intranet\IntranetModule',
        ],
        'proveedores' => [
            'class' => 'app\modules\proveedores\ProveedoresModule',
        ],
        'convenios' => [
            'class' => 'app\modules\convenios\ConveniosModule',
        ],
        'coopservir' => [
            'class' => 'app\modules\coopservir\CoopservirModule',
        ],
        'treemanager' => [
            'class' => '\kartik\tree\Module',
        // other module settings, refer detailed documentation
        ]
    /* 'gridview' => [
      //'class' => '\kartik\grid\Module',
      //'downloadAction' => '',
      ] */
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
