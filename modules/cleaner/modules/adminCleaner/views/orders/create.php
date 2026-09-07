<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\modules\cleaner\models\Orders $model */

$this->title = Yii::t('app', 'Создать заявку');
?>

<div class="admin-header">
    <div class="admin-header__top">
        <div>
            <h1><?= Html::encode($this->title) ?></h1>
            <p>Добавление новой заявки от имени клиента</p>
        </div>
        <?= Html::a('← Назад', ['index'], ['class' => 'btn btn-secondary']) ?>
    </div>
</div>

<div class="glass-card">
    <div class="glass-card__header">
        <h3 class="glass-card__title">📝 Форма заявки</h3>
    </div>
    <div class="glass-card__body">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
