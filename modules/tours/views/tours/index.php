<?php
/** @var yii\web\View $this */
/** @var app\modules\tours\models\ToursSearch $searchModel */
/** @var app\modules\tours\models\Tours[] $tours */

use app\modules\tours\assets\ToursToursAsset;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

ToursToursAsset::register($this);

$this->title = 'Каталог туров';
?>

<h1>Каталог туров</h1>

<div class="tour-filter">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'action' => ['tours/index'],
        'options' => ['class' => 'tour-filter__form'],
    ]); ?>

    <?= $form->field($searchModel, 'date_from')->input('date')->label('Дата с') ?>
    <?= $form->field($searchModel, 'date_to')->input('date')->label('Дата по') ?>

    <?= $form->field($searchModel, 'price_from')->input('number', ['min' => 0])->label('Цена от') ?>
    <?= $form->field($searchModel, 'price_to')->input('number', ['min' => 0])->label('Цена до') ?>

    <div class="tour-filter__actions">
        <button type="submit" class="btn btn-primary">Фильтровать</button>
        <a href="<?= Url::to(['tours/index']) ?>" class="btn btn-outline">Сбросить</a>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<div class="tour-card-grid catalog-grid">
    <?php if ($tours): ?>
        <?php foreach ($tours as $tour): ?>
            <?= $this->render('_tour_card', ['tour' => $tour]) ?>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Туры по заданным параметрам не найдены.</p>
    <?php endif; ?>
</div>
