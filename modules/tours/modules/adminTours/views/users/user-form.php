<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\User $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование пользователя: ' . $model->fullName();
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="tour-admin-box">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'first_name') ?>
    <?= $form->field($model, 'last_name') ?>
    <?= $form->field($model, 'patronymic') ?>
    <?= $form->field($model, 'phone') ?>
    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'address') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
