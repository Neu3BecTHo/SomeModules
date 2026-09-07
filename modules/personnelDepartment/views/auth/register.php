<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

/** @var \yii\web\View $this */
/** @var \app\models\RegisterForm $model */

$this->title = 'Регистрация';

?>

<div class="hr-auth">
    <h1 class="hr-auth__title">Регистрация сотрудника</h1>
    <p class="hr-auth__subtitle">
        Заполните данные для доступа к системе «Отдел кадров».
    </p>

    <div class="hr-auth__card">
        <?php $form = ActiveForm::begin([
            'id' => 'register-form',
            'options' => ['class' => 'hr-form'],
            'fieldConfig' => [
                'options' => ['class' => 'hr-form__field'],
                'labelOptions' => ['class' => 'hr-form__label'],
                'inputOptions' => ['class' => 'hr-form__input'],
                'errorOptions' => ['class' => 'hr-form__error'],
            ],
        ]); ?>

        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'placeholder' => 'Иван']) ?>
        <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'placeholder' => 'Иванов']) ?>
        <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true, 'placeholder' => 'Иванович']) ?>

        <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '+7(999)999-99-99']) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'name@example.com']) ?>

        <div class="hr-form__row">
            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>
        </div>

        <div class="hr-form__checkbox-row">
            <?= $form->field($model, 'rules')->checkbox([
                'label' => 'Согласен с правилами регистрации',
                'labelOptions' => ['class' => 'hr-form__checkbox-label'],
                'class' => 'hr-form__checkbox-wrapper',
            ])->label(false) ?>
        </div>

        <div class="hr-form__actions">
            <button type="submit" class="hr-btn hr-btn_primary">Создать пользователя</button>
        </div>

        <div class="hr-auth__switch">
            Уже зарегистрированы?
            <a href="<?= Url::to(['auth/login']) ?>">Войти</a>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
