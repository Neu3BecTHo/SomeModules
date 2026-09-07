<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\cleaner\models\Categories;
use app\modules\cleaner\models\Statuses;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\Orders $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Categories::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'status_id')->dropDownList(ArrayHelper::map(Statuses::find()->all(), 'id', 'title')) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'extra_info')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'item_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'material')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pollution_level')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'carpet_size')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Применить'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
