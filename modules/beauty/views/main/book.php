<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Бронирование услуги - Салон красоты Виктория';
?>
<div class="beauty-container">
    <div class="booking-container">
        <div class="booking-header">
            <h1>Бронирование услуги</h1>
            <p>Заполните форму для записи на услугу</p>
        </div>

        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success">
                <?= Yii::$app->session->getFlash('success') ?>
            </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger">
                <?= Yii::$app->session->getFlash('error') ?>
            </div>
        <?php endif; ?>

        <div class="booking-content">
            <div class="service-info">
                <h3>Выбранная услуга</h3>
                <div class="service-card">
                    <div class="service-image">
                        <?php if ($service->image): ?>
                            <img src="<?= $service->image ?>" alt="<?= Html::encode($service->name) ?>">
                        <?php endif; ?>
                    </div>
                    <div class="service-details">
                        <h4><?= Html::encode($service->name) ?></h4>
                        <p class="service-duration"><?= $service->duration ?> мин</p>
                        <p class="service-price"><?= number_format($service->price, 0, '.', ' ') ?> ₽</p>
                        <p class="service-description"><?= Html::encode($service->description) ?></p>
                    </div>
                </div>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'booking-form',
                'options' => ['class' => 'booking-form'],
            ]); ?>

                <?= $form->field($model, 'service_id')->hiddenInput()->label(false) ?>

                <div class="form-row">
                    <div class="form-group">
                        <?= $form->field($model, 'master_id', [
                            'inputOptions' => ['class' => 'form-control'],
                        ])->dropDownList(
                            \yii\helpers\ArrayHelper::map($masters, 'id', function($master) {
                                return $master->user->full_name . ' - ' . $master->specialization;
                            }),
                            ['prompt' => 'Выберите мастера']
                        )->label('Мастер') ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'appointment_date', [
                            'inputOptions' => ['class' => 'form-control', 'type' => 'date'],
                        ])->textInput()->label('Дата записи') ?>
                    </div>

                    <div class="form-group">
                        <?= $form->field($model, 'appointment_time', [
                            'inputOptions' => ['class' => 'form-control'],
                        ])->dropDownList([
                            '09:00' => '09:00',
                            '09:30' => '09:30',
                            '10:00' => '10:00',
                            '10:30' => '10:30',
                            '11:00' => '11:00',
                            '11:30' => '11:30',
                            '12:00' => '12:00',
                            '12:30' => '12:30',
                            '13:00' => '13:00',
                            '13:30' => '13:30',
                            '14:00' => '14:00',
                            '14:30' => '14:30',
                            '15:00' => '15:00',
                            '15:30' => '15:30',
                            '16:00' => '16:00',
                            '16:30' => '16:30',
                            '17:00' => '17:00',
                            '17:30' => '17:30',
                            '18:00' => '18:00',
                            '18:30' => '18:30',
                            '19:00' => '19:00',
                        ], ['prompt' => 'Выберите время'])->label('Время записи') ?>
                    </div>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'payment_method', [
                        'inputOptions' => ['class' => 'form-control'],
                    ])->dropDownList([
                        'cash' => 'Наличными',
                        'card' => 'Картой',
                        'online' => 'Онлайн',
                    ], ['prompt' => 'Выберите способ оплаты'])->label('Способ оплаты') ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'notes', [
                        'inputOptions' => ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Дополнительная информация...'],
                    ])->textarea()->label('Примечания') ?>
                </div>

                <div class="booking-summary">
                    <h4>Итого к оплате: <span class="total-price"><?= number_format($service->price, 0, '.', ' ') ?> ₽</span></h4>
                </div>

                <div class="form-actions">
                    <?= Html::a('Отмена', ['/beauty/catalog'], ['class' => 'btn btn-secondary']) ?>
                    <?= Html::submitButton('Записаться', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
