<?php

use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var \yii\web\View $this */
/** @var \app\models\LoginForm $model */

$this->title = 'Вход';

?>

<div class="hr-auth">
    <h1 class="hr-auth__title">Вход в систему</h1>
    <p class="hr-auth__subtitle">
        Используйте адрес электронной почты и пароль, указанные при регистрации.
    </p>

    <div class="hr-auth__card">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['class' => 'hr-form'],
            'fieldConfig' => [
                'options' => ['class' => 'hr-form__field'],
                'labelOptions' => ['class' => 'hr-form__label'],
                'inputOptions' => ['class' => 'hr-form__input'],
                'errorOptions' => ['class' => 'hr-form__error'],
            ],
        ]); ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'name@example.com']) ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <div class="hr-form__actions">
            <button type="submit" class="hr-btn hr-btn_primary">Войти</button>
        </div>

        <div class="hr-auth__switch">
            Еще не зарегистрированы?
            <a href="<?= Url::to(['auth/register']) ?>">Регистрация</a>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
