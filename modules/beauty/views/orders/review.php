<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Оставить отзыв - Салон красоты Виктория';
?>
<div class="beauty-container">
    <div class="review-container">
        <div class="review-header">
            <h1>Оставить отзыв</h1>
            <p>Поделитесь впечатлениями о посещении салона</p>
        </div>

        <div class="order-info">
            <h3>Информация о заказе</h3>
            <div class="order-details">
                <div class="detail-item">
                    <span class="label">Заказ:</span>
                    <span class="value">#<?= $order->id ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Услуга:</span>
                    <span class="value"><?= Html::encode($order->service->name) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Мастер:</span>
                    <span class="value"><?= Html::encode($order->master->user->full_name) ?></span>
                </div>
                <div class="detail-item">
                    <span class="label">Дата:</span>
                    <span class="value"><?= Yii::$app->formatter->asDate($order->appointment_date, 'd MMMM yyyy') ?></span>
                </div>
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'review-form',
            'options' => ['class' => 'review-form'],
        ]); ?>

            <?= $form->field($model, 'order_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'client_id')->hiddenInput()->label(false) ?>
            <?= $form->field($model, 'master_id')->hiddenInput()->label(false) ?>

            <div class="form-group">
                <label class="form-label">Оценка</label>
                <div class="rating-input">
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <input type="radio" name="<?= Html::getInputName($model, 'rating') ?>" value="<?= $i ?>" id="rating-<?= $i ?>" <?= $model->rating == $i ? 'checked' : '' ?>>
                        <label for="rating-<?= $i ?>" class="rating-star">
                            <i class="icon-star"></i>
                        </label>
                    <?php endfor; ?>
                </div>
                <?= $form->field($model, 'rating')->hiddenInput()->label(false) ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'comment', [
                    'inputOptions' => ['class' => 'form-control', 'rows' => 6, 'placeholder' => 'Расскажите о вашем опыте...'],
                ])->textarea()->label('Комментарий') ?>
            </div>

            <div class="form-actions">
                <?= Html::a('Отмена', ['/beauty/orders/view', 'id' => $order->id], ['class' => 'btn btn-secondary']) ?>
                <?= Html::submitButton('Отправить отзыв', ['class' => 'btn btn-primary']) ?>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
