<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\breadHouse\models\Product */

$this->title = 'Создать товар';
?>
<div class="admin-product-create">
    <h1><?= Html::encode($this->title) ?></h1>
    
    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert alert-danger">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <div class="product-form">
        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'category_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \app\modules\breadHouse\models\Categories::find()->all(),
                'id',
                'title'
            ),
            ['prompt' => 'Выберите категорию']
        ) ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 4]) ?>

        <?= $form->field($model, 'price')->textInput(['type' => 'number', 'step' => '0.01']) ?>

        <?= $form->field($model, 'stock')->textInput(['type' => 'number', 'value' => $model->stock ?? 0]) ?>

        <?= $form->field($model, 'composition')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'allergens')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nutrition')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'imageFiles')->fileInput(['accept' => 'image/*', 'multiple' => true]) ?>

        <p class="help-block">Можно загрузить до 5 изображений. Первое изображение будет главным. Максимальный размер файла: 2MB.</p>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
