<?php

use yii\helpers\Html;

/** @var array $services */
/** @var array $benefits */
/** @var array $contacts */

$this->title = 'Химчистка — услуги по уходу за обувью и одеждой';
?>

<div class="hero-section">
    <div class="hero-section__inner">
        <div>
            <h1 class="hero-title">Профессиональная химчистка для вашего дома и гардероба</h1>
            <p class="hero-subtitle">
                Обувь, верхняя одежда, мягкая мебель и ковровые покрытия —
                аккуратная очистка с сохранением формы и цвета.
            </p>

            <div class="hero-badges">
                <span class="hero-badge">Бережные средства</span>
                <span class="hero-badge">Забор и доставка</span>
                <span class="hero-badge">Удобный онлайн‑заказ</span>
            </div>

            <div class="hero-cta">
                <?= Html::a('Оформить заявку', ['orders/create'], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Посмотреть услуги', '#services', ['class' => 'btn btn-outline-primary']) ?>
            </div>
        </div>

        <div class="hero-illustration">
            <div class="hero-illustration__title">Что мы чистим</div>
            <ul class="hero-illustration__list">
                <li>• Кроссовки, ботинки, сапоги</li>
                <li>• Пуховики, пальто, куртки</li>
                <li>• Диваны, кресла, матрасы</li>
                <li>• Ковры и ковровые дорожки</li>
            </ul>
        </div>
    </div>
</div>

<div class="section" id="services">
    <div class="container">
        <h2 class="section-title">Услуги и ориентировочные цены</h2>

        <div class="pricing-cards">
            <?php foreach ($services as $service): ?>
                <div class="pricing-card">
                    <div class="pricing-card__title">
                        <?= Html::encode($service['title']) ?>
                    </div>
                    <div class="pricing-card__price">
                        <?= Html::encode($service['price']) ?>
                    </div>
                    <div class="pricing-card__note">
                        <?= Html::encode($service['note']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="section">
    <div class="container">
        <h2 class="section-title">Преимущества нашей химчистки</h2>

        <div class="benefits-grid">
            <?php foreach ($benefits as $benefit): ?>
                <div class="benefit-card">
                    <div class="benefit-card__title">
                        <?= Html::encode($benefit['title']) ?>
                    </div>
                    <div class="text-muted">
                        <?= Html::encode($benefit['text']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="section" id="contacts">
    <div class="container">
        <h2 class="section-title">Контакты</h2>

        <div class="contacts-card">
            <ul class="contacts-list">
                <li><strong>Телефон:</strong> <?= Html::encode($contacts['phone']) ?></li>
                <li><strong>Адрес:</strong> <?= Html::encode($contacts['address']) ?></li>
                <li><strong>Email:</strong> <?= Html::encode($contacts['email']) ?></li>
                <li><strong>Режим работы:</strong> <?= Html::encode($contacts['worktime']) ?></li>
            </ul>
        </div>
    </div>
</div>