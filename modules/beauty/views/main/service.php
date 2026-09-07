<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Об услуге - Салон красоты Виктория';
?>
<div class="beauty-container">
    <section class="service-page">
        <div class="container">
            <div class="service-header">
                <div class="service-image">
                    <?php if ($service->image): ?>
                        <img src="<?= $service->image ?>" alt="<?= Html::encode($service->name) ?>">
                    <?php endif; ?>
                </div>
                <div class="service-info">
                    <h1><?= Html::encode($service->name) ?></h1>
                    <div class="service-meta">
                        <div class="service-duration">
                            <i class="icon-clock"></i>
                            <span><?= $service->duration ?> минут</span>
                        </div>
                        <div class="service-price">
                            <i class="icon-ruble"></i>
                            <span><?= number_format($service->price, 0, '.', ' ') ?> ₽</span>
                        </div>
                        <div class="service-category">
                            <i class="icon-folder"></i>
                            <span><?= Html::encode($service->category->name) ?></span>
                        </div>
                    </div>
                    <div class="service-actions">
                        <?= Html::a('Записаться', ['/beauty/main/book', 'service_id' => $service->id], ['class' => 'btn btn-primary btn-large']) ?>
                        <?= Html::a('Назад к каталогу', ['/beauty/main/catalog'], ['class' => 'btn btn-outline']) ?>
                    </div>
                </div>
            </div>

            <div class="service-content">
                <div class="service-description">
                    <h2>Описание услуги</h2>
                    <p><?= Html::encode($service->description) ?></p>
                </div>

                <?php if (!empty($service->masters)): ?>
                    <div class="service-masters">
                        <h2>Мастера, выполняющие услугу</h2>
                        <div class="masters-list">
                            <?php foreach ($service->masters as $master): ?>
                                <div class="master-item">
                                    <div class="master-photo">
                                        <?php if ($master->photo): ?>
                                            <img src="<?= $master->photo ?>" alt="<?= Html::encode($master->user->full_name) ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="master-details">
                                        <h3><?= Html::encode($master->user->full_name) ?></h3>
                                        <p class="master-specialization"><?= Html::encode($master->specialization) ?></p>
                                        <div class="master-rating">
                                            <span class="stars">★★★★★</span>
                                            <span class="rating-value"><?= number_format($master->rating, 1) ?></span>
                                        </div>
                                        <div class="master-actions">
                                            <?= Html::a('Подробнее', ['/beauty/main/master', 'id' => $master->id], ['class' => 'btn btn-outline btn-sm']) ?>
                                            <?= Html::a('Записаться', ['/beauty/main/book', 'service_id' => $service->id, 'master_id' => $master->id], ['class' => 'btn btn-primary btn-sm']) ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php 
                $reviews = \app\modules\beauty\models\Review::find()
                    ->where(['master_id' => array_map(function($m) { return $m->id; }, $service->masters)])
                    ->with(['client', 'master'])
                    ->orderBy(['created_at' => SORT_DESC])
                    ->limit(5)
                    ->all();
                ?>
                <?php if (!empty($reviews)): ?>
                    <div class="service-reviews">
                        <h2>Отзывы об услуге</h2>
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
