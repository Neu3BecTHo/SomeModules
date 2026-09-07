<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Вход — Химчистка';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card__logo">
            <div class="auth-card__logo-circle">
                Х
            </div>
        </div>
        <div class="auth-card__title">Вход</div>
        <div class="auth-card__subtitle">
            Введите телефон и пароль для входа в личный кабинет.
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'enableClientValidation' => true,
        ]); ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::className(), [
            'mask' => '8(999)999-99-99',
        ])->label('Телефон') ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'rememberMe')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Войти', ['class' => 'btn btn-primary auth-btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="auth-card__footer">
            Еще не зарегистрированы?
            <?= Html::a('Регистрация', ['auth/register']) ?>
        </div>
    </div>
</div>