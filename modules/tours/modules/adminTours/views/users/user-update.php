<?php
/** @var yii\web\View $this */
/** @var yii\base\DynamicModel $formModel */
/** @var app\modules\tours\models\User $user */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактирование пользователя: ' . $user->fullName();
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="tour-admin-box">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($formModel, 'first_name') ?>
    <?= $form->field($formModel, 'last_name') ?>
    <?= $form->field($formModel, 'patronymic') ?>
    <?= $form->field($formModel, 'phone') ?>
    <?= $form->field($formModel, 'email') ?>
    <?= $form->field($formModel, 'address') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
