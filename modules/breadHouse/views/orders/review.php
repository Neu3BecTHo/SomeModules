<?php
/** @var yii\web\View $this */
/** @var app\modules\breadHouse\models\Reviews $model */
/** @var app\modules\breadHouse\models\Orders $order */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Отзыв о заказе';
?>

<div class="review-page">
    <div class="bh-container">
        <h1 class="bh-page-title">⭐ <?= Html::encode($this->title) ?></h1>

        <div class="review-content bh-card">
            <?php $form = ActiveForm::begin(['options' => ['class' => 'bh-form review-form']]); ?>

                <div class="form-group rating-group">
                    <label class="control-label">Ваша оценка</label>
                    <div class="star-rating">
                        <?php for ($i = 5; $i >= 1; $i--): ?>
                            <input type="radio" id="star<?= $i ?>" name="Reviews[rating]" value="<?= $i ?>">
                            <label for="star<?= $i ?>" title="<?= $i ?> <?= $i == 1 ? 'звезда' : ($i < 5 ? 'звезды' : 'звезд') ?>">★</label>
                        <?php endfor; ?>
                    </div>
                </div>

                <?= $form->field($model, 'text')->textarea(['rows' => 5, 'placeholder' => 'Расскажите о вашем опыте...'])->label('Ваш отзыв') ?>

                <div class="form-actions">
                    <?= Html::submitButton('⭐ Отправить отзыв', ['class' => 'bh-btn bh-btn--primary bh-btn--large']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<style>
.review-page {
    max-width: 600px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.rating-group {
    text-align: center;
    margin-bottom: 2rem;
}

.rating-group .control-label {
    display: block;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--bh-dark);
}

.star-rating {
    display: inline-flex;
    flex-direction: row-reverse;
    gap: 0.5rem;
}

.star-rating input {
    display: none;
}

.star-rating label {
    font-size: 2.5rem;
    color: #ddd;
    cursor: pointer;
    transition: all 0.2s ease;
    line-height: 1;
}

/* Hover effects */
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: #ffc107;
    transform: scale(1.1);
}

/* Selected state */
.star-rating input:checked ~ label {
    color: #ffc107;
}

/* Hover after selection */
.star-rating input:checked + label:hover,
.star-rating input:checked + label:hover ~ label,
.star-rating input:checked ~ label:hover,
.star-rating input:checked ~ label:hover ~ label {
    color: #ff9800;
    transform: scale(1.15);
}

.review-form textarea {
    resize: vertical;
    min-height: 120px;
}

.form-actions {
    text-align: center;
    margin-top: 2rem;
}

.form-actions .bh-btn {
    min-width: 200px;
}
</style>
