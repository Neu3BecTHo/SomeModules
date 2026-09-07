<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\breadHouse\models\Product */

$this->title = 'Редактировать товар';
?>
<div class="admin-product-update">
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

        <?= $form->field($model, 'stock')->textInput(['type' => 'number']) ?>

        <?= $form->field($model, 'composition')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'allergens')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nutrition')->textInput(['maxlength' => true]) ?>

        <?php 
        $allImages = $model->getAllImages();
        if (!empty($allImages)): 
        ?>
            <div class="current-images">
                <p>Текущие изображения:</p>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
                    <?php foreach ($allImages as $index => $image): ?>
                        <div style="text-align: center;">
                            <img src="<?= $image ?>" alt="<?= Html::encode($model->name) ?>" style="max-width: 150px; height: auto; border-radius: 4px;">
                            <small><?= $index == 0 ? 'Главное' : 'Доп.' ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?= $form->field($model, 'imageFiles')->fileInput(['accept' => 'image/*', 'multiple' => true]) ?>

        <p class="help-block">Можно загрузить до 5 изображений. Первое изображение будет главным. Максимальный размер файла: 2MB.</p>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
