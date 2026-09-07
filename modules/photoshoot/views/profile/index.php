<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\photoshoot\models\User */

$this->title = 'Профиль';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="service-card">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'login')->textInput(['disabled' => true]) ?>

                <?= $form->field($model, 'full_name')->textInput() ?>

                <?= $form->field($model, 'phone')->textInput() ?>

                <?= $form->field($model, 'email')->textInput() ?>

                <?= $form->field($model, 'password')->passwordInput(['value' => ''])->hint('Оставьте пустым, чтобы не менять пароль') ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary-custom btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
