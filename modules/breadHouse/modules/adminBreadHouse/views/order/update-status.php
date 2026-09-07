<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\breadHouse\models\Orders */

$this->title = 'Изменить статус заказа #' . $model->id;
?>
<div class="admin-order-update-status">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="order-status-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'status_id')->dropDownList(
            \yii\helpers\ArrayHelper::map(
                \app\modules\breadHouse\models\Statuses::find()->all(),
                'id',
                'title'
            ),
            ['prompt' => 'Выберите статус']
        ) ?>

        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
            <?= Html::a('Отмена', ['view', 'id' => $model->id], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
