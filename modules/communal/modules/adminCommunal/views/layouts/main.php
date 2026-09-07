<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use yii\bootstrap5\Breadcrumbs;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title>Админ-панель | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        /* Минимальные стили для отличия админки */
        body { background-color: #f8f9fa; color: #333; }
        .admin-navbar { background-color: #343a40 !important; }
        .admin-footer { background-color: #e9ecef; color: #6c757d; }
        .admin-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => 'Portal.Zhkh [ADMIN]',
        'brandUrl' => ['request/index'],
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark admin-navbar fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => [
            ['label' => 'Заявки', 'url' => ['request/index']],
            ['label' => 'На сайт', 'url' => ['/communal/main/index']], // Выход в клиентскую часть
            ['label' => 'Выход', 'url' => ['/communal/auth/logout'], 'linkOptions' => ['data-method' => 'post']],
        ],
    ]);
    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container" style="padding-top: 80px;">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => ['label' => 'Админ-панель', 'url' => ['request/index']],
        ]) ?>
        <?= Alert::widget() ?>
        
        <div class="admin-card">
            <?= $content ?>
        </div>
    </div>
</main>

<footer class="footer mt-auto py-3 admin-footer">
    <div class="container">
        <span class="text-muted">&copy; ЖКХ Портал <?= date('Y') ?> [Панель администратора]</span>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
