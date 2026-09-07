<?php

use app\modules\cleaner\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Управление заказами';
$this->params['breadcrumbs'] = ['Заказы'];
?>
<div class="admin-orders-index">
    <div class="admin-card">
        <div class="admin-card__header">
            <h2 class="admin-card__title">📋 Управление заказами</h2>
            <div class="admin-card__actions">
                <?= Html::a('<span class="admin-btn-icon">➕</span><span class="admin-btn-text">Создать заказ</span>', ['create'], ['class' => 'admin-btn admin-btn--success']) ?>
            </div>
        </div>
        <div class="admin-card__body">
            <div class="admin-stats">
                <div class="admin-stat-card">
                    <div class="admin-stat-card__title">Всего заказов</div>
                    <div class="admin-stat-card__value"><?= $dataProvider->totalCount ?></div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-card__title">Новые</div>
                    <div class="admin-stat-card__value">
                        <?php 
                        $newOrders = 0;
                        foreach ($dataProvider->models as $model) {
                            if ($model->status_id == 1) $newOrders++;
                        }
                        echo $newOrders;
                        ?>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-card__title">В обработке</div>
                    <div class="admin-stat-card__value">
                        <?php 
                        $processingOrders = 0;
                        foreach ($dataProvider->models as $model) {
                            if ($model->status_id == 2) $processingOrders++;
                        }
                        echo $processingOrders;
                        ?>
                    </div>
                </div>
                <div class="admin-stat-card">
                    <div class="admin-stat-card__title">Завершено</div>
                    <div class="admin-stat-card__value">
                        <?php 
                        $completedOrders = 0;
                        foreach ($dataProvider->models as $model) {
                            if ($model->status_id == 3) $completedOrders++;
                        }
                        echo $completedOrders;
                        ?>
                    </div>
                </div>
            </div>

            <div class="admin-table-wrapper">
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'tableOptions' => ['class' => 'admin-table'],
                    'headerRowOptions' => ['class' => 'admin-table__header'],
                    'filterRowOptions' => ['class' => 'admin-table__filter'],
                    'layout' => "{summary}\n{items}\n{pager}",
                    'summaryOptions' => ['class' => 'admin-table__summary'],
                    'pager' => [
                        'class' => 'yii\widgets\LinkPager',
                        'options' => ['class' => 'admin-pagination'],
                        'linkOptions' => ['class' => 'admin-pagination-link'],
                        'activePageCssClass' => 'admin-pagination-link--active',
                        'disabledPageCssClass' => 'admin-pagination-link--disabled',
                        'prevPageLabel' => '‹',
                        'nextPageLabel' => '›',
                        'firstPageLabel' => '«',
                        'lastPageLabel' => '»',
                    ],
                    'columns' => [
                        [
                            'class' => 'yii\grid\SerialColumn',
                            'headerOptions' => ['style' => 'width: 50px;'],
                        ],
                        [
                            'attribute' => 'id',
                            'headerOptions' => ['style' => 'width: 60px;'],
                        ],
                        [
                            'attribute' => 'user_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<div class="admin-user-info">
                                    <div class="admin-user-avatar-small">' . mb_substr($model->user->first_name ?? 'Г', 0, 1) . '</div>
                                    <div class="admin-user-details-small">
                                        <div class="admin-user-name-small">' . Html::encode($model->user->first_name . ' ' . $model->user->last_name) . '</div>
                                        <div class="admin-user-email-small">' . Html::encode($model->user->email) . '</div>
                                    </div>
                                </div>';
                            },
                            'headerOptions' => ['style' => 'width: 200px;'],
                        ],
                        [
                            'attribute' => 'category_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<div class="admin-category-badge">' . Html::encode($model->category->title) . '</div>';
                            },
                            'filter' => \yii\helpers\ArrayHelper::map(
                                \app\modules\breadHouse\models\Categories::find()->all(),
                                'id',
                                'title'
                            ),
                            'headerOptions' => ['style' => 'width: 150px;'],
                        ],
                        [
                            'attribute' => 'status_id',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $statusClass = $model->status_id == 1 ? 'admin-status--new' : 
                                              ($model->status_id == 2 ? 'admin-status--processing' : 'admin-status--completed');
                                return '<div class="admin-status ' . $statusClass . '">' . Html::encode($model->status->title) . '</div>';
                            },
                            'filter' => \yii\helpers\ArrayHelper::map(
                                \app\modules\cleaner\models\OrderStatus::find()->all(),
                                'id',
                                'title'
                            ),
                            'headerOptions' => ['style' => 'width: 120px;'],
                        ],
                        [
                            'attribute' => 'address',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<div class="admin-address">' . Html::encode($model->address) . '</div>';
                            },
                            'headerOptions' => ['style' => 'width: 250px;'],
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'raw',
                            'value' => function ($model) {
                                return '<div class="admin-date">' . date('d.m.Y H:i', strtotime($model->created_at)) . '</div>';
                            },
                            'headerOptions' => ['style' => 'width: 140px;'],
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{view} {update} {delete}',
                            'headerOptions' => ['style' => 'width: 120px;'],
                            'buttons' => [
                                'view' => function ($url, $model, $key) {
                                    return Html::a('<span class="admin-action-icon">👁️</span>', $url, [
                                        'title' => 'Просмотр',
                                        'class' => 'admin-action-btn admin-action-btn--view',
                                    ]);
                                },
                                'update' => function ($url, $model, $key) {
                                    return Html::a('<span class="admin-action-icon">✏️</span>', $url, [
                                        'title' => 'Редактировать',
                                        'class' => 'admin-action-btn admin-action-btn--update',
                                    ]);
                                },
                                'delete' => function ($url, $model, $key) {
                                    return Html::a('<span class="admin-action-icon">🗑️</span>', $url, [
                                        'title' => 'Удалить',
                                        'data-confirm' => 'Вы уверены, что хотите удалить этот заказ?',
                                        'data-method' => 'post',
                                        'data-pjax' => '0',
                                        'class' => 'admin-action-btn admin-action-btn--delete',
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
