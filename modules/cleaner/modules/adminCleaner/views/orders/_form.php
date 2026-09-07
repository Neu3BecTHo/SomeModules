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

<?php $form = ActiveForm::begin(['options' => ['class' => 'admin-form']]); ?>

<div class="form-row">
    <div class="form-col">
        <label class="form-label">📁 Категория</label>
        <?= $form->field($model, 'category_id', ['template' => '{input}{error}'])->dropDownList(
            ArrayHelper::map(Categories::find()->all(), 'id', 'title'),
            ['class' => 'form-input']
        ) ?>
    </div>
    <div class="form-col">
        <label class="form-label">📊 Статус</label>
        <?= $form->field($model, 'status_id', ['template' => '{input}{error}'])->dropDownList(
            ArrayHelper::map(Statuses::find()->all(), 'id', 'title'),
            ['class' => 'form-input']
        ) ?>
    </div>
</div>

<label class="form-label">📍 Адрес</label>
<?= $form->field($model, 'address', ['template' => '{input}{error}'])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>

<label class="form-label">📝 Дополнительная информация</label>
<?= $form->field($model, 'extra_info', ['template' => '{input}{error}'])->textarea(['rows' => 4, 'class' => 'form-textarea']) ?>

<div class="form-row">
    <div class="form-col">
        <label class="form-label">👕 Тип вещи</label>
        <?= $form->field($model, 'item_type', ['template' => '{input}{error}'])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>
    <div class="form-col">
        <label class="form-label">🧵 Материал</label>
        <?= $form->field($model, 'material', ['template' => '{input}{error}'])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>
</div>

<div class="form-row">
    <div class="form-col">
        <label class="form-label">🦠 Уровень загрязнения</label>
        <?= $form->field($model, 'pollution_level', ['template' => '{input}{error}'])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>
    <div class="form-col">
        <label class="form-label">📐 Размер ковра</label>
        <?= $form->field($model, 'carpet_size', ['template' => '{input}{error}'])->textInput(['maxlength' => true, 'class' => 'form-input']) ?>
    </div>
</div>

<div class="form-group" style="margin-top: 32px; display: flex; gap: 12px;">
    <?= Html::submitButton('💾 Сохранить', ['class' => 'btn btn-primary']) ?>
    <?= Html::a('❌ Отмена', ['index'], ['class' => 'btn btn-secondary']) ?>
</div>

<?php ActiveForm::end(); ?>
