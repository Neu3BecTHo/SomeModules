<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\Tours $model */
/** @var app\modules\tours\models\Reviews[] $reviews */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $model->title;
?>

<article class="tour-detail">
    <div class="tour-detail__header">
        <div class="tour-detail__image"
             style="background-image: url('<?= Html::encode($model->image ?: '/images/tours/default.jpg') ?>')">
        </div>
        <div class="tour-detail__summary">
            <h1><?= Html::encode($model->title) ?></h1>
            <p class="tour-detail__short">
                <?= Html::encode($model->short_description) ?>
            </p>
            <div class="tour-detail__meta">
                <div>
                    <span class="label">Стоимость:</span>
                    <span class="value">
                        <?= Yii::$app->formatter->asCurrency($model->price, 'RUB') ?>
                    </span>
                </div>
                <?php if ($model->duration_days): ?>
                    <div>
                        <span class="label">Длительность:</span>
                        <span class="value"><?= (int)$model->duration_days ?> дн.</span>
                    </div>
                <?php endif; ?>
            </div>

            <a href="<?= Url::to(['request/create', 'tourId' => $model->id]) ?>" class="btn btn-primary">
                Забронировать
            </a>
        </div>
    </div>

    <section class="tour-detail__program">
        <h2>Описание и программа тура</h2>
        <div class="tour-detail__text">
            <?= Yii::$app->formatter->asNtext($model->description) ?>
        </div>
    </section>

    <section class="tour-detail__reviews" id="reviews">
        <h2>Отзывы участников</h2>

        <?php if (!empty($reviews)): ?>
            <div class="tour-review-list">
                <?php foreach ($reviews as $review): ?>
                    <article class="tour-review-card">
                        <header>
                            <strong><?= Html::encode($review->user->fio ?? 'Участник') ?></strong>
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
            </div>
        <?php else: ?>
            <p>Пока нет отзывов. После поездки вы сможете оставить свой отзыв в разделе
                «<a href="<?= Url::to(['request/my']) ?>">Мои заявки</a>».</p>
        <?php endif; ?>
    </section>
</article>
