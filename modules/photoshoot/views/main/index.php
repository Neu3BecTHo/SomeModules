<?php

use yii\bootstrap5\Html;

/* @var $this yii\web\View */
/* @var $services array */
/* @var $gallery array */
/* @var $news array */
/* @var $reviews array */

$this->title = 'Главная';
?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <h1 class="hero-title">Создаем ваши истории</h1>
        <p class="hero-subtitle">Профессиональная фотостудия для особенных моментов вашей жизни</p>
        <?php if (Yii::$app->userPhotoshoot->isGuest): ?>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <?= Html::a('Забронировать зал', ['/photoshoot/auth/login'], ['class' => 'btn btn-primary-custom']) ?>
                <?= Html::a('Записаться на съёмку', ['/photoshoot/auth/login'], ['class' => 'btn btn-outline-light btn-lg']) ?>
            </div>
        <?php else: ?>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <?= Html::a('Забронировать зал', ['/photoshoot/booking/create'], ['class' => 'btn btn-primary-custom']) ?>
                <?= Html::a('Записаться на съёмку', ['/photoshoot/booking/create'], ['class' => 'btn btn-outline-light btn-lg']) ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Наши услуги</h2>
        <div class="row">
            <?php foreach ($services as $service): ?>
                <div class="col-md-4">
                    <div class="service-card">
                        <h4><?= Html::encode($service->name) ?></h4>
                        <p class="price-tag"><?= number_format($service->price, 0, ',', ' ') ?> ₽</p>
                        <p><?= Html::encode($service->description) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <?= Html::a('Все услуги', ['/photoshoot/main/services'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
    </div>
</section>

<!-- Why Choose Us -->
<section class="py-5" style="background: white;">
    <div class="container">
        <h2 class="section-title">Почему выбирают нас</h2>
        <div class="row">
            <div class="col-md-3 text-center">
                <div class="service-card">
                    <h5>5 фотозалов</h5>
                    <p>Разнообразные интерьеры для любых идей</p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="service-card">
                    <h5>Профессиональное оборудование</h5>
                    <p>Камеры, свет, реквизит премиум-класса</p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="service-card">
                    <h5>Опытные фотографы</h5>
                    <p>Помогут создать идеальные кадры</p>
                </div>
            </div>
            <div class="col-md-3 text-center">
                <div class="service-card">
                    <h5>Удобное бронирование</h5>
                    <p>Онлайн запись 24/7</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Галерея работ</h2>
        <div class="row">
            <?php foreach ($gallery as $item): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="gallery-item">
                        <img src="/uploads/photoshoot/<?= Html::encode($item->image) ?>" alt="<?= Html::encode($item->title) ?>">
                        <div class="gallery-overlay">
                            <h6><?= Html::encode($item->title) ?></h6>
                            <small><?= $item->getCategoryLabel() ?></small>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <?= Html::a('Вся галерея', ['/photoshoot/main/gallery'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
    </div>
</section>

<!-- Promotions Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <h2 class="section-title">Акции и спецпредложения</h2>
        <div class="row">
            <?php foreach ($news as $item): ?>
                <div class="col-md-4">
                    <div class="service-card">
                        <span class="badge bg-warning text-dark mb-2"><?= $item->getTypeLabel() ?></span>
                        <h5><?= Html::encode($item->title) ?></h5>
                        <p><?= mb_substr(strip_tags($item->content), 0, 100) ?>...</p>
                        <?php if ($item->date_end): ?>
                            <small class="text-muted">До <?= Yii::$app->formatter->asDate($item->date_end) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="text-center mt-4">
            <?= Html::a('Все акции', ['/photoshoot/main/news'], ['class' => 'btn btn-outline-primary']) ?>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-5">
    <div class="container">
        <h2 class="section-title">Отзывы клиентов</h2>
        <div class="row">
            <?php foreach ($reviews as $review): ?>
                <div class="col-md-4">
                    <div class="review-card">
                        <div class="review-stars">
                            <?= str_repeat('★', $review->rating) ?><?= str_repeat('☆', 5 - $review->rating) ?>
                        </div>
                        <p>"<?= Html::encode($review->comment) ?>"</p>
                        <small class="text-muted">— <?= Html::encode($review->user->full_name) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="py-5" style="background: white;">
    <div class="container">
        <h2 class="section-title">Контакты</h2>
        <div class="row">
            <div class="col-md-6">
                <h5>Адрес</h5>
                <p>г. Москва, ул. Фотографов, 123</p>
                <h5>Телефон</h5>
                <p>+7 (XXX) XXX-XX-XX</p>
                <h5>Email</h5>
                <p>info@moistorii.ru</p>
                <h5>Часы работы</h5>
                <p>Ежедневно: 9:00 - 22:00</p>
            </div>
            <div class="col-md-6">
                <div style="background: #eee; height: 300px; display: flex; align-items: center; justify-content: center; border-radius: 10px;">
                    <span class="text-muted">Карта проезда</span>
                </div>
            </div>
        </div>
    </div>
</section>
