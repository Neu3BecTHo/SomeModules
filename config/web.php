<?php

use yii\web\DbSession;

// Load environment variables from .env file
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

$params = require __DIR__ . '/params.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/yidas/yii2-bower-asset/bower',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'modules' => [
        'communal' => [
            'class' => 'app\modules\communal\Module',
        ],
        'adminCommunal' => [
            'class' => 'app\modules\communal\modules\adminCommunal\Module',
        ],
        'personnelDepartment' => [
            'class' => 'app\modules\personnelDepartment\Module',
        ],
        'adminPersonnelDepartment' => [
            'class' => 'app\modules\personnelDepartment\modules\adminPersonnelDepartment\Module',
        ],
        'tours' => [
            'class' => 'app\modules\tours\Module',
        ],
        'adminTours' => [
            'class' => 'app\modules\tours\modules\adminTours\Module',
        ],
        'boardwalk' => [
            'class' => 'app\modules\boardwalk\Module',
        ],
        'adminBoardwalk' => [
            'class' => 'app\modules\boardwalk\modules\adminBoardwalk\Module',
        ],
        'cleaner' => [
            'class' => 'app\modules\cleaner\Module',
        ],
        'adminCleaner' => [
            'class' => 'app\modules\cleaner\modules\adminCleaner\Module',
        ],
        'breadHouse' => [
            'class' => 'app\modules\breadHouse\Module',
        ],
        'adminBreadHouse' => [
            'class' => 'app\modules\breadHouse\modules\adminBreadHouse\Module',
        ],
        'beauty' => [
            'class' => 'app\modules\beauty\Module',
        ],
        'adminBeauty' => [
            'class' => 'app\modules\beauty\modules\adminBeauty\Module',
        ],
        'photoshoot' => [
            'class' => 'app\modules\photoshoot\Module',
        ],
        'adminPhotoshoot' => [
            'class' => 'app\modules\photoshoot\modules\adminPhotoshoot\Module',
        ],
    ],
    'components' => [
        'securityHeaders' => [
            'class' => 'app\components\SecurityHeadersBootstrap',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'cache' => 'cache'
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => function() {
                $key = $_ENV['COOKIE_VALIDATION_KEY'] ?? '';
                if ($key === '') {
                    throw new \yii\base\InvalidConfigException('COOKIE_VALIDATION_KEY environment variable is required');
                }
                return $key;
            }(),
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'userCommunal' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\communal\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['communal/auth/login'],
            'idParam' => '__communalUser',
            'identityCookie' => ['name' => '_communalIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'userBoardwalk' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\boardwalk\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['boardwalk/auth/login'],
            'idParam' => '__boardwalkUser',
            'identityCookie' => ['name' => '_boardwalkIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'userPersonnelDepartment' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\personnelDepartment\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['personnelDepartment/auth/login'],
            'idParam' => '__personnelDepartmentUser',
            'identityCookie' => ['name' => '_personnelDepartmentIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'userTours' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\tours\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['tours/auth/login'],
            'idParam' => '__toursUser',
            'identityCookie' => ['name' => '_toursIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'userCleaner' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\cleaner\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['cleaner/auth/login'],
            'idParam' => '__cleanerUser',
            'identityCookie' => ['name' => '_cleanerIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'userBreadHouse' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\breadHouse\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['breadHouse/auth/login'],
            'idParam' => '__breadHouseUser',
            'identityCookie' => ['name' => '_breadHouseIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'userBeauty' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\beauty\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['beauty/auth/login'],
            'idParam' => '__beautyUser',
            'identityCookie' => ['name' => '_beautyIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'userPhotoshoot' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\modules\photoshoot\models\User',
            'enableAutoLogin' => true,
            'loginUrl' => ['photoshoot/auth/login'],
            'idParam' => '__photoshootUser',
            'identityCookie' => ['name' => '_photoshootIdentity', 'httpOnly' => true, 'secure' => !YII_ENV_DEV],
        ],
        'session' => [
            'class' => DbSession::class,
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'forceCopy' => YII_DEBUG,
            'bundles' => [
            // Переопределяем бандл маски
            'yii\widgets\MaskedInputAsset' => [
                'sourcePath' => null, // отключаем публикацию из вендора
                'baseUrl' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8', // берем с CDN
                'js' => [
                    'jquery.inputmask.min.js',
                ],
            ],
        ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            'useFileTransport' => ($_ENV['MAILER_USE_FILE_TRANSPORT'] ?? 'false') === 'true',
            'transport' => [
                'scheme' => $_ENV['MAILER_TRANSPORT_SCHEME'] ?? 'smtps',
                'host' => $_ENV['MAILER_HOST'] ?? 'smtp.gmail.com',
                'username' => $_ENV['MAILER_USERNAME'] ?? '',
                'password' => $_ENV['MAILER_PASSWORD'] ?? '',
                'port' => (int)($_ENV['MAILER_PORT'] ?? 465),
                'options' => [
                    'ssl' => [
                        'allow_self_signed' => ($_ENV['MAILER_SSL_ALLOW_SELF_SIGNED'] ?? 'false') === 'true',
                        'verify_peer' => ($_ENV['MAILER_SSL_VERIFY_PEER'] ?? 'true') !== 'false',
                        'verify_peer_name' => ($_ENV['MAILER_SSL_VERIFY_PEER_NAME'] ?? 'true') !== 'false',
                    ],
                ],
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
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'pgsql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
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
            'dsn' => 'mysql:host=' . ($_ENV['DB_HOST'] ?? 'localhost') . ';dbname=' . ($_ENV['DB_NAME'] ?? 'belonogova'),
            'username' => $_ENV['DB_USER'] ?? 'root',
            'password' => $_ENV['DB_PASSWORD'] ?? 'root',
            'charset' => $_ENV['DB_CHARSET'] ?? 'utf8',
            'tablePrefix' => 'photoshoot_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 60,
            'schemaCache' => 'cache',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',
                'communal' => 'communal/main/index',
                'communal/login' => 'communal/auth/login',
                'communal/register' => 'communal/auth/register',
                'communal/logout' => 'communal/auth/logout',
                'communal/profile' => 'communal/profile/index',
                'communal/requests' => 'communal/request/index',
                'communal/request/create' => 'communal/request/create',
                'communal/admin' => 'adminCommunal/request/index',

                'personnel' => 'personnelDepartment/main/index',
                'personnel/login' => 'personnelDepartment/auth/login',
                'personnel/register' => 'personnelDepartment/auth/register',
                'personnel/logout' => 'personnelDepartment/auth/logout',
                'personnel/profile' => 'personnelDepartment/profile/index',
                'personnel/questionnaires' => 'personnelDepartment/questionnaires/index',
                'personnel/admin' => 'adminPersonnelDepartment/questionnaires/index',

                'tours' => 'tours/main/index',
                'tours/privacy' => 'tours/main/privacy',
                'tours/contacts' => 'tours/main/contacts',
                'tours/login' => 'tours/auth/login',
                'tours/register' => 'tours/auth/register',
                'tours/logout' => 'tours/auth/logout',
                'tours/tours' => 'tours/tours/index',
                'tours/tours/create' => 'tours/tours/create',
                'tours/tours/update/<id\+d>' => 'tours/tours/update',
                'tours/tours/delete/<id\+d>' => 'tours/tours/delete',
                'tours/requests' => 'tours/requests/index',
                'tours/requests/create' => 'tours/requests/create',
                'tours/requests/update/<id\+d>' => 'tours/requests/update',
                'tours/requests/delete/<id\+d>' => 'tours/requests/delete',
                'tours/admin' => 'adminTours/requests/index',
                'tours/admin/users' => 'adminTours/users/index',
                'tours/admin/tours' => 'adminTours/tours/index',
                'tours/admin/requests' => 'adminTours/requests/index',

                'boardwalk' => 'boardwalk/main/index',
                'boardwalk/login' => 'boardwalk/auth/login',
                'boardwalk/register' => 'boardwalk/auth/register',
                'boardwalk/logout' => 'boardwalk/auth/logout',
                'boardwalk/booking' => 'boardwalk/booking/index',
                'boardwalk/booking/create' => 'boardwalk/booking/create',
                'boardwalk/requests' => 'boardwalk/requests/index',
                'boardwalk/requests/create' => 'boardwalk/requests/create',
                'boardwalk/review' => 'boardwalk/requests/review',
                'boardwalk/admin' => 'adminBoardwalk/requests/index',

                'cleaner' => 'cleaner/main/index',
                'cleaner/login' => 'cleaner/auth/login',
                'cleaner/register' => 'cleaner/auth/register',
                'cleaner/logout' => 'cleaner/auth/logout',
                'cleaner/orders' => 'cleaner/orders/index',
                'cleaner/orders/create' => 'cleaner/orders/create',
                'cleaner/admin' => 'adminCleaner/orders/index',
                'cleaner/admin/statistics' => 'adminCleaner/orders/statistics',

                'breadHouse' => 'breadHouse/main/index',
                'breadHouse/login' => 'breadHouse/auth/login',
                'breadHouse/register' => 'breadHouse/auth/register',
                'breadHouse/logout' => 'breadHouse/auth/logout',
                'breadHouse/orders' => 'breadHouse/orders/index',
                'breadHouse/orders/create' => 'breadHouse/orders/create',
                'breadHouse/profile' => 'breadHouse/profile/index',
                'breadHouse/cart' => 'breadHouse/cart/index',
                'breadHouse/catalog' => 'breadHouse/catalog/index',
                'breadHouse/product/<id:\d+>' => 'breadHouse/product/view',
                'breadHouse/checkout' => 'breadHouse/checkout/index',
                'breadHouse/admin' => 'adminBreadHouse/default/index',
                'breadHouse/admin/products' => 'adminBreadHouse/product/index',
                'breadHouse/admin/products/create' => 'adminBreadHouse/product/create',
                'breadHouse/admin/products/update/<id:\d+>' => 'adminBreadHouse/product/update',
                'breadHouse/admin/products/delete/<id:\d+>' => 'adminBreadHouse/product/delete',
                'breadHouse/admin/categories' => 'adminBreadHouse/category/index',
                'breadHouse/admin/categories/create' => 'adminBreadHouse/category/create',
                'breadHouse/admin/categories/update/<id:\d+>' => 'adminBreadHouse/category/update',
                'breadHouse/admin/categories/delete/<id:\d+>' => 'adminBreadHouse/category/delete',
                'breadHouse/admin/orders' => 'adminBreadHouse/order/index',
                'breadHouse/admin/orders/view/<id:\d+>' => 'adminBreadHouse/order/view',
                'breadHouse/admin/orders/view' => 'adminBreadHouse/order/view',
                'breadHouse/admin/orders/update-status/<id:\d+>' => 'adminBreadHouse/order/update-status',
                'breadHouse/admin/categories/view/<id:\d+>' => 'adminBreadHouse/category/view',
                'breadHouse/admin/users' => 'adminBreadHouse/user/index',
                'breadHouse/admin/users/view/<id:\d+>' => 'adminBreadHouse/user/view',
                'breadHouse/admin/users/toggle-admin/<id:\d+>' => 'adminBreadHouse/user/toggle-admin',

                'beauty' => 'beauty/main/index',
                'beauty/catalog' => 'beauty/main/catalog',
                'beauty/service/<id:\d+>' => 'beauty/main/service',
                'beauty/master/<id:\d+>' => 'beauty/main/master',
                'beauty/book' => 'beauty/main/book',
                'beauty/about' => 'beauty/main/about',
                'beauty/contacts' => 'beauty/main/contacts',
                'beauty/login' => 'beauty/auth/login',
                'beauty/register' => 'beauty/auth/register',
                'beauty/logout' => 'beauty/auth/logout',
                'beauty/profile' => 'beauty/profile/index',
                'beauty/orders' => 'beauty/orders/index',
                'beauty/orders/view/<id:\d+>' => 'beauty/orders/view',
                'beauty/orders/review/<id:\d+>' => 'beauty/orders/review',
                'beauty/orders/cancel/<id:\d+>' => 'beauty/orders/cancel',
                'beauty/admin' => 'adminBeauty/admin/index',
                'beauty/admin/dashboard' => 'adminBeauty/admin/index',
                'beauty/admin/default/index' => 'adminBeauty/default/index',
                'beauty/admin/default' => 'adminBeauty/default/index',
                
                // Master Cabinet Routes
                'beauty/admin/master-cabinet' => 'adminBeauty/master-cabinet/index',
                'beauty/admin/master-cabinet/profile' => 'adminBeauty/master-cabinet/profile',
                'beauty/admin/master-cabinet/services' => 'adminBeauty/master-cabinet/services',
                'beauty/admin/master-cabinet/services/delete/<id:\d+>' => 'adminBeauty/master-cabinet/delete-service',
                'beauty/admin/master-cabinet/schedule' => 'adminBeauty/master-cabinet/schedule',
                'beauty/admin/master-cabinet/gallery' => 'adminBeauty/master-cabinet/gallery',
                'beauty/admin/master-cabinet/gallery/delete' => 'adminBeauty/master-cabinet/delete-photo',
                'beauty/admin/master-cabinet/certificates' => 'adminBeauty/master-cabinet/certificates',
                'beauty/admin/master-cabinet/certificates/delete' => 'adminBeauty/master-cabinet/delete-certificate',
                'beauty/admin/master-cabinet/orders' => 'adminBeauty/master-cabinet/orders',
                'beauty/admin/master-cabinet/orders/view/<id:\d+>' => 'adminBeauty/master-cabinet/view-order',
                'beauty/admin/master-cabinet/orders/update-status/<id:\d+>/<status:\w+>' => 'adminBeauty/master-cabinet/update-order-status',
                
                // Admin Panel Routes
                'beauty/admin/users' => 'adminBeauty/admin/users',
                'beauty/admin/users/view/<id:\d+>' => 'adminBeauty/admin/view-user',
                'beauty/admin/users/edit/<id:\d+>' => 'adminBeauty/admin/edit-user',
                'beauty/admin/users/delete/<id:\d+>' => 'adminBeauty/admin/delete-user',
                
                'beauty/admin/masters' => 'adminBeauty/admin/masters',
                'beauty/admin/masters/view/<id:\d+>' => 'adminBeauty/admin/view-master',
                'beauty/admin/masters/approve/<id:\d+>' => 'adminBeauty/admin/approve-master',
                'beauty/admin/masters/reject/<id:\d+>' => 'adminBeauty/admin/reject-master',
                'beauty/admin/masters/delete/<id:\d+>' => 'adminBeauty/admin/delete-master',
                
                'beauty/admin/services' => 'adminBeauty/admin/services',
                'beauty/admin/services/create' => 'adminBeauty/admin/create-service',
                'beauty/admin/services/edit/<id:\d+>' => 'adminBeauty/admin/edit-service',
                'beauty/admin/services/delete/<id:\d+>' => 'adminBeauty/admin/delete-service',
                'beauty/admin/services/masters/<id:\d+>' => 'adminBeauty/admin/service-masters',
                
                'beauty/admin/categories' => 'adminBeauty/admin/categories',
                'beauty/admin/categories/create' => 'adminBeauty/admin/create-category',
                'beauty/admin/categories/edit/<id:\d+>' => 'adminBeauty/admin/edit-category',
                'beauty/admin/categories/delete/<id:\d+>' => 'adminBeauty/admin/delete-category',
                
                'beauty/admin/orders' => 'adminBeauty/admin/orders',
                'beauty/admin/orders/view/<id:\d+>' => 'adminBeauty/admin/view-order',
                'beauty/admin/orders/update-status/<id:\d+>/<status:\w+>' => 'adminBeauty/admin/update-order-status',
                
                'beauty/admin/reviews' => 'adminBeauty/admin/reviews',
                'beauty/admin/reviews/toggle/<id:\d+>' => 'adminBeauty/admin/toggle-review',
                'beauty/admin/reviews/delete/<id:\d+>' => 'adminBeauty/admin/delete-review',
                
                'beauty/admin/reports' => 'adminBeauty/admin/reports',

                'photoshoot' => 'photoshoot/main/index',
                'photoshoot/about' => 'photoshoot/main/about',
                'photoshoot/services' => 'photoshoot/main/services',
                'photoshoot/gallery' => 'photoshoot/main/gallery',
                'photoshoot/news' => 'photoshoot/main/news',
                'photoshoot/contacts' => 'photoshoot/main/contacts',
                'photoshoot/login' => 'photoshoot/auth/login',
                'photoshoot/register' => 'photoshoot/auth/register',
                'photoshoot/logout' => 'photoshoot/auth/logout',
                'photoshoot/booking' => 'photoshoot/booking/index',
                'photoshoot/booking/create' => 'photoshoot/booking/create',
                'photoshoot/booking/view/<id:\d+>' => 'photoshoot/booking/view',
                'photoshoot/booking/cancel/<id:\d+>' => 'photoshoot/booking/cancel',
                'photoshoot/booking/review/<id:\d+>' => 'photoshoot/booking/review',
                'photoshoot/profile' => 'photoshoot/profile/index',
                'photoshoot/admin' => 'adminPhotoshoot/booking/index',
                'photoshoot/admin/bookings' => 'adminPhotoshoot/booking/index',
                'photoshoot/admin/bookings/view/<id:\d+>' => 'adminPhotoshoot/booking/view',
                'photoshoot/admin/users' => 'adminPhotoshoot/users/index',
                'photoshoot/admin/users/toggle-admin/<id:\d+>' => 'adminPhotoshoot/users/toggle-admin',
            ],
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => '                                                                                         