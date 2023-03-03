<?php

use yii\db\Connection;

return [
    'class' => Connection::class,
    'dsn' => "mysql:host={$_ENV['AUTOPAY_DB_HOST']};dbname={$_ENV['AUTOPAY_DB_NAME']}",
    'username' => $_ENV['AUTOPAY_DB_USER'],
    'password' => $_ENV['AUTOPAY_DB_PASS'],
    'charset' => 'utf8mb4',
];