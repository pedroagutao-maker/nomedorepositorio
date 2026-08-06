<?php

return [
    'host' => '127.0.0.1',
    'dbname' => 'pwrgenforce',
    'user' => 'root',
    'pass' => '',
    'charset' => 'utf8mb4',
];

function getDatabaseConnection(): PDO
{
    $config = require __DIR__ . '/database.php';
    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=%s',
        $config['host'],
        $config['dbname'],
        $config['charset']
    );

    return new PDO($dsn, $config['user'], $config['pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
}
