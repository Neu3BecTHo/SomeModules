<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;
use yii\widgets\MaskedInput;

BeautyAsset::register($this);

$this->title = 'Вход - Салон красоты Виктория';
?>
<div class="beauty-container">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Вход в личный кабинет</h1>
                <p>Введите свои данные для входа</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => ['class' => 'auth-form'],
            ]); ?>

                <?= $form->field($model, 'phone', [
                    'options' => ['class' => 'form-group'],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => '+7(XXX)XXX-XX-XX'],
                ])->widget(MaskedInput::class, [
                    'mask' => '+7(999)999-99-99',
                ]) ?>

                <?= $form->field($model, 'password', [
                    'options' => ['class' => 'form-group'],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Введите пароль'],
                ])->passwordInput()->label('Пароль') ?>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block']) ?>
                </div>

                <div class="auth-links">
                    <p>Еще нет аккаунта? <?= Html::a('Зарегистрироваться', ['/beauty/register']) ?></p>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
