<?php

use yii\caching\FileCache;
use yii\log\FileTarget;

$config = [
    'id' => 'autopay-api-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'timeZone' => 'Asia/Tashkent',
    'controllerNamespace' => 'app\commands',
    'aliases' => [],
    'components' => [
        'db' => require __DIR__ . '/database/autopay.php',
        'cache' => [
            'class' => FileCache::class,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
    ],
    'params' => require __DIR__ . '/params/console.php',
];

return $config;
