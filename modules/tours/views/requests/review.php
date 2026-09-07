<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\Reviews $model */
/** @var app\modules\tours\models\Requests $request */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Отзыв о туре';
?>

<h1>Отзыв о туре «<?= Html::encode($request->tour->title ?? '') ?>»</h1>

<div class="tour-auth">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rating')->dropDownList([
        5 => '5 — отлично',
        4 => '4 — хорошо',
        3 => '3 — нормально',
        2 => '2 — плохо',
        1 => '1 — ужасно',
    ]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить отзыв', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
