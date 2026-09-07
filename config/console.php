<?php

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@tests' => '@app/tests',
    ],
    'components' => [
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => '',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'communal' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'comm_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'personnelDepartment' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'pers_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'boardwalk' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'board_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'tours' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'tour_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'cleaner' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'cleaner_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'breadHouse' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'bh_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'beauty' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'beauty_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        'photoshoot' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'photoshoot_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
    ],
    'params' => $params,
    'controllerMap' => [
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'db',
            'migrationPath' => [
                '@app/migrations',
                '@yii/rbac/migrations',
            ],
        ],
        'migrate-tours' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'tours',
            'migrationPath' => [
                '@app/modules/tours/migrations',
            ],
        ],
        'migrate-personnel' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'personnelDepartment',
            'migrationPath' => [
                '@app/modules/personnelDepartment/migrations',
            ],
        ],
        'migrate-communal' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'communal',
            'migrationPath' => [
                '@app/modules/communal/migrations',
            ],
        ],
        'migrate-boardwalk' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'boardwalk',
            'migrationPath' => [
                '@app/modules/boardwalk/migrations',
            ],
        ],
        'migrate-cleaner' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'cleaner',
            'migrationPath' => [
                '@app/modules/cleaner/migrations',
            ],
        ],
        'migrate-breadHouse' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'breadHouse',
            'migrationPath' => [
                '@app/modules/breadHouse/migrations',
            ],
        ],
        'migrate-beauty' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'beauty',
            'migrationPath' => [
                '@app/modules/beauty/migrations',
            ],
        ],
        'migrate-photoshoot' => [
            'class' => 'yii\console\controllers\MigrateController',
            'db' => 'photoshoot',
            'migrationPath' => [
                '@app/modules/photoshoot/migrations',
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
    // configuration adjustments for 'dev' environment
    // requires version `2.1.21` of yii2-debug module
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
