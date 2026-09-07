<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление пользователями';

$users = $dataProvider->getModels();
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">👥 <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <a href="<?= Url::to(['/breadHouse/admin']) ?>">Главная</a>
                <span class="separator">›</span>
                <span>Пользователи</span>
            </div>
        </div>
        <div class="admin-actions">
            <?= Html::a('📊 Статистика', '#', ['class' => 'admin-btn admin-btn--info']) ?>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="admin-cards-grid admin-cards-grid--compact">
        <?php foreach ($users as $user): ?>
            <div class="admin-user-card">
                <div class="admin-user-card__header">
                    <div class="admin-user-card__avatar">
                        <?= mb_substr($user->first_name ?: 'U', 0, 1) ?>
                    </div>
                    <div class="admin-user-card__info">
                        <div class="admin-user-card__name">
                            <?= Html::encode(trim($user->first_name . ' ' . $user->last_name)) ?: 'Без имени' ?>
                        </div>
                        <div class="admin-user-card__phone">📱 <?= $user->phone ?></div>
                    </div>
                </div>
                <div class="admin-user-card__body">
                    <div class="admin-user-card__email">✉️ <?= $user->email ?></div>
                    <div class="admin-user-card__meta">
                        <span class="admin-user-card__id">ID: <?= $user->id ?></span>
                        <span class="admin-status <?= $user->is_admin ? 'admin-status--3' : '' ?>">
                            <?= $user->is_admin ? '👑 Админ' : 'Пользователь' ?>
                        </span>
                    </div>
                    <div class="admin-user-card__date">📅 <?= Yii::$app->formatter->asDate($user->created_at, 'php:d.m.Y') ?></div>
                </div>
                <div class="admin-user-card__footer">
                    <?= Html::a($user->is_admin ? '👤 Снять админа' : '👑 Назначить админом', 
                        ['toggle-admin', 'id' => $user->id], [
                            'class' => 'admin-btn admin-btn--small ' . ($user->is_admin ? 'admin-btn--warning' : 'admin-btn--success'),
                            'data-confirm' => 'Вы уверены?',
                            'data-method' => 'post',
                        ]) ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="admin-pagination-wrapper">
        <?= LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'admin-pagination'],
            'linkOptions' => ['class' => 'admin-pagination-link'],
            'activePageCssClass' => 'admin-pagination-link--active',
            'disabledPageCssClass' => 'admin-pagination-link--disabled',
            'prevPageLabel' => '‹',
            'nextPageLabel' => '›',
        ]) ?>
    </div>
</div>
