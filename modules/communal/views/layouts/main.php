<?php
use app\modules\communal\assets\CommunalAsset;
use yii\helpers\Html;
use yii\helpers\Url;

CommunalAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="c-body">
<?php $this->beginBody() ?>

<div class="c-app-wrapper">
    
    <!-- Хедер -->
    <header class="c-header">
        <div class="c-container c-header-inner">
            <a href="<?= Url::to(['/communal/main/index']) ?>" class="c-logo">
                <span class="c-logo-mark">К</span> Коммуналка
            </a>

            <nav class="c-nav">
                <a href="<?= Url::to(['/communal/main/index']) ?>" class="c-nav-link">Главная</a>
                
                <?php if (Yii::$app->userCommunal->isGuest): ?>
                    <a href="<?= Url::to(['/communal/auth/login']) ?>" class="c-btn c-btn-sm c-btn-outline">Войти</a>
                <?php elseif (Yii::$app->userCommunal->can('admin')): ?>
                    <a href="<?= Url::to(['/communal/admin']) ?>" class="c-btn c-btn-sm c-btn-outline">Админ-панель</a>
                <?php else: ?>
                    <a href="<?= Url::to(['/communal/profile/index']) ?>" class="c-nav-link">Личный кабинет</a>
                    <a href="<?= Url::to(['/communal/request/index']) ?>" class="c-nav-link">Просмотр заявок</a>
                    <a href="<?= Url::to(['/communal/request/create']) ?>" class="c-btn c-btn-sm c-btn-primary">Подать</a>
                    <?= Html::beginForm(Url::to(['/communal/auth/logout']), 'post') ?>
                        <?= Html::submitButton('Выйти', ['class' => 'c-btn c-btn-sm c-btn-outline']) ?>
                    <?= Html::endForm() ?>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <!-- Контент -->
    <main class="c-main">
        <div class="c-container">
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="c-alert c-alert-success">
                    <?= Yii::$app->session->getFlash('success') ?>
                </div>
            <?php endif; ?>
            
            <?= $content ?>
        </div>
    </main>

    <!-- Футер -->
    <footer class="c-footer">
        <div class="c-container c-footer-inner">
            <div class="c-copyright">© 2025 Портал ЖКХ</div>
            <div class="c-footer-nav">
                <a href="#">Помощь</a>
                <a href="#">Правила</a>
            </div>
        </div>
    </footer>

</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
