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
//    'layoutPath'=>'@app/themes/adminLTE/layouts',
    'components' => [
//        'view' => [
//         'theme' => [
//             'pathMap' => [
//                '@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
//             ],
//         ],
//    ],
        
        'braintree' => [
        'class' => 'tuyakhov\braintree\Braintree',
        'merchantId' => 'yqj4sysgyvmjp28b',
        'publicKey' => 'wz9qxg3n9qqmff6s',
        'privateKey' => '3e659e792b856fcb77a6e22b0a3737de',
    ],
        
        
         'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8',
                        'libraries' => 'places',
                        'v' => '3.exp',
                        'sensor'=> 'false'
                    ]
                ]
            ]
        ],
        'googleApi'   => [
            'class'             => 'quexer\googleapi\GoogleApiLibrary',

            // API Keys !!!
            'staticmap_api_key' => 'AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8',
            'geocode_api_key'   => 'AIzaSyDpBQgBTtXqWdWIbJDvKrqO-g5_CvSlaS8',

            // Set basePath
            'webroot'           => '@webroot',

            // Image path and map iframe settings
//            'map_image_path'    => '/images/google_map',
            'map_type'          => 'terrain',
            'map_size'          => '520x350',
            'map_sensor'        => false,
            'map_zoom'          => 9,
            'map_scale'         => 1,
            'map_marker_color'  => 'red',
            'map_iframe_width'  => '100%', // %, px, em
            'map_iframe_height' => '500px',  // %, px, em
            'map_language'        => 'de',

            // Debug
            'quiet'             => false
        ],
        
        
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
            
           'gridview' =>  [
        'class' => '\kartik\grid\Module'
        // enter optional module parameters below - only if you need to  
        // use your own export download action or custom translation 
        // message source
        // 'downloadAction' => 'gridview/export/download',
        // 'i18n' => []
    ]    
            
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
