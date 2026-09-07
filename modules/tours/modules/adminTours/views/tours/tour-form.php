<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\Tours $model */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = $model->isNewRecord ? 'Новый тур' : 'Редактировать тур';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="tour-admin-box">
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'title') ?>
    <?= $form->field($model, 'short_description') ?>
    <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'price')->input('number', ['step' => '0.01']) ?>
    <?= $form->field($model, 'duration_days')->input('number', ['min' => 1]) ?>

    <?php if ($model->image): ?>
        <div class="mb-2">
            <label class="control-label">Текущее изображение</label><br>
            <img src="<?= Html::encode($model->image) ?>" alt="" style="max-width: 220px; border-radius: 0.75rem;">
        </div>
    <?php endif; ?>

    <?= $form->field($model, 'imageFile')->fileInput(['accept' => 'image/*'])
        ->label('Изображение тура') ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>