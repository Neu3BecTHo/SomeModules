<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;
use yii\widgets\MaskedInput;
BeautyAsset::register($this);

$this->title = 'Регистрация - Салон красоты Виктория';
?>
<div class="beauty-container">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h1>Регистрация</h1>
                <p>Создайте аккаунт для записи на услуги</p>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'register-form',
                'options' => ['class' => 'auth-form'],
            ]); ?>

                <?= $form->field($model, 'phone', [
                    'options' => ['class' => 'form-group'],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => '+7(XXX)XXX-XX-XX'],
                ])->widget(MaskedInput::class, [
                    'mask' => '+7(999)999-99-99',
                ]) ?>

                <?= $form->field($model, 'full_name', [
                    'options' => ['class' => 'form-group'],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Иванов Иван Иванович'],
                ])->textInput(['maxlength' => true])->label('ФИО') ?>

                <?= $form->field($model, 'role', [
                    'options' => ['class' => 'form-group'],
                ])->dropDownList([
                    'client' => 'Клиент',
                    'master' => 'Мастер',
                ], ['prompt' => 'Выберите роль'])->label('Роль') ?>

                <?= $form->field($model, 'password', [
                    'options' => ['class' => 'form-group'],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Минимум 8 символов'],
                ])->passwordInput()->label('Пароль') ?>

                <?= $form->field($model, 'password_repeat', [
                    'options' => ['class' => 'form-group'],
                    'inputOptions' => ['class' => 'form-control', 'placeholder' => 'Повторите пароль'],
                ])->passwordInput()->label('Повтор пароля') ?>

                <?= $form->field($model, 'agree', [
                    'options' => ['class' => 'form-group'],
                ])->checkbox(['label' => 'Согласен с политикой конфиденциальности'])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary btn-block']) ?>
                </div>

                <div class="auth-links">
                    <p>Уже есть аккаунт? <?= Html::a('Войти', ['/beauty/login']) ?></p>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
