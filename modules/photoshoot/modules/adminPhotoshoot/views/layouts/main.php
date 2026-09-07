<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;
use app\modules\photoshoot\assets\PhotoshootAsset;

PhotoshootAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?> - Админ-панель</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '«Мои истории» - Админ',
        'brandUrl' => ['/adminPhotoshoot/booking/index'],
        'options' => [
            'class' => 'navbar-expand-lg navbar-dark bg-dark',
        ],
        'innerContainerOptions' => ['class' => 'container-fluid'],
    ]);

    $menuItems = [
        ['label' => 'Бронирования', 'url' => ['/adminPhotoshoot/booking/index']],
        ['label' => 'Пользователи', 'url' => ['/adminPhotoshoot/users/index']],
    ];

    if (!Yii::$app->userPhotoshoot->isGuest) {
        $menuItems[] = ['label' => 'На сайт', 'url' => ['/photoshoot/main/index']];
        $menuItems[] = ['label' => 'Выход (' . Yii::$app->userPhotoshoot->identity->login . ')', 'url' => ['/photoshoot/auth/logout'], 'linkOptions' => ['data-method' => 'post']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>
</header>

<main role="main" class="container-fluid py-4">
    <?= $content ?>
</main>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
