<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\breadHouse\modules\adminBreadHouse\models\CategoriesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Управление категориями';

$categories = $dataProvider->getModels();
?>

<div class="admin-section">
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">📁 <?= Html::encode($this->title) ?></h1>
            <div class="admin-breadcrumb">
                <a href="<?= Url::to(['/breadHouse/admin']) ?>">Главная</a>
                <span class="separator">›</span>
                <span>Категории</span>
            </div>
        </div>
        <div class="admin-actions">
            <?= Html::a('➕ Создать категорию', ['create'], ['class' => 'admin-btn admin-btn--success']) ?>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="admin-cards-grid admin-cards-grid--compact">
        <?php foreach ($categories as $category): ?>
            <div class="admin-category-card">
                <div class="admin-category-card__icon">📁</div>
                <div class="admin-category-card__content">
                    <div class="admin-category-card__id">ID: <?= $category->id ?></div>
                    <h3 class="admin-category-card__title"><?= Html::encode($category->title) ?></h3>
                    <div class="admin-category-card__stats">
                        <span class="admin-category-card__stat">🛍️ <?= count($category->products) ?> товаров</span>
                    </div>
                </div>
                <div class="admin-category-card__actions">
                    <?= Html::a('Просмотр', ['view', 'id' => $category->id], ['class' => 'admin-btn admin-btn--small admin-btn--info']) ?>
                    <?= Html::a('Изменить', ['update', 'id' => $category->id], ['class' => 'admin-btn admin-btn--small admin-btn--warning']) ?>
                    <?= Html::a('Удалить', ['delete', 'id' => $category->id], [
                        'class' => 'admin-btn admin-btn--small admin-btn--danger',
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
