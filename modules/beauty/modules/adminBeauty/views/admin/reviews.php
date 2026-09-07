<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Отзывы';
?>

<div class="admin-container">
    <h1 class="mb-4">Отзывы</h1>

    <div class="card">
        <div class="card-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    [
                        'attribute' => 'client_id',
                        'label' => 'Клиент',
                        'value' => function($model) {
                            return Html::encode($model->client->full_name);
                        },
                    ],
                    [
                        'attribute' => 'master_id',
                        'label' => 'Мастер',
                        'value' => function($model) {
                            return Html::encode($model->master->user->full_name);
                        },
                    ],
                    [
                        'attribute' => 'rating',
                        'label' => 'Рейтинг',
                        'format' => 'raw',
                        'value' => function($model) {
                            return str_repeat('★', $model->rating) . str_repeat('☆', 5 - $model->rating);
                        },
                    ],
                    [
                        'attribute' => 'comment',
                        'label' => 'Отзыв',
                        'value' => function($model) {
                            return Html::encode(mb_strimwidth($model->comment, 0, 100, '...'));
                        },
                    ],
                    [
                        'attribute' => 'is_visible',
                        'label' => 'Видимость',
                        'format' => 'raw',
                        'value' => function($model) {
                            return $model->is_visible 
                                ? '<span class="badge bg-success">Виден</span>' 
                                : '<span class="badge bg-secondary">Скрыт</span>';
                        },
                    ],
                    [
                        'attribute' => 'created_at',
                        'label' => 'Дата',
                        'value' => function($model) {
                            return Yii::$app->formatter->asDate($model->created_at, 'd MMM yyyy');
                        },
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{toggle} {delete}',
                        'buttons' => [
                            'toggle' => function($url, $model) {
                                $icon = $model->is_visible ? '👁️' : '🙈';
                                $title = $model->is_visible ? 'Скрыть' : 'Показать';
                                return Html::a($icon, ['toggle-review', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-outline-primary',
                                    'title' => $title,
                                    'data' => ['method' => 'post'],
                                ]);
                            },
                            'delete' => function($url, $model) {
                                return Html::a('🗑️', ['delete-review', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-outline-danger',
                                    'title' => 'Удалить',
                                    'data' => [
                                        'confirm' => 'Удалить отзыв?',
                                        'method' => 'post',
                                    ],
                                ]);
                            },
                        ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
