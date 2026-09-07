<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\Orders $model */

$this->title = Yii::t('app', 'Изменить заявку #{id}', ['id' => $model->id]);
?>

<div class="admin-header">
    <div class="admin-header__top">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Редактирование заявки от <?= $model->user->fullName() ?></p>
        </div>
        <?= Html::a('← Назад', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

<div class="glass-card">
    <div class="glass-card__header">
        <h3 class="glass-card__title">✏️ Редактирование заявки #<?= $model->id ?></h3>
    </div>
    <div class="glass-card__body">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
