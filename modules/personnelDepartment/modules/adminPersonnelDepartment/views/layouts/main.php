<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var string $content */

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title ?: 'Админка кадров') ?></title>
    <?php $this->head() ?>
</head>
<body class="ap-body">
<?php $this->beginBody() ?>

<div class="ap-shell">
    <header class="ap-header">
        <div class="ap-header__left">
            <a href="<?= Url::to(['/personnelDepartment/main/index']) ?>" class="ap-brand">
                <span class="ap-brand__mark">HR</span>
                <span class="ap-brand__text">Администрирование кадров</span>
            </a>
        </div>
        <div class="ap-header__right">
            <span class="ap-header__user">
                <?= Html::encode(Yii::$app->userPersonnelDepartment->identity->email ?? 'admin@mail.ru') ?>
            </span>
            <a href="<?= Url::to(['/personnelDepartment/auth/logout']) ?>"
               data-method="post"
               class="ap-btn ap-btn_header">
                Выйти
            </a>
        </div>
    </header>

    <div class="ap-main">
        <aside class="ap-sidebar">
            <nav class="ap-menu">
                <a href="<?= Url::to(['/adminPersonnelDepartment/questionnaires/index']) ?>"
                   class="ap-menu__item <?= Yii::$app->controller->id === 'questionnaires' ? 'ap-menu__item--active' : '' ?>">
                    Анкеты сотрудников
                </a>
                <!-- сюда потом можно добавить другие пункты -->
            </nav>
        </aside>

        <main class="ap-content">
            <div class="ap-content__card">
                <?= $content ?>
            </div>
        </main>
    </div>

    <footer class="ap-footer">
        <span>Панель администратора «Отдел кадров»</span>
        <span class="ap-dot"></span>
        <span>Учебный проект</span>
    </footer>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
