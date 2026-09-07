<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\Orders $model */

$this->title = Yii::t('app', 'Заявка #{id}', ['id' => $model->id]);

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
            <p>Детальная информация о заявке</p>
        </div>
        <div class="action-btns">
            <?= Html::a('✏️ Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('🗑️ Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data-confirm' => 'Вы уверены, что хотите удалить эту заявку?',
            ]) ?>
        </div>
    </div>
</div>

<div class="glass-card">
    <div class="glass-card__header">
        <h3 class="glass-card__title">📋 Информация о заявке</h3>
    </div>
    <div class="glass-card__body">
        <div class="detail-list">
            <div class="detail-item">
                <div class="detail-item__label">ID заявки</div>
                <div class="detail-item__value">#<?= $model->id ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Клиент</div>
                <div class="detail-item__value"><?= Html::encode($model->user->fullName()) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Категория</div>
                <div class="detail-item__value"><?= Html::encode($model->category->title) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Статус</div>
                <div class="detail-item__value"><?= $statusBadges[$model->status_id] ?? $model->status->title ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Адрес</div>
                <div class="detail-item__value"><?= Html::encode($model->address) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Способ оплаты</div>
                <div class="detail-item__value"><?= Html::encode($model->payment_type) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Тип вещи</div>
                <div class="detail-item__value"><?= Html::encode($model->item_type) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Материал</div>
                <div class="detail-item__value"><?= Html::encode($model->material) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Уровень загрязнения</div>
                <div class="detail-item__value"><?= Html::encode($model->pollution_level) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Размер ковра</div>
                <div class="detail-item__value"><?= Html::encode($model->carpet_size) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Дополнительная информация</div>
                <div class="detail-item__value"><?= nl2br(Html::encode($model->extra_info)) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Дата создания</div>
                <div class="detail-item__value"><?= Yii::$app->formatter->asDatetime($model->created_at) ?></div>
            </div>
            <div class="detail-item">
                <div class="detail-item__label">Дата обновления</div>
                <div class="detail-item__value"><?= Yii::$app->formatter->asDatetime($model->updated_at) ?></div>
            </div>
        </div>
    </div>
</div>
