<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\RegisterForm $model */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;

$this->title = 'Регистрация';
?>

<h1>Регистрация</h1>

<div class="tour-auth">
    <?php $form = ActiveForm::begin([
        'id' => 'tours-register-form',
        'enableClientValidation' => true,
    ]); ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'patronymic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->widget(MaskedInput::class, ['mask' => '+7(999)999-99-99']) ?>

    <?= $form->field($model, 'email')->input('email') ?>

    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'passport_series')->textInput(['maxlength' => 4]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'passport_number')->textInput(['maxlength' => 6]) ?>
        </div>
    </div>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'password_repeat')->passwordInput() ?>

    <?= $form->field($model, 'agree')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary']) ?>
    </div>

    <p class="tour-auth__switch">
        Уже зарегистрированы?
        <a href="<?= Url::to(['login']) ?>">Войти</a>
    </p>

    <?php ActiveForm::end(); ?>
</div>
