<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use app\modules\photoshoot\models\Booking;

/* @var $this yii\web\View */
/* @var $model app\modules\photoshoot\models\Booking */

$this->title = 'Забронировать';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="service-card">
                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'service_type')->dropDownList(Booking::getServiceTypeLabels(), [
                    'prompt' => 'Выберите услугу',
                    'id' => 'booking-service_type'
                ]) ?>

                <div id="hall-container" style="display: none;">
                    <?= $form->field($model, 'hall_type')->dropDownList(Booking::getHallTypeLabels(), ['prompt' => 'Выберите зал']) ?>
                </div>

                <div id="session-container" style="display: none;">
                    <?= $form->field($model, 'photo_session_type')->dropDownList(Booking::getSessionTypeLabels(), ['prompt' => 'Выберите тип фотосессии']) ?>
                </div>

                <?= $form->field($model, 'duration')->dropDownList(Booking::getDurationLabels(), ['prompt' => 'Выберите длительность']) ?>

                <?= $form->field($model, 'booking_date')->textInput(['type' => 'datetime-local']) ?>

                <?= $form->field($model, 'people_count')->input('number', ['min' => 1, 'max' => 20]) ?>

                <?= $form->field($model, 'wishes')->textarea(['rows' => 3, 'placeholder' => 'Ваши пожелания']) ?>

                <?= $form->field($model, 'payment_method')->dropDownList(Booking::getPaymentMethodLabels()) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Забронировать', ['class' => 'btn btn-primary-custom btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$js = <<<JS
$('#booking-service_type').change(function() {
    var val = $(this).val();
    if (val === 'rent' || val === 'photoshoot') {
        $('#hall-container').show();
    } else {
        $('#hall-container').hide();
    }
    if (val === 'photoshoot') {
        $('#session-container').show();
    } else {
        $('#session-container').hide();
    }
});
JS;
$this->registerJs($js);
?>
