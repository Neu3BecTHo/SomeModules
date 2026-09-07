<?php

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\photoshoot\models\Review */
/* @var $booking app\modules\photoshoot\models\Booking */

$this->title = 'Оставить отзыв';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="service-card">
                <p class="mb-4">Оставьте отзыв о бронировании #<?= $booking->id ?> (<?= Yii::$app->formatter->asDate($booking->booking_date) ?>)</p>

                <?php $form = ActiveForm::begin(); ?>

                <?= $form->field($model, 'rating')->dropDownList([
                    5 => '★★★★★ Отлично',
                    4 => '★★★★☆ Хорошо',
                    3 => '★★★☆☆ Удовлетворительно',
                    2 => '★★☆☆☆ Плохо',
                    1 => '★☆☆☆☆ Очень плохо',
                ]) ?>

                <?= $form->field($model, 'comment')->textarea(['rows' => 5, 'placeholder' => 'Расскажите о вашем опыте...']) ?>

                <div class="form-group text-center">
                    <?= Html::submitButton('Отправить отзыв', ['class' => 'btn btn-primary-custom btn-lg']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
