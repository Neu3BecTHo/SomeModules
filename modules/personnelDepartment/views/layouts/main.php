<?php

use app\modules\personnelDepartment\assets\PersonnelAsset;
use yii\helpers\Html;
use yii\helpers\Url;

PersonnelAsset::register($this);
/** @var \yii\web\View $this */
/** @var string $content */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title ?: 'Отдел кадров') ?></title>
    <?php $this->head() ?>
</head>
<body class="hr-body">
<?php $this->beginBody() ?>

<div class="hr-shell">
    <header class="hr-header">
        <div class="hr-header__left">
            <a href="<?= Url::to(['/personnel']) ?>" class="hr-brand">
                <span class="hr-brand__mark">HR</span>
                <span class="hr-brand__text">Отдел кадров</span>
            </a>
        </div>
        <nav class="hr-header__nav">
            <?php if (!Yii::$app->userPersonnelDepartment->isGuest): ?>
                <a href="<?= Url::to(['/personnel']) ?>" class="hr-nav__link">Главная</a>
                <a href="<?= Url::to(['profile/index']) ?>" class="hr-nav__link">Личный кабинет</a>
                <?php if (Yii::$app->userPersonnelDepartment->can('admin')): ?>
                    <a href="<?= Url::to(['/personnel/admin']) ?>" class="hr-nav__link">Админка</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="<?= Url::to(['auth/register']) ?>" class="hr-nav__link">Регистрация</a>
                <a href="<?= Url::to(['auth/login']) ?>" class="hr-nav__link">Вход</a>
            <?php endif; ?>
        </nav>
        <div class="hr-header__right">
            <?php if (Yii::$app->userPersonnelDepartment->isGuest): ?>
                <a href="<?= Url::to(['auth/login']) ?>" class="hr-btn hr-btn_header">Войти</a>
            <?php else: ?>
                <span class="hr-user">
                    <?= Html::encode(Yii::$app->userPersonnelDepartment->identity->email ?? '') ?>
                </span>
                <?= Html::beginForm(Url::to(['auth/logout']), 'post') ?>
                    <?= Html::submitButton('Выйти', ['class' => 'hr-btn hr-btn_ghost hr-btn_header']) ?>
                <?= Html::endForm() ?>
            <?php endif; ?>
        </div>
    </header>

    <main class="hr-main">
        <div class="hr-main__card">
            <?= $content ?>
        </div>
    </main>

    <footer class="hr-footer">
        <span>Информационная система «Отдел кадров»</span>
        <span class="hr-dot"></span>
        <span>Учебный проект</span>
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
