<?php
use app\modules\boardwalk\assets\BoardwalkAsset;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var string $content */

BoardwalkAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon-boardwalk.svg">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<header class="site-header">
    <div class="container header-inner">
        <div class="logo">
            <a href="<?= Url::to(['/boardwalk/main/index']) ?>">
                <span class="logo-icon">🎲</span> Boardwalk
            </a>
        </div>
        
        <nav class="main-nav">
            <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'about']) ?>">О нас</a>
            <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'catalog']) ?>">Каталог</a>
            <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'schedule']) ?>">График</a>
            <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'booking']) ?>">Запись</a>
            <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'reviews']) ?>">Отзывы</a>
            <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'contacts']) ?>">Контакты</a>
            
            <?php if (Yii::$app->userBoardwalk->isGuest): ?>
                <a href="<?= Url::to(['/boardwalk/auth/login']) ?>" class="nav-auth-link">Войти</a>
            <?php else: ?>
                <?php if (Yii::$app->userBoardwalk->can('admin')): ?>
                    <a href="<?= Url::to(['/boardwalk/admin']) ?>" class="nav-auth-link active">Админ-панель</a>
                <?php endif; ?>
                <a href="<?= Url::to(['/boardwalk/booking/index']) ?>" class="nav-auth-link active">Кабинет</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="page-wrapper">
    <?= $content ?>
</div>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="logo">🎲 Boardwalk</div>
                <p>Настольные игры для любой компании в Кургане.</p>
            </div>
            
            <nav class="footer-nav">
                <div class="footer-nav-col">
                    <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'about']) ?>">О нас</a>
                    <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'catalog']) ?>">Каталог игр</a>
                    <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'schedule']) ?>">График сессий</a>
                </div>
                <div class="footer-nav-col">
                    <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'reviews']) ?>">Отзывы</a>
                    <a href="<?= Url::to(['/boardwalk/main/index', '#' => 'contacts']) ?>">Контакты</a>
                    <a href="<?= Url::to(['/boardwalk/main/policy']) ?>">Политика конфиденциальности</a>
                </div>
            </nav>

            <div class="footer-social">
                <a href="#" class="social-link">VK</a>
                <a href="#" class="social-link">TG</a>
            </div>
        </div>
        
        <div class="footer-copyright">
            <p>© <?= date('Y') ?> Boardwalk Club. Все права защищены.</p>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
