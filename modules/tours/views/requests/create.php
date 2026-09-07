<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\RequestForm $model */
/** @var app\modules\tours\models\Tours[] $tours */

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Оформление заявки';
?>

<h1>Оформление заявки</h1>

<div class="tour-auth">
    <?php $form = ActiveForm::begin([
        'id' => 'tours-request-form',
    ]); ?>

    <?= $form->field($model, 'tour_id')->dropDownList(
        ArrayHelper::map($tours, 'id', 'title'),
        ['prompt' => 'Выберите тур']
    ) ?>

    <?= $form->field($model, 'date')->input('date') ?>

    <?= $form->field($model, 'participants_count')->input('number', ['min' => 1, 'max' => 50]) ?>

    <?= $form->field($model, 'options')->checkboxList([
        'transfer' => 'Трансфер',
        'excursions' => 'Экскурсии',
        'food' => 'Питание',
    ])->label('Дополнительные опции') ?>

    <?= $form->field($model, 'wishes')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>

    <?= $form->field($model, 'payment_method')->dropDownList([
        'card_online' => 'Банковская карта онлайн',
        'cash_office' => 'Наличные в офисе',
        'transfer_bill' => 'Перевод по реквизитам',
    ], ['prompt' => 'Выберите способ оплаты']) ?>

    <div class="form-group">
        <?= Html::submitButton('Подтвердить заявку', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
