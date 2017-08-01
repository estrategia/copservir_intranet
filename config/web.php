<?php

$params = require(__DIR__ . '/params.php');
$modules = require(__DIR__ . '/modules.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'es',
    'bootstrap' => ['log'],
    'on beforeAction' => function ($event) {
        date_default_timezone_set('America/Bogota');
    },
    'modules' => $modules,
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        //'defaultRoles' => ['usuario'],
        ],
        'assetManager' => [
            'forceCopy' => true,
            'bundles' => [
                /* 'yii\web\JqueryAsset' => [
                  'js' => []
                  ], */
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
            'parsers' => [
              'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'loginUrl' => ['/intranet/usuario/autenticar'],
            'identityClass' => 'app\models\Usuario',
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
                'port' => '587',
                'encryption' => 'tls',
            ],
            /*'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'mailserver.copservir.com',
                'port' => '25',
                 //'username' => 'administradorPQRS@copservir.com',
                //'password' => 'K7521ch$',
            ]*/
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
                    'logFile' => '@runtime/logs/http-request.log',
                    'categories' => ['yii\httpclient\*'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['trace'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'logFile' => '@runtime/logs/profile.log',
                    'logVars' => [],
                    'levels' => ['profile'],
                    'categories' => ['yii\db\Command::query'],
                    'prefix' => function($message) {
                        return '';
                    }
                ]
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [

            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                'site/page/<view:\w+>' => 'site/page/',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',

                'proveedores/visitamedica/productos/producto/<codigoProducto:\d+>' => 'proveedores/visitamedica/productos/producto',
                'proveedores/visitamedica/reportes/acceso/<tiempo:\w+\-?\w+>' => 'proveedores/visitamedica/reportes/acceso',
                'proveedores/visitamedica/reportes/producto/<tiempo:\w+\-?\w+>' => 'proveedores/visitamedica/reportes/producto',

                'intranet/visitamedica/reportes' => 'intranet/visita-medica-reportes',
                'intranet/visitamedica/reportes/acceso/<tiempo:\w+\-?\w+>' => 'intranet/visita-medica-reportes/acceso',
                'intranet/visitamedica/reportes/producto/<tiempo:\w+\-?\w+>' => 'intranet/visita-medica-reportes/producto',

                'trademarketing/rest/observaciones/asignacion/<idAsignacion:\d+>/variable/<idVariable:\d+>' => 'trademarketing/rest/rest-observaciones/listar-observaciones',

                // REST
                [
                  'class' => 'yii\rest\UrlRule',
                  'controller' => [
                     'trademarketing/rest/rest-asignacion-punto-venta',
                     'trademarketing/rest/prueba',
                     'trademarketing/rest/rest-reporte',
                     'trademarketing/rest/rest-observaciones'
                  ],
                  'extraPatterns' => [
                    'GET informacion-reporte' => 'informacion-reporte',
                  ],
                  'pluralize'=>false,
                  'tokens' => [
                    '{id}' => '<id:\\w+>'
                  ],
                ],
            ],
        ],

    ],
    'defaultRoute' => '/copservir/sitio',
    'params' => $params,

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
