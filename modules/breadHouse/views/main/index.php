<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var app\modules\breadHouse\models\Categories[] $categories */
/** @var app\modules\breadHouse\models\Product[] $featuredProducts */
/** @var app\modules\breadHouse\models\Product[] $newProducts */
/** @var array $benefits */
/** @var array $contacts */

$this->title = 'Пекарня "Хлебный дворик" — свежие хлебобулочные изделия';
?>

<!-- ===== HERO BANNER & PROMOTIONS ===== -->
<section class="bh-hero">
    <div class="container">
        <div class="bh-hero__inner">
            <div class="bh-hero__content">
                <h1 class="bh-hero__title">Свежие хлебобулочные изделия от пекарни "Хлебный дворик"</h1>
                <p class="bh-hero__subtitle">
                    Хлеб, булочки, десерты и сезонные позиции — вкусные и качественные продукты
                    для вашего стола. Доставка и самовывоз.
                </p>

                <div class="bh-hero__badges">
                    <span class="bh-badge">🌾 Свежие ингредиенты</span>
                    <span class="bh-badge">🚚 Быстрая доставка</span>
                    <span class="bh-badge">💻 Онлайн-заказ</span>
                </div>

                <div class="bh-hero__cta">
                    <a href="<?= Url::to(['catalog/index']) ?>" class="bh-btn bh-btn--primary">
                        <span>🛒</span>
                        <span>Перейти в каталог</span>
                    </a>
                    <a href="#contacts" class="bh-btn bh-btn--outline">
                        <span>📍</span>
                        <span>Контакты</span>
                    </a>
                </div>
            </div>

            <div class="bh-hero__promotions">
                <div class="bh-promotions-slider">
                    <div class="bh-promotion-item bh-promotion-item--active">
                        <h3>🎉 Скидка 15% на все пироги!</h3>
                        <p>Каждый вторник - пироги со скидкой. Только свежие и ароматные!</p>
                        <span class="bh-promotion-badge">Действует до 31.12.2026</span>
                    </div>
                    <div class="bh-promotion-item">
                        <h3>🚚 Бесплатная доставка от 1000 руб.</h3>
                        <p>Заказывайте на сумму от 1000 рублей и получайте бесплатную доставку по городу.</p>
                        <span class="bh-promotion-badge">Всегда</span>
                    </div>
                    <div class="bh-promotion-item">
                        <h3>✨ Новинка: Круассаны с шоколадом</h3>
                        <p>Попробуйте наши новые круассаны! Скидка 20% на первую покупку.</p>
                        <span class="bh-promotion-badge">До 15.03.2026</span>
                    </div>
                </div>
                <div class="bh-promotions-controls">
                    <button class="bh-promotions-btn bh-promotions-btn--prev" onclick="changePromotion(-1)">‹</button>
                    <button class="bh-promotions-btn bh-promotions-btn--next" onclick="changePromotion(1)">›</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== QUICK NAVIGATION ===== -->
<section class="bh-quick-nav">
    <div class="container">
        <nav class="bh-quick-nav-grid">
            <a href="<?= Url::to(['catalog/index']) ?>" class="bh-quick-nav-item">
                <div class="bh-quick-nav-icon">🍞</div>
                <span>Каталог</span>
            </a>
            <a href="#promotions" class="bh-quick-nav-item">
                <div class="bh-quick-nav-icon">🎉</div>
                <span>Акции</span>
            </a>
            <a href="#contacts" class="bh-quick-nav-item">
                <div class="bh-quick-nav-icon">📞</div>
                <span>Контакты</span>
            </a>
            <a href="<?= Url::to(['auth/login']) ?>" class="bh-quick-nav-item">
                <div class="bh-quick-nav-icon">👤</div>
                <span>Войти</span>
            </a>
        </nav>
    </div>
</section>

<!-- ===== SEARCH SECTION ===== -->
<section class="bh-search">
    <div class="container">
        <div class="bh-search-wrapper">
            <h2 class="bh-search-title">Найдите свой любимый продукт</h2>
            <form action="<?= Url::to(['catalog/index']) ?>" method="get" class="bh-search-form">
                <input type="text" name="q" placeholder="Поиск товаров..." class="bh-search-input">
                <button type="submit" class="bh-btn bh-btn--primary">🔍 Найти</button>
            </form>
        </div>
    </div>
</section>

<!-- ===== PRODUCTS SECTION ===== -->
<section class="bh-products-section" id="products">
    <div class="container">
        <!-- Featured Products -->
        <div class="bh-products-block">
            <h2 class="bh-section-title">🌟 Популярные товары</h2>
            <div class="bh-products">
                <?php foreach (array_slice($featuredProducts, 0, 6) as $product): ?>
                    <div class="bh-product-card">
                        <div class="bh-product__image">
                            <?php 
                            $allImages = $product->getAllImages();
                            if (!empty($allImages)): 
                            ?>
                                <img src="<?= $allImages[0] ?>" alt="<?= $product->name ?>" class="bh-product-img">
                            <?php else: ?>
                                <img src="/images/no-image.png" alt="<?= $product->name ?>" class="bh-product-img">
                            <?php endif; ?>
                            <?php if ($product->rating >= 4.5): ?>
                                <span class="bh-product__badge">⭐ Хит</span>
                            <?php endif; ?>
                        </div>
                        <div class="bh-product__info">
                            <h3 class="bh-product__title"><?= Html::encode($product->name) ?></h3>
                            <p class="bh-product__description"><?= Html::encode($product->description) ?></p>
                            <div class="bh-product__meta">
                                <span class="bh-product__price"><?= $product->price ?> ₽</span>
                                <div class="bh-product__rating">
                                    ⭐ <?= number_format($product->rating, 1) ?>
                                </div>
                            </div>
                            <div class="bh-product__actions">
                                <form action="<?= Url::to(['cart/add']) ?>" method="post" style="display:inline;">
                                    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                    <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                    <input type="number" name="quantity" value="1" min="1" max="<?= $product->stock ?>" class="bh-quantity-input">
                                    <button type="submit" class="bh-btn bh-btn--primary bh-btn--small">🛒 В корзину</button>
                                </form>
                                <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" class="bh-btn bh-btn--outline bh-btn--small">👁️ Подробнее</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- New Products -->
        <div class="bh-products-block">
            <h2 class="bh-section-title">✨ Новинки</h2>
            <div class="bh-new-products-slider">
                <div class="bh-new-products-container">
                    <?php foreach ($newProducts as $product): ?>
                        <div class="bh-new-product-slide">
                            <div class="bh-new-product-card">
                                <div class="bh-new-product__image">
                                    <?php 
                                    $allImages = $product->getAllImages();
                                    if (!empty($allImages)): 
                                    ?>
                                        <img src="<?= $allImages[0] ?>" alt="<?= $product->name ?>" class="bh-new-product-img">
                                    <?php else: ?>
                                        <img src="/images/no-image.png" alt="<?= $product->name ?>" class="bh-new-product-img">
                                    <?php endif; ?>
                                    <span class="bh-new-product-badge">Новинка</span>
                                </div>
                                <div class="bh-new-product__info">
                                    <h4 class="bh-new-product__title"><?= Html::encode($product->name) ?></h4>
                                    <p class="bh-new-product__description"><?= Html::encode($product->description) ?></p>
                                    <div class="bh-new-product__meta">
                                        <span class="bh-new-product__price"><?= $product->price ?> ₽</span>
                                        <div class="bh-new-product__rating">
                                            ⭐ <?= number_format($product->rating, 1) ?>
                                        </div>
                                    </div>
                                    <div class="bh-new-product__actions">
                                        <form action="<?= Url::to(['cart/add']) ?>" method="post" style="display:inline;">
                                            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                            <input type="hidden" name="product_id" value="<?= $product->id ?>">
                                            <input type="number" name="quantity" value="1" min="1" max="<?= $product->stock ?>" class="bh-quantity-input bh-quantity-input--small">
                                            <button type="submit" class="bh-btn bh-btn--primary bh-btn--small">🛒</button>
                                        </form>
                                        <a href="<?= Url::to(['product/view', 'id' => $product->id]) ?>" class="bh-btn bh-btn--outline bh-btn--small">👁️</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="bh-new-slider-controls">
                    <button class="bh-new-slider-btn bh-new-slider-btn--prev" onclick="changeNewSlide(-1)">‹</button>
                    <div class="bh-new-slider-dots"></div>
                    <button class="bh-new-slider-btn bh-new-slider-btn--next" onclick="changeNewSlide(1)">›</button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== CONTACTS & MAP ===== -->
<section class="bh-contacts" id="contacts">
    <div class="container">
        <h2 class="bh-section-title">📍 Контакты</h2>

        <div class="bh-contacts-layout">
            <div class="bh-contacts-info">
                <div class="bh-card">
                    <div class="bh-card__header">
                        <h3>📞 Свяжитесь с нами</h3>
                    </div>
                    <div class="bh-card__body">
                        <div class="bh-contacts-list">
                            <div class="bh-contact-item">
                                <strong>📞 Телефон:</strong> 
                                <span><?= Html::encode($contacts['phone']) ?></span>
                            </div>
                            <div class="bh-contact-item">
                                <strong>📍 Адрес:</strong> 
                                <span><?= Html::encode($contacts['address']) ?></span>
                            </div>
                            <div class="bh-contact-item">
                                <strong>📧 Email:</strong> 
                                <span><?= Html::encode($contacts['email']) ?></span>
                            </div>
                            <div class="bh-contact-item">
                                <strong>🕐 Режим работы:</strong> 
                                <span><?= Html::encode($contacts['worktime']) ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bh-card">
                    <div class="bh-card__header">
                        <h3>🌟 Почему выбирают нас</h3>
                    </div>
                    <div class="bh-card__body">
                        <div class="bh-benefits-grid">
                            <?php foreach ($benefits as $benefit): ?>
                                <div class="bh-benefit-card">
                                    <div class="bh-benefit-icon">
                                        <?= Html::encode($benefit['icon'] ?? '✨') ?>
                                    </div>
                                    <div class="bh-benefit-content">
                                        <h4 class="bh-benefit-title"><?= Html::encode($benefit['title']) ?></h4>
                                        <p class="bh-benefit-text"><?= Html::encode($benefit['text']) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bh-contacts-map">
                <div class="bh-card">
                    <div class="bh-card__header">
                        <h3>🗺️ Наше расположение</h3>
                    </div>
                    <div class="bh-card__body bh-card__body--padding-0">
                        <div class="bh-map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.0!2d37.6!3d55.7!2m3!1f0!2f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNTXCsDQyJzAwLjAiTiAzN8KwMzYnMDAuMCJF!5e0!3m2!1sen!2s!4v1234567890"
                                    width="100%"
                                    height="400"
                                    style="border:0; border-radius: var(--bh-radius);"
                                    allowfullscreen=""
                                    loading="lazy">
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Promotions slider functionality
let currentPromotion = 0;
const promotions = document.querySelectorAll('.bh-promotion-item');
const totalPromotions = promotions.length;

function showPromotion(index) {
    promotions.forEach((item, i) => {
        item.classList.toggle('bh-promotion-item--active', i === index);
    });
    currentPromotion = index;
}

function changePromotion(direction) {
    const next = (currentPromotion + direction + totalPromotions) % totalPromotions;
    showPromotion(next);
}

// Auto-rotate promotions
setInterval(() => changePromotion(1), 5000);

// New products slider functionality
let currentNewSlide = 0;
const newSlides = document.querySelectorAll('.bh-new-product-slide');
const totalNewSlides = newSlides.length;

function showNewSlide(index) {
    if (totalNewSlides === 0) return;
    
    const container = document.querySelector('.bh-new-products-container');
    const dots = document.querySelectorAll('.bh-new-slider-dot');
    
    container.style.transform = `translateX(-${index * 100}%)`;
    
    // Update dots
    dots.forEach((dot, i) => {
        dot.classList.toggle('bh-new-slider-dot--active', i === index);
    });
    
    currentNewSlide = index;
}

function changeNewSlide(direction) {
    if (totalNewSlides === 0) return;
    const next = (currentNewSlide + direction + totalNewSlides) % totalNewSlides;
    showNewSlide(next);
}

// Initialize dots
document.addEventListener('DOMContentLoaded', function() {
    const dotsContainer = document.querySelector('.bh-new-slider-dots');
    if (dotsContainer && totalNewSlides > 0) {
        for (let i = 0; i < totalNewSlides; i++) {
            const dot = document.createElement('button');
            dot.className = `bh-new-slider-dot ${i === 0 ? 'bh-new-slider-dot--active' : ''}`;
            dot.setAttribute('aria-label', `Перейти к слайду ${i + 1}`);
            dot.onclick = () => showNewSlide(i);
            dotsContainer.appendChild(dot);
        }
    }
    
    // Auto-rotate new products
    setInterval(() => changeNewSlide(1), 8000);
});
</script>