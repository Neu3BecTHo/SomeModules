<?php
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Мои заявки';
?>

<h1>Мои заявки</h1>

<p>
    <a href="<?= Url::to(['create']) ?>" class="btn btn-primary">Новая заявка</a>
</p>

<div class="tour-auth">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-dark table-sm'],
        'columns' => [
            [
                'attribute' => 'tour_id',
                'label' => 'Тур',
                'value' => function ($model) {
                    return $model->tour->title ?? '(удалённый тур)';
                },
            ],
            [
                'attribute' => 'date',
                'label' => 'Дата поездки',
                'format' => ['date', 'php:d.m.Y'],
            ],
            [
                'attribute' => 'participants_count',
                'label' => 'Участников',
            ],
            [
                'attribute' => 'status',
                'label' => 'Статус',
                'value' => function ($model) {
                    switch ($model->status) {
                        case 'in_review': return 'На рассмотрении';
                        case 'accepted':  return 'Заявка принята';
                        case 'new':
                        default:          return 'Новая';
                    }
                },
            ],
            [
                'header' => 'Отзыв',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status !== 'accepted') {
                        return Html::tag('span', 'Доступно после принятия', ['class' => 'text-muted', 'style' => 'font-size:0.85rem;']);
                    }
                    return Html::a(
                        'Оставить отзыв',
                        ['review', 'id' => $model->id],
                        ['class' => 'btn btn-outline btn-xs']
                    );
                },
            ],
        ],
    ]) ?>
</div>
