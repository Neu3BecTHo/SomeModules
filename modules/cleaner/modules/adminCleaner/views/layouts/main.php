<?php

use yii\helpers\Html;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title><?= Html::encode($this->title) ?> — Панель управления</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="admin-body">
<?php $this->beginBody() ?>

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="admin-sidebar__brand">
            <div class="admin-sidebar__logo">Х</div>
            <div>
                <div class="admin-sidebar__title">Химчистка</div>
                <div class="admin-sidebar__subtitle">Панель управления</div>
            </div>
        </div>
        
        <div class="admin-sidebar__section">Главное</div>
        <nav class="admin-sidebar__nav">
            <?= Html::a('📋 Заявки', ['/cleaner/admin'], [
                'class' => Yii::$app->controller->action->id === 'index' ? 'active' : ''
            ]) ?>
            <?= Html::a('📊 Статистика', ['/cleaner/admin/statistics'], [
                'class' => Yii::$app->controller->action->id === 'statistics' ? 'active' : ''
            ]) ?>
        </nav>
        
        <div class="admin-sidebar__section">Ссылки</div>
        <nav class="admin-sidebar__nav">
            <?= Html::a('🏠 На сайт', ['/cleaner'], ['class' => '']) ?>
        </nav>
        
        <div class="admin-sidebar__footer">
            <div class="admin-user">
                <div class="admin-user__avatar">
                    <?= mb_substr(Yii::$app->userCleaner->identity->first_name, 0, 1) ?>
                </div>
                <div class="admin-user__info">
                    <div class="admin-user__name">
                        <?= Html::encode(Yii::$app->userCleaner->identity->fullName()) ?>
                    </div>
                    <div class="admin-user__role">Администратор</div>
                </div>
            </div>
            <?= Html::beginForm(['/cleaner/auth/logout'], 'post') ?>
                <?= Html::submitButton('🚪 Выход', ['class' => 'admin-sidebar__logout']) ?>
            <?= Html::endForm() ?>
        </div>
    </aside>

    <main class="admin-content">
        <?= $content ?>
    </main>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>