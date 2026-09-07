<?php
use yii\helpers\Html;
use app\modules\boardwalk\assets\BoardwalkAdminAsset;

/** @var yii\web\View $this */
/** @var string $content */

BoardwalkAdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon-boardwalk.svg">
    <?= Html::csrfMetaTags() ?>
    <title>Админка | <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="admin-body">
<?php $this->beginBody() ?>

<div class="admin-wrapper">
    <!-- Боковая или верхняя панель навигации -->
    <aside class="admin-sidebar">
        <div class="admin-logo">
            <?= Html::a('🎲 Настолка <small>Admin</small>', ['/boardwalk/admin']) ?>
        </div>
        <nav class="admin-nav">
            <?= Html::a('📋 Заявки', ['/boardwalk/admin'], ['class' => Yii::$app->controller->action->id == 'index' ? 'active' : '']) ?>
            <hr>
            <?= Html::a('🌐 На сайт', ['/boardwalk/main']) ?>
        </nav>
        <div class="admin-logout">
            <?= Html::beginForm(['/boardwalk/auth/logout'], 'post')
                . Html::submitButton('Выйти (' . Yii::$app->userBoardwalk->identity->phone . ')', ['class' => 'logout-link'])
                . Html::endForm() ?>
        </div>
    </aside>

    <!-- Основной контент -->
    <main class="admin-main-content">
        <?= $content ?>
    </main>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
