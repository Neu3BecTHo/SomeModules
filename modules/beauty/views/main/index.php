<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Салон красоты Виктория - Главная';
?>
<div class="beauty-container">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Салон красоты "Виктория"</h1>
            <p class="hero-subtitle">Откройте свою красоту вместе с нами</p>
            <div class="hero-buttons">
                <?= Html::a('Записаться', ['/beauty/book'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Каталог услуг', ['/beauty/catalog'], ['class' => 'btn btn-secondary']) ?>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories">
        <div class="container">
            <h2 class="section-title">Наши услуги</h2>
            <div class="categories-grid">
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <div class="category-image">
                            <?php if ($category->image): ?>
                                <img src="<?= $category->image ?>" alt="<?= Html::encode($category->name) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="category-content">
                            <h3><?= Html::encode($category->name) ?></h3>
                            <p><?= Html::encode($category->description) ?></p>
                            <?= Html::a('Подробнее', ['/beauty/catalog', 'category' => $category->id], ['class' => 'btn btn-outline']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Featured Services -->
    <section class="featured-services">
        <div class="container">
            <h2 class="section-title">Популярные услуги</h2>
            <div class="services-grid">
                <?php foreach ($services as $service): ?>
                    <div class="service-card">
                        <div class="service-image">
                            <?php if ($service->image): ?>
                                <img src="<?= $service->image ?>" alt="<?= Html::encode($service->name) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="service-content">
                            <h3><?= Html::encode($service->name) ?></h3>
                            <p class="service-duration"><?= $service->duration ?> мин</p>
                            <p class="service-price"><?= number_format($service->price, 0, '.', ' ') ?> ₽</p>
                            <?= Html::a('Записаться', ['/beauty/book', 'service_id' => $service->id], ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center">
                <?= Html::a('Все услуги', ['/beauty/catalog'], ['class' => 'btn btn-outline']) ?>
            </div>
        </div>
    </section>

    <!-- Masters Section -->
    <section class="masters">
        <div class="container">
            <h2 class="section-title">Наши мастера</h2>
            <div class="masters-grid">
                <?php foreach ($masters as $master): ?>
                    <div class="master-card">
                        <div class="master-photo">
                            <?php if ($master->photo): ?>
                                <img src="<?= $master->photo ?>" alt="<?= Html::encode($master->user->full_name) ?>">
                            <?php endif; ?>
                        </div>
                        <div class="master-info">
                            <h3><?= Html::encode($master->user->full_name) ?></h3>
                            <p class="master-specialization"><?= Html::encode($master->specialization) ?></p>
                            <div class="master-rating">
                                <span class="stars">★★★★★</span>
                                <span class="rating-value"><?= number_format($master->rating, 1) ?></span>
                            </div>
                            <?= Html::a('Подробнее', ['/beauty/master', 'id' => $master->id], ['class' => 'btn btn-outline']) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2 class="section-title">О салоне</h2>
                    <p>Салон красоты "Виктория" - это место, где профессионализм встречается с искусством. Мы предлагаем широкий спектр услуг по уходу за волосами, ногтями и кожей.</p>
                    <p>Наши мастера - это высококвалифицированные специалисты с многолетним опытом работы, которые помогут вам подчеркнуть свою индивидуальность и красоту.</p>
                    <div class="about-features">
                        <div class="feature">
                            <i class="icon-star"></i>
                            <span>Высококвалифицированные мастера</span>
                        </div>
                        <div class="feature">
                            <i class="icon-heart"></i>
                            <span>Индивидуальный подход</span>
                        </div>
                        <div class="feature">
                            <i class="icon-shield"></i>
                            <span>Качественные материалы</span>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <img src="/images/beauty/salon.jpg" alt="Салон красоты Виктория">
                </div>
            </div>
        </div>
    </section>

    <!-- Contacts Section -->
    <section class="contacts">
        <div class="container">
            <h2 class="section-title">Контакты</h2>
            <div class="contacts-grid">
                <div class="contact-info">
                    <div class="contact-item">
                        <i class="icon-phone"></i>
                        <div>
                            <h4>Телефон</h4>
                            <p>+7 (123) 456-78-90</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="icon-map"></i>
                        <div>
                            <h4>Адрес</h4>
                            <p>г. Москва, ул. Красная, д. 1</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <i class="icon-clock"></i>
                        <div>
                            <h4>Время работы</h4>
                            <p>Пн-Сб: 9:00 - 20:00<br>Вс: 10:00 - 18:00</p>
                        </div>
                    </div>
                </div>
                <div class="contact-map">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2245.1234567890!2d37.617494!3d55.755826!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzXCsDM2JzE3LjEiTiA3MMKwMzcnMTIuOCJF!5e0!3m2!1sru!2sru!4v1234567890" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </section>
</div>
