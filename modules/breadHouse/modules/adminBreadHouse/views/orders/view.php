<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\Orders $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Заявки'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Изменить'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Удалить'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Вы уверены, что хотите удалить эту заявку?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            ['attribute' => 'user_id', 'value' => function ($model) {
                return $model->user->first_name . ' ' . $model->user->last_name;
            }],
            ['attribute' => 'category_id', 'value' => function ($model) {
                return $model->category->title;
            }],
            ['attribute' => 'status_id', 'value' => function ($model) {
                return $model->status->title;
            }],
            'address',
            'payment_type',
            'extra_info:ntext',
            'item_type',
            'material',
            'pollution_level',
            'carpet_size',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
