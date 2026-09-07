<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\Orders $model */

$this->title = Yii::t('app', 'Создать заявку');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заявки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="orders-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
