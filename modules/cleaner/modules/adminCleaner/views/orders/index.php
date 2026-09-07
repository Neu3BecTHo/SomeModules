<?php

use app\modules\cleaner\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = Yii::t('app', 'Заявки');

$statusBadges = [
    1 => '<span class="status-badge status-new">Новая</span>',
    2 => '<span class="status-badge status-process">В работе</span>',
    3 => '<span class="status-badge status-done">Выполнена</span>',
    4 => '<span class="status-badge status-cancel">Отменена</span>',
];
?>

<div class="admin-header">
    <div class="admin-header__top">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Управление заявками клиентов</p>
        </div>
        <?= Html::a('➕ Создать заявку', ['create'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card__icon">📋</div>
        <div class="stat-card__value"><?= $dataProvider->totalCount ?></div>
        <div class="stat-card__label">Всего заявок</div>
    </div>
    <div class="stat-card stat-card--success">
        <div class="stat-card__icon">✨</div>
        <div class="stat-card__value"><?= Orders::find()->where(['status_id' => 3])->count() ?></div>
        <div class="stat-card__label">Выполнено</div>
    </div>
    <div class="stat-card stat-card--warning">
        <div class="stat-card__icon">🔧</div>
        <div class="stat-card__value"><?= Orders::find()->where(['status_id' => 2])->count() ?></div>
        <div class="stat-card__label">В работе</div>
    </div>
    <div class="stat-card stat-card--danger">
        <div class="stat-card__icon">🆕</div>
        <div class="stat-card__value"><?= Orders::find()->where(['status_id' => 1])->count() ?></div>
        <div class="stat-card__label">Новые</div>
    </div>
</div>

<!-- Orders Table -->
<div class="glass-card">
    <div class="glass-card__header">
        <h3 class="glass-card__title">📋 Список заявок</h3>
    </div>
    <div class="glass-card__body">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'data-table'],
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['style' => 'width: 60px;'],
                    'contentOptions' => ['style' => 'font-weight: 600;'],
                ],
                [
                    'attribute' => 'user_id',
                    'label' => 'Клиент',
                    'value' => function ($model) {
                        return $model->user->fullName();
                    },
                ],
                [
                    'attribute' => 'category_id',
                    'label' => 'Категория',
                    'value' => function ($model) {
                        return $model->category->title;
                    },
                ],
                [
                    'attribute' => 'status_id',
                    'label' => 'Статус',
                    'value' => function ($model) use ($statusBadges) {
                        return $statusBadges[$model->status_id] ?? $model->status->title;
                    },
                    'format' => 'raw',
                    'contentOptions' => ['style' => 'width: 140px;'],
                ],
                [
                    'attribute' => 'address',
                    'label' => 'Адрес',
                ],
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Orders $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id' => $model->id]);
                    },
                    'buttons' => [
                        'view' => function($url, $model) {
                            return Html::a('👁️', $url, ['class' => 'action-btn action-btn--view', 'title' => 'Просмотр']);
                        },
                        'update' => function($url, $model) {
                            return Html::a('✏️', $url, ['class' => 'action-btn action-btn--edit', 'title' => 'Редактировать']);
                        },
                        'delete' => function($url, $model) {
                            return Html::a('🗑️', $url, [
                                'class' => 'action-btn action-btn--delete',
                                'title' => 'Удалить',
                                'data-confirm' => 'Удалить заявку?'
                            ]);
                        },
                    ],
                    'contentOptions' => ['style' => 'width: 130px;'],
                ],
            ],
        ]); ?>
    </div>
</div>
