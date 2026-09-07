<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Мастер - Салон красоты Виктория';
?>
<div class="beauty-container">
    <section class="master-page">
        <div class="container">
            <div class="master-header">
                <div class="master-photo">
                    <?php if ($master->photo): ?>
                        <img src="<?= $master->photo ?>" alt="<?= Html::encode($master->user->full_name) ?>">
                    <?php endif; ?>
                </div>
                <div class="master-info">
                    <h1><?= Html::encode($master->user->full_name) ?></h1>
                    <p class="master-specialization"><?= Html::encode($master->specialization) ?></p>
                    <div class="master-rating">
                        <span class="stars"><?= str_repeat('★', round($master->rating)) ?></span>
                        <span class="rating-value"><?= number_format($master->rating, 1) ?>/5</span>
                        <span class="reviews-count">(<?= \app\modules\beauty\models\Review::find()->where(['master_id' => $master->id])->count() ?> отзывов)</span>
                    </div>
                    <div class="master-actions">
                        <?= Html::a('Записаться', ['/beauty/main/book', 'master_id' => $master->id], ['class' => 'btn btn-primary btn-large']) ?>
                    </div>
                </div>
            </div>

            <div class="master-content">
                <div class="master-bio">
                    <h2>О мастере</h2>
                    <p><?= Html::encode($master->bio) ?></p>
                </div>

                <?php if (!empty($master->services)): ?>
                    <div class="master-services">
                        <h2>Услуги мастера</h2>
                        <div class="services-grid">
                            <?php foreach ($master->services as $service): ?>
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
                                        <?= Html::a('Записаться', ['/beauty/main/book', 'service_id' => $service->id, 'master_id' => $master->id], ['class' => 'btn btn-primary']) ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($master->schedule)): ?>
                    <div class="master-schedule">
                        <h2>Расписание работы</h2>
                        <div class="schedule-grid">
                            <?php 
                            $days = [
                                1 => 'Понедельник',
                                2 => 'Вторник', 
                                3 => 'Среда',
                                4 => 'Четверг',
                                5 => 'Пятница',
                                6 => 'Суббота',
                                7 => 'Воскресенье'
                            ];
                            ?>
                            <?php foreach ($master->schedule as $schedule): ?>
                                <div class="schedule-item">
                                    <div class="day-name"><?= $days[$schedule->day_of_week] ?></div>
                                    <div class="day-time">
                                        <?php if ($schedule->is_available): ?>
                                            <?= $schedule->start_time ?> - <?= $schedule->end_time ?>
                                        <?php else: ?>
                                            Выходной
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($master->photos)): ?>
                    <div class="master-gallery">
                        <h2>Работы мастера</h2>
                        <div class="gallery-grid">
                            <?php foreach ($master->photos as $photo): ?>
                                <div class="gallery-item">
                                    <img src="<?= $photo->image ?>" alt="<?= Html::encode($photo->title) ?>" class="gallery-image">
                                    <div class="gallery-caption">
                                        <h4><?= Html::encode($photo->title) ?></h4>
                                        <p><?= Html::encode($photo->description) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (!empty($master->certificates)): ?>
                    <div class="master-certificates">
                        <h2>Сертификаты и дипломы</h2>
                        <div class="certificates-grid">
                            <?php foreach ($master->certificates as $certificate): ?>
                                <div class="certificate-item">
                                    <img src="<?= $certificate->image ?>" alt="<?= Html::encode($certificate->title) ?>" class="certificate-image">
                                    <div class="certificate-info">
                                        <h4><?= Html::encode($certificate->title) ?></h4>
                                        <p>Дата выдачи: <?= Yii::$app->formatter->asDate($certificate->issued_date, 'd MMMM yyyy') ?></p>
                                        <?php if ($certificate->expiry_date): ?>
                                            <p>Действителен до: <?= Yii::$app->formatter->asDate($certificate->expiry_date, 'd MMMM yyyy') ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php 
                $reviews = \app\modules\beauty\models\Review::find()
                    ->where(['master_id' => $master->id])
                    ->with(['client'])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->all();
                ?>
                <?php if (!empty($reviews)): ?>
                    <div class="master-reviews">
                        <h2>Отзывы о мастере</h2>
                        <div class="reviews-list">
                            <?php foreach ($reviews as $review): ?>
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="review-author">
                                            <div class="author-avatar">
                                                <i class="icon-user"></i>
                                            </div>
                                            <div class="author-info">
                                                <h4><?= Html::encode($review->client->full_name) ?></h4>
                                                <p class="review-date"><?= Yii::$app->formatter->asDate($review->created_at, 'd MMMM yyyy') ?></p>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <span class="stars"><?= str_repeat('★', $review->rating) ?></span>
                                            <span class="rating-value"><?= $review->rating ?>/5</span>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p><?= Html::encode($review->comment) ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
