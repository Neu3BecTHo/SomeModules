<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var \app\modules\cleaner\models\OrderForm $model */
/** @var array $categories */

$this->title = 'Сформировать заявку';
?>

<div class="order-form-page">
    <h1 class="order-form-title"><?= Html::encode($this->title) ?></h1>
    <div class="order-form-subtitle">
        Заполните данные для оформления заявки на химчистку.
    </div>

    <div class="order-form-card">
        <?php $form = ActiveForm::begin([
            'id' => 'order-form',
        ]); ?>

        <?= $form->field($model, 'category_id')->dropDownList(
            $categories,
            [
                'prompt' => 'Выберите категорию услуги',
                'id' => 'order-category',
            ]
        )->label('Категория услуги') ?>

        <div id="block-general" class="order-form-block">
            <div class="order-form-group-title">Общая информация</div>

            <?= $form->field($model, 'address')->textInput()->label('Адрес проживания') ?>

            <?= $form->field($model, 'payment_type')->radioList([
                'cash'     => 'Наличный расчет',
                'cashless' => 'Безналичный расчет',
            ])->label('Способ оплаты') ?>
        </div>

        <div id="block-common-fields" class="order-form-block hidden-field">
            <div class="order-form-group-title">Вид и материал</div>

            <?= $form->field($model, 'item_type')->textInput()->label('Вид (обувь/одежда/мебель)') ?>
            <?= $form->field($model, 'material')->textInput()->label('Материал') ?>
        </div>

        <div id="block-furniture" class="order-form-block hidden-field">
            <div class="order-form-group-title">Мягкая мебель — детали</div>

            <?= $form->field($model, 'pollution_level')->textInput()->label('Степень загрязнения') ?>
        </div>

        <div id="block-carpet" class="order-form-block hidden-field">
            <div class="order-form-group-title">Ковровые покрытия — детали</div>

            <?= $form->field($model, 'carpet_size')->textInput()->label('Размер ковра') ?>
            <?= $form->field($model, 'pollution_level')->textInput()->label('Степень загрязнения') ?>
        </div>

        <div class="order-form-extra">
            <?= $form->field($model, 'extra_info_enabled')->checkbox([
                'id' => 'extra-info-toggle',
            ])->label('Дополнительная информация по услуге') ?>

            <div id="extra-info-block" class="hidden-field">
                <?= $form->field($model, 'extra_info')->textarea()->label('Комментарий') ?>
            </div>
        </div>

        <div class="form-group mt-3">
            <?= Html::submitButton('Отправить заявку', ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Отменить', ['order/index'], ['class' => 'btn btn-outline-secondary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
$js = <<<JS
function updateCategoryFields() {
    var val = $('#order-category').val();

    $('#block-common-fields').addClass('hidden-field');
    $('#block-furniture').addClass('hidden-field');
    $('#block-carpet').addClass('hidden-field');

    if (!val) {
        return;
    }

    if (val == '1' || val == '2') {
        // 1 — обувь, 2 — верхняя одежда
        $('#block-common-fields').removeClass('hidden-field');
    } else if (val == '3') {
        // мягкая мебель
        $('#block-common-fields').removeClass('hidden-field');
        $('#block-furniture').removeClass('hidden-field');
    } else if (val == '4') {
        // ковровые покрытия
        $('#block-carpet').removeClass('hidden-field');
    }
}

$('#order-category').on('change', updateCategoryFields);
updateCategoryFields();

$('#extra-info-toggle').on('change', function() {
    if ($(this).is(':checked')) {
        $('#extra-info-block').removeClass('hidden-field');
    } else {
        $('#extra-info-block').addClass('hidden-field');
    }
});
JS;

$this->registerJs($js);