<?php

use yii\helpers\Html;
use app\modules\cleaner\assets\CleanerAsset;

CleanerAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="site-header">
    <div class="site-header__inner">
        <div class="site-header__logo">
            <div class="site-header__logo-icon">Х</div>
            <div class="site-header__logo-text">Химчистка</div>
        </div>
        <nav class="site-header__nav">
            <?= Html::a('Главная', ['main/index'], [
                'class' => Yii::$app->controller->id === 'main' && Yii::$app->controller->action->id === 'index' ? 'active' : '',
            ]) ?>
            <?= Html::a('Услуги', ['main/index#services']) ?>
            <?= Html::a('Контакты', ['main/index#contacts']) ?>
        </nav>
        <div class="site-header__auth">
            <?php if (Yii::$app->userCleaner->isGuest): ?>
                <?= Html::a('Войти', ['auth/login'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                <?= Html::a('Регистрация', ['auth/register'], ['class' => 'btn btn-primary btn-sm']) ?>
            <?php else: ?>
                <span class="text-muted">
                    <?= Html::encode(Yii::$app->userCleaner->identity->first_name) ?>
                </span>
                <?= Html::a('Мои заявки', ['orders/index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                <?php if (Yii::$app->userCleaner->identity->can('admin')): ?>
                    <?= Html::a('Админка', ['/cleaner/admin'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                <?php endif; ?>
                <?= Html::a('Выйти', ['auth/logout'], [
                    'class' => 'btn btn-link btn-sm',
                    'data-confirm' => 'Выйти из системы?',
                ]) ?>
            <?php endif; ?>
        </div>
    </div>
</header>

<main class="main-container">
    <div class="container">
        <?= $content ?>
    </div>
</main>

<footer class="site-footer">
    <div class="site-footer__inner">
        <div>© <?= date('Y') ?> Химчистка. Все права защищены.</div>
        <div class="text-muted">Тел.: 8(999)999-99-99 • Адрес: г. Курган</div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>