<?php

use app\components\ResponseBootstrap;
use app\models\Project;
use yii\caching\FileCache;
use yii\db\Connection;
use yii\gii\Module as DebugModule;
use yii\gii\Module as GiiModule;
use yii\log\FileTarget;
use yii\web\Response;

$config = [
    'id' => 'autopay-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        ResponseBootstrap::class
    ],
    'timeZone' => 'Asia/Tashkent',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
    ],
    'modules' => [
        'uzumbank' => [
            'class' => 'app\modules\uzumbank\Module',
            'defaultRoute' => 'config/index'
        ],
    ],
    'components' => [
//        'connection' => [
//            'class' => Connection::class,
//            'defaultSchema' => 'autopay',
//        ],
//        'autopay' => require __DIR__ . '/database/autopay.php',
        'request' => [
            'cookieValidationKey' => 'lKrRZmbffJfzxSudkdhejixHEgngfTgITOtLmolx',
            'baseUrl' => '',
            'enableCsrfValidation' => false,
            'enableCsrfCookie' => false
        ],
        'response' => [
            'class' => Response::class,
            'format' => Response::FORMAT_JSON,
        ],
        'user' => [
            'identityClass' => Project::class,
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null
        ],
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [],
        ],
    ],
    'params' => require __DIR__ . '/params/web.php',
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => DebugModule::class,
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => GiiModule::class,
    ];
}

return $config;
