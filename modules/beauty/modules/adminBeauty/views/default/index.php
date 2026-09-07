<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Админ панель - Салон красоты Виктория';
?>
<div class="beauty-container">
    <div class="admin-container">
        <div class="admin-header">
            <h1>Админ панель</h1>
            <p>Управление салоном красоты</p>
        </div>

        <div class="admin-stats">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="icon-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?= \app\modules\beauty\models\User::find()->where(['role' => 'client'])->count() ?></h3>
                    <p>Клиентов</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="icon-user-tie"></i>
                </div>
                <div class="stat-info">
                    <h3><?= \app\modules\beauty\models\Master::find()->count() ?></h3>
                    <p>Мастеров</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="icon-calendar"></i>
                </div>
                <div class="stat-info">
                    <h3><?= \app\modules\beauty\models\Order::find()->count() ?></h3>
                    <p>Заказов</p>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">
                    <i class="icon-star"></i>
                </div>
                <div class="stat-info">
                    <h3><?= \app\modules\beauty\models\Service::find()->count() ?></h3>
                    <p>Услуг</p>
                </div>
            </div>
        </div>

        <div class="admin-actions">
            <div class="action-card">
                <h3>Управление пользователями</h3>
                <p>Просмотр и управление клиентами</p>
                <?= Html::a('Клиенты', ['/beauty/admin/users'], ['class' => 'btn btn-primary']) ?>
            </div>

            <div class="action-card">
                <h3>Управление мастерами</h3>
                <p>Просмотр и подтверждение мастеров</p>
                <?= Html::a('Мастера', ['/beauty/admin/masters'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
