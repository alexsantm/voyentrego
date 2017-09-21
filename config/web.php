<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'es',
    'timeZone' => 'America/Guayaquil',
    'name'=>'VoyEntrego',
    'components' => [
//        'view' => [
//         'theme' => [
//             'pathMap' => [
//                '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//             ],
//         ],
//    ],
        
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qY5E5eAMZ7Ih1RGojlDkIs8WbJjhA2Fx',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//        ],
        
         'user' => [
            'class' => 'amnah\yii2\user\components\User',
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            // send all mails to a file by default. You have to set
//            // 'useFileTransport' to false and configure a transport
//            // for the mailer to send real emails.
//            'useFileTransport' => true,
//        ],
//         'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'useFileTransport' => false,
//            //'viewPath' => '@app/mail',
//            'viewPath' => '@app/mail',
//            'messageConfig' => [
//                'from' => 'soporte@qariston.com' // sender address goes here
//            ],
//            'transport' => [
//                'class' => 'Swift_SmtpTransport',
//                'host' => '192.168.0.254',
//                'username' => 'informatica',
//                'password' => 'INFORMATICA2017**',
//                'port' => '25',
//            ],
//        ],
                'mailer' => [
        'class' => 'yii\swiftmailer\Mailer',
        'messageConfig' => [
                'from' => 'alexsantm@gmail.com' // sender address goes here
            ],    
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.gmail.com',
            'username' => 'alexsantm@gmail.com',
            'password' => 'enblanco2016.',
            'port' => '587',
            'encryption' => 'tls',
        ],
    ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
          'urlManager' => [
            'class' => 'yii\web\UrlManager', //clase UrlManager
            'showScriptName' => false, //eliminar index.php
            'enablePrettyUrl' => true, //urls amigables   
            'enableStrictParsing' => false,
          'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
    ],
    
        'modules' => [
        'user' => [
            'class' => 'amnah\yii2\user\Module',
            // set custom module properties here ...
        ],
         'api' => [
            'class' => 'app\modules\api\api',
        ],    
            
    ],
    
    
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
