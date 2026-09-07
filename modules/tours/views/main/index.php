<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\Tours[] $tours */
/** @var app\modules\tours\models\Reviews[] $reviews */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Туры выходного дня';
?>

<div class="tour-hero">
    <div class="tour-hero__content">
        <h1>Туры выходного дня по Уралу</h1>
        <p>Подборка лучших маршрутов: горы, озёра, водопады и необычные места в формате коротких путешествий.</p>
        <a href="<?= Url::to(['tours/index']) ?>" class="btn btn-primary">
            Подобрать тур
        </a>
    </div>
    <div class="tour-hero__media">
        <div class="tour-hero__photo"></div>
    </div>
</div>

<section class="tour-about">
    <h2>О портале</h2>
    <div class="tour-about__grid">
        <div>
            <p>«Туры выходного дня» — сервис для быстрого выбора и бронирования коротких путешествий.</p>
            <ul>
                <li>Проверенные маршруты и организаторы.</li>
                <li>Онлайн‑заявка и удобный способ оплаты.</li>
                <li>Отзывы участников и фотоотчёты.</li>
            </ul>
        </div>
        <div class="tour-about__media">
            <div class="tour-about__photo tour-about__photo--1"></div>
            <div class="tour-about__photo tour-about__photo--2"></div>
        </div>
    </div>
</section>

<section class="tour-catalog-preview">
    <div class="tour-section-header">
        <h2>Популярные туры</h2>
        <a href="<?= Url::to(['tours/catalog']) ?>" class="tour-link">Все туры</a>
    </div>

    <div class="tour-card-grid">
        <?php foreach ($tours as $tour): ?>
            <article class="tour-card">
                <a href="<?= Url::to(['tours/view', 'id' => $tour->id]) ?>">
                    <div class="tour-card__image"
                         style="background-image: url('<?= Html::encode($tour->image ?: '/images/tours/slide1.jpg') ?>')">
                    </div>
                    <div class="tour-card__body">
                        <h3><?= Html::encode($tour->title) ?></h3>
                        <p><?= Html::encode($tour->short_description) ?></p>
                        <div class="tour-card__meta">
                            <span class="tour-card__price">
                                <?= Yii::$app->formatter->asCurrency($tour->price, 'RUB') ?>
                            </span>
                            <?php if ($tour->duration_days): ?>
                                <span class="tour-card__duration"><?= (int)$tour->duration_days ?> дн.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </a>
            </article>
        <?php endforeach; ?>
        <?php if (empty($tours)): ?>
            <p>Пока нет доступных туров.</p>
        <?php endif; ?>
    </div>
</section>

<section class="tour-services">
    <h2>Услуги и опции</h2>
    <div class="tour-services__grid">
        <div class="tour-service-card">
            <h3>Трансфер</h3>
            <p>Организованный выезд из города и обратно.</p>
        </div>
        <div class="tour-service-card">
            <h3>Экскурсии</h3>
            <p>Сопровождение гида и безопасность маршрута.</p>
        </div>
        <div class="tour-service-card">
            <h3>Питание</h3>
            <p>Походные обеды и перекусы.</p>
        </div>
    </div>
</section>

<section class="tour-reviews">
    <h2>Отзывы участников</h2>

    <div class="tour-review-list">
        <?php foreach ($reviews as $review): ?>
            <article class="tour-review-card">
                <header>
                    <strong><?= Html::encode($review->user->fio ?? 'Участник') ?></strong>
                    <span class="tour-review-card__tour">
                        <?= Html::encode($review->tour->title ?? '') ?>
                    </span>
                    <span class="tour-review-card__rating">
                        <?= str_repeat('★', (int)$review->rating) ?>
                        <?= str_repeat('☆', 5 - (int)$review->rating) ?>
                    </span>
                </header>
                <p><?= Html::encode($review->text) ?></p>
                <time datetime="<?= date('Y-m-d', $review->created_at) ?>">
                    <?= Yii::$app->formatter->asDate($review->created_at) ?>
                </time>
            </article>
        <?php endforeach; ?>

        <?php if (empty($reviews)): ?>
            <p>Пока нет отзывов. Станьте первым!</p>
        <?php endif; ?>
    </div>
</section>

<section class="tour-contacts" id="contacts">
    <h2>Контакты</h2>
    <div class="tour-contacts__grid">
        <div>
            <p><strong>Адрес:</strong> г. Кунгур, ул. Туристическая, 1</p>
            <p><strong>Телефон:</strong> <a href="tel:+79000000000">+7 (900) 000‑00‑00</a></p>
            <p><strong>Email:</strong> <a href="mailto:info@weekendtours.ru">info@weekendtours.ru</a></p>
        </div>
        <div>
            <p>Работаем ежедневно с 9:00 до 20:00. Поможем подобрать идеальный тур выходного дня.</p>
        </div>
    </div>
</section>