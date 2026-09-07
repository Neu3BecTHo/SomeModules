<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon-beauty.svg">
    <?php $this->head() ?>
    <title><?= Html::encode($this->title) ?></title>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Header -->
<header class="beauty-header">
    <div class="header-content">
        <div class="logo">
            <?= Html::a('Виктория', ['/beauty/main/index'], ['class' => 'logo-link']) ?>
        </div>
        
        <nav class="main-nav">
            <ul class="nav-list">
                <li><a href="<?= Url::to(['/beauty/main/index']) ?>" class="nav-link">Главная</a></li>
                <li><a href="<?= Url::to(['/beauty/main/catalog']) ?>" class="nav-link">Каталог</a></li>
                <li><a href="<?= Url::to(['/beauty/main/about']) ?>" class="nav-link">О нас</a></li>
                <li><a href="<?= Url::to(['/beauty/main/contacts']) ?>" class="nav-link">Контакты</a></li>
            </ul>
        </nav>

        <div class="header-actions">
            <?php if (Yii::$app->userBeauty->isGuest): ?>
                <?= Html::a('Вход', ['/beauty/auth/login'], ['class' => 'btn btn-outline btn-sm']) ?>
            <?php else: ?>
                <div class="user-menu">
                    <span class="user-name"><?= Html::encode(Yii::$app->userBeauty->identity->full_name) ?></span>
                    <div class="user-dropdown">
                        <?= Html::a('Профиль', ['/beauty/profile/index'], ['class' => 'dropdown-link']) ?>
                        <?= Html::a('Мои заказы', ['/beauty/orders/index'], ['class' => 'dropdown-link']) ?>
                        <?php if (Yii::$app->userBeauty->identity->role === 'master'): ?>
                            <?= Html::a('Кабинет мастера', ['/beauty/admin/master-cabinet'], ['class' => 'dropdown-link']) ?>
                        <?php elseif (Yii::$app->userBeauty->identity->role === 'admin'): ?>
                            <?= Html::a('Админ панель', ['/beauty/admin'], ['class' => 'dropdown-link']) ?>
                        <?php endif; ?>
                        <?= Html::beginForm(['/beauty/auth/logout'], 'post', ['class' => 'dropdown-item p-0']) ?>
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <?= Html::submitButton('Выход', ['class' => 'dropdown-link border-0 bg-transparent w-100 text-start']) ?>
                        <?= Html::endForm() ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="beauty-main">
    <?= $content ?>
</main>

<!-- Footer -->
<footer class="beauty-footer">
    <div class="footer-content">
        <div class="footer-section">
            <h3>Салон "Виктория"</h3>
            <p>Профессиональные услуги красоты в центре Москвы</p>
            <div class="social-links">
                <a href="#" class="social-link">VK</a>
                <a href="#" class="social-link">IG</a>
                <a href="#" class="social-link">TG</a>
            </div>
        </div>
        
        <div class="footer-section">
            <h3>Услуги</h3>
            <ul class="footer-links">
                <li><a href="<?= Url::to(['/beauty/main/catalog']) ?>">Парикмахерские</a></li>
                <li><a href="<?= Url::to(['/beauty/main/catalog']) ?>">Ногтевой сервис</a></li>
                <li><a href="<?= Url::to(['/beauty/main/catalog']) ?>">Косметология</a></li>
                <li><a href="<?= Url::to(['/beauty/main/catalog']) ?>">Массаж</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Информация</h3>
            <ul class="footer-links">
                <li><a href="<?= Url::to(['/beauty/main/about']) ?>">О салоне</a></li>
                <li><a href="<?= Url::to(['/beauty/main/contacts']) ?>">Контакты</a></li>
                <li><a href="#">Политика конфиденциальности</a></li>
            </ul>
        </div>
        
        <div class="footer-section">
            <h3>Контакты</h3>
            <div class="contact-info">
                <p><strong>Телефон:</strong> +7 (123) 456-78-90</p>
                <p><strong>Адрес:</strong> г. Москва, ул. Красная, д. 1</p>
                <p><strong>Время работы:</strong></p>
                <p>Пн-Сб: 9:00 - 20:00</p>
                <p>Вс: 10:00 - 18:00</p>
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; <?= date('Y') ?> Салон красоты "Виктория". Все права защищены.</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
