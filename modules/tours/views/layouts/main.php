<?php

use app\modules\tours\assets\ToursAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var string $content */

ToursAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon-tours.svg">
    <title><?= Html::encode($this->title ?: 'Туры выходного дня') ?></title>
    <?php $this->head(); ?>
</head>
<body class="tour-body">
<?php $this->beginBody(); ?>

<header class="tour-header">
    <div class="tour-header__inner">
        <a href="<?= Url::to(['/tours/main/index']) ?>" class="tour-logo">
            <span class="tour-logo__mark">🌄</span>
            <span class="tour-logo__text">Туры выходного дня</span>
        </a>

        <nav class="tour-nav">
            <a href="<?= Url::to(['/tours/main/index']) ?>">Главная</a>
            <a href="<?= Url::to(['/tours/tours/index']) ?>">Туры</a>
            <a href="<?= Url::to(['/tours/main/contacts']) ?>">Контакты</a>
            <?php if (!Yii::$app->userTours->isGuest): ?>
                <a href="<?= Url::to(['/tours/requests/index']) ?>">Мои заявки</a>
                <?php if (Yii::$app->userTours->can('admin')): ?>
                    <a href="<?= Url::to(['/tours/admin']) ?>" class="btn btn-outline">Админ-панель</a>
                <?php endif; ?>
            <?php endif; ?>
        </nav>

        <div class="tour-header__auth">
            <?php if (Yii::$app->userTours->isGuest): ?>
                <a href="<?= Url::to(['/tours/auth/login']) ?>" class="btn btn-outline">Вход</a>
                <a href="<?= Url::to(['/tours/auth/register']) ?>" class="btn btn-primary">Регистрация</a>
            <?php else: ?>
                <?= Html::beginForm(['/tours/auth/logout'], 'post') ?>
                    <span class="tour-header__user">
                        <?= Html::encode(Yii::$app->userTours->identity->fullName() ?? 'Пользователь') ?>
                    </span>
                    <?= Html::submitButton('Выйти', ['class' => 'btn btn-outline']) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="tour-main">
    <?= $content ?>
</main>

<footer class="tour-footer">
    <div class="tour-footer__top">
        <nav class="tour-footer__menu">
            <a href="<?= Url::to(['/tours/main/index']) ?>">Главная</a>
            <a href="<?= Url::to(['/tours/tours/index']) ?>">Туры</a>
            <a href="<?= Url::to(['/tours/main/contacts']) ?>">Контакты</a>
        </nav>
        <div class="tour-footer__socials">
            <a href="#">VK</a>
            <a href="#">TG</a>
        </div>
    </div>
    <div class="tour-footer__bottom">
        <span>© <?= date('Y') ?> Туры выходного дня</span>
        <a href="/tours/main/privacy">Политика конфиденциальности</a>
    </div>
</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>