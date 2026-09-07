<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация — Химчистка';
?>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="auth-card__logo">
            <div class="auth-card__logo-circle">
                Х
            </div>
        </div>
        <div class="auth-card__title">Регистрация</div>
        <div class="auth-card__subtitle">
            Создайте аккаунт, чтобы оформить заявку на химчистку.
        </div>

        <?php $form = ActiveForm::begin([
            'id' => 'form-register',
            'enableClientValidation' => true,
        ]); ?>

        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::class, [
            'mask' => '8(999)999-99-99',
        ]) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>
        <?= $form->field($model, 'password_repeat')->passwordInput() ?>

        <?= $form->field($model, 'agree')->checkbox() ?>

        <div class="form-group">
            <?= Html::submitButton('Создать пользователя', ['class' => 'btn btn-primary auth-btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <div class="auth-card__footer">
            Уже зарегистрированы?
            <?= Html::a('Войти', ['auth/login']) ?>
        </div>
    </div>
</div>