<?php

use app\modules\tours\assets\ToursAdminAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var string $content */

ToursAdminAsset::register($this);
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon-tours.svg">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title ?: 'Админка туров') ?></title>
    <?php $this->head(); ?>
</head>
<body class="tour-body">
<?php $this->beginBody(); ?>

<header class="tour-header">
    <div class="tour-header__inner">
        <a href="<?= Url::to(['#']) ?>" class="tour-logo">
            <span class="tour-logo__mark">🧭</span>
            <span class="tour-logo__text">Админка туров</span>
        </a>

        <nav class="tour-nav">
            <a href="<?= Url::to(['/tours/admin/requests']) ?>">Заявки</a>
            <a href="<?= Url::to(['/tours/admin/tours']) ?>">Туры</a>
            <a href="<?= Url::to(['/tours/admin/users']) ?>">Пользователи</a>
            <a href="<?= Url::to(['/tours/main/index']) ?>">На сайт</a>
        </nav>

        <div class="tour-header__auth">
            <?php if (!Yii::$app->userTours->isGuest): ?>
                <span class="tour-header__user">
                    <?= Html::encode(Yii::$app->userTours->identity->fio ?? 'Администратор') ?>
                </span>
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
    <div class="tour-footer__bottom">
        <span>© <?= date('Y') ?> Туры выходного дня — панель администратора</span>
    </div>
</footer>

<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>
