<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\breadHouse\assets\BreadHouseAsset;

/** @var \yii\web\View $this */
/** @var string $content */

BreadHouseAsset::register($this);
$isGuest = Yii::$app->userBreadHouse->isGuest;
$user    = Yii::$app->userBreadHouse->identity;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon-breadhouse.svg">
    <title><?= Html::encode($this->title ?: 'Хлебный дворик') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="bh-header">
    <div class="container">
        <div class="bh-header__inner">
            <div class="bh-header__left">
                <a href="<?= Url::to(['/breadHouse/main/index']) ?>" class="bh-logo">
                    <div class="bh-logo__icon">🍞</div>
                    <div class="bh-logo__text">
                        <div class="bh-logo__title">Хлебный дворик</div>
                        <div class="bh-logo__subtitle">Свежий хлеб каждый день</div>
                    </div>
                </a>
            </div>

            <nav class="bh-nav">
                <a href="<?= Url::to(['/breadHouse/main/index']) ?>" class="bh-nav__link <?= Yii::$app->controller->id === 'main' && Yii::$app->controller->action->id === 'index' ? 'bh-nav__link--active' : '' ?>">
                    Главная
                </a>
                <a href="<?= Url::to(['/breadHouse/catalog/index']) ?>" class="bh-nav__link <?= Yii::$app->controller->id === 'catalog' ? 'bh-nav__link--active' : '' ?>">
                    Каталог
                </a>
                <a href="<?= Url::to(['/breadHouse/main/index', '#' => 'promotions']) ?>" class="bh-nav__link">
                    Акции
                </a>
                <a href="<?= Url::to(['/breadHouse/main/index', '#' => 'contacts']) ?>" class="bh-nav__link">
                    Контакты
                </a>
            </nav>

            <div class="bh-header__right">
                <a href="<?= Url::to(['/breadHouse/cart/index']) ?>" class="bh-cart-btn">
                    <span class="bh-cart-icon">🛒</span>
                    <span class="bh-cart-text">Корзина</span>
                    <?php 
                    $cartCount = 0;
                    if (!$isGuest) {
                        $cart = \app\modules\breadHouse\models\Cart::getCartItems();
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    }
                    if ($cartCount > 0): ?>
                        <span class="bh-cart-badge"><?= $cartCount ?></span>
                    <?php endif; ?>
                </a>
                
                <?php if ($isGuest): ?>
                    <a href="<?= Url::to(['/breadHouse/auth/login']) ?>" class="bh-btn bh-btn--primary">
                        Войти
                    </a>
                <?php else: ?>
                    <div class="bh-user-menu">
                        <button class="bh-user-btn">
                            <div class="bh-user-avatar"><?= mb_substr(Html::encode($user->first_name ?? 'Г'), 0, 1) ?></div>
                            <span class="bh-user-name"><?= Html::encode($user->first_name ?? 'Гость') ?></span>
                            <span class="bh-user-arrow">▼</span>
                        </button>
                        <div class="bh-user-dropdown">
                            <a href="<?= Url::to(['/breadHouse/profile/index']) ?>" class="bh-dropdown-item">
                                � Мой профиль
                            </a>
                            <a href="<?= Url::to(['/breadHouse/orders/index']) ?>" class="bh-dropdown-item">
                                📋 Мои заказы
                            </a>
                            <?php if (!$isGuest && $user->is_admin): ?>
                                <a href="<?= Url::to(['/breadHouse/admin']) ?>" class="bh-dropdown-item">
                                    ⚙️ Админ-панель
                                </a>
                            <?php endif; ?>
                            <div class="bh-dropdown-divider"></div>
                            <?= Html::beginForm(['/breadHouse/auth/logout'], 'post', ['class' => 'bh-logout-form']) ?>
                                <?= Html::hiddenInput('_csrf', Yii::$app->request->csrfToken) ?>
                                <button type="submit" class="bh-dropdown-item bh-dropdown-item--logout">
                                    🚪 Выйти
                                </button>
                            <?= Html::endForm() ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</header>

<main class="bh-main">
    <?= $content ?>
</main>

<footer class="bh-footer">
    <div class="container">
        <div class="bh-footer__inner">
            <div class="bh-footer__section">
                <h4 class="bh-footer__title">Хлебный дворик</h4>
                <p class="bh-footer__text">Свежие хлебобулочные изделия из лучших ингредиентов. Доставка и самовывоз.</p>
            </div>
            <div class="bh-footer__section">
                <h4 class="bh-footer__title">Контакты</h4>
                <p class="bh-footer__text">
                    📞 +7 (800) 555-53-53<br>
                    📍 г. Курган, ул. Центральная, 1<br>
                    📧 info@breadhouse.ru
                </p>
            </div>
            <div class="bh-footer__section">
                <h4 class="bh-footer__title">Режим работы</h4>
                <p class="bh-footer__text">
                    Пн-Пт: 7:00 - 20:00<br>
                    Сб-Вс: 8:00 - 18:00
                </p>
            </div>
        </div>
        <div class="bh-footer__bottom">
            <div>© <?= date('Y') ?> Хлебный дворик. Все права защищены.</div>
            <div>Разработано с ❤️ для вас</div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>