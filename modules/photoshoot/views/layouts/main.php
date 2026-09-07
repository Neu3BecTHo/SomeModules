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
    <title><?= Html::encode($this->title) ?> - Фотостудия «Мои истории»</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => '«Мои истории»',
        'brandUrl' => ['/photoshoot/main/index'],
        'options' => [
            'class' => 'navbar-expand-lg navbar-custom fixed-top',
        ],
        'innerContainerOptions' => ['class' => 'container'],
    ]);

    $menuItems = [
        ['label' => 'Главная', 'url' => ['/photoshoot/main/index']],
        ['label' => 'О студии', 'url' => ['/photoshoot/main/about']],
        ['label' => 'Услуги', 'url' => ['/photoshoot/main/services']],
        ['label' => 'Галерея', 'url' => ['/photoshoot/main/gallery']],
        ['label' => 'Акции', 'url' => ['/photoshoot/main/news']],
        ['label' => 'Контакты', 'url' => ['/photoshoot/main/contacts']],
    ];

    if (Yii::$app->userPhotoshoot->isGuest) {
        $menuItems[] = ['label' => 'Войти', 'url' => ['/photoshoot/auth/login']];
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/photoshoot/auth/register']];
    } else {
        $menuItems[] = ['label' => 'Мои бронирования', 'url' => ['/photoshoot/booking/index']];
        $menuItems[] = ['label' => 'Профиль', 'url' => ['/photoshoot/profile/index']];
        if (Yii::$app->userPhotoshoot->identity->is_admin) {
            $menuItems[] = ['label' => 'Админ-панель', 'url' => ['/adminPhotoshoot/booking/index']];
        }
        $menuItems[] = ['label' => 'Выход (' . Yii::$app->userPhotoshoot->identity->full_name . ')', 'url' => ['/photoshoot/auth/logout'], 'linkOptions' => ['data-method' => 'post']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ms-auto'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>
</header>

<main role="main" style="padding-top: 76px;">
    <?= $content ?>
</main>

<footer class="footer-custom mt-auto">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Фотостудия «Мои истории»</h5>
                <p>Создаем воспоминания, которые останутся с вами навсегда.</p>
            </div>
            <div class="col-md-4">
                <h5>Контакты</h5>
                <p>Телефон: +7 (XXX) XXX-XX-XX</p>
                <p>Email: info@moistorii.ru</p>
            </div>
            <div class="col-md-4">
                <h5>Мы в соцсетях</h5>
                <p>Instagram, VK, Telegram</p>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col text-center">
                <p>&copy; <?= date('Y') ?> Фотостудия «Мои истории». Все права защищены.</p>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
