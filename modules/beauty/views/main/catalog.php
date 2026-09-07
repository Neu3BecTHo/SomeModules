<?php

/* @var $this \yii\web\View */
/* @var $services \app\modules\beauty\models\Service[] */
/* @var $categories \app\modules\beauty\models\Category[] */
/* @var $masters \app\modules\beauty\models\Master[] */

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\BeautyAsset;

BeautyAsset::register($this);

$this->title = 'Каталог услуг';
?>

<div class="catalog-page">
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <h1 class="page-title">Каталог услуг</h1>
            <p class="page-subtitle">Выберите подходящую услугу для вашего визита</p>
        </div>
    </div>

    <div class="container">
        <!-- Filters -->
        <div class="catalog-filters">
            <form method="get" class="filters-form">
                <div class="filters-row">
                    <div class="filter-group">
                        <label for="category">Категория:</label>
                        <select name="category" id="category" class="form-control">
                            <option value="">Все категории</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= $category->id ?>" <?= Yii::$app->request->get('category') == $category->id ? 'selected' : '' ?>>
                                    <?= Html::encode($category->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="master">Мастер:</label>
                        <select name="master" id="master" class="form-control">
                            <option value="">Все мастера</option>
                            <?php foreach ($masters as $master): ?>
                                <option value="<?= $master->id ?>" <?= Yii::$app->request->get('master') == $master->id ? 'selected' : '' ?>>
                                    <?= Html::encode($master->user->full_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label for="min_price">Цена от:</label>
                        <input type="number" name="min_price" id="min_price" class="form-control"
                               value="<?= Html::encode(Yii::$app->request->get('min_price')) ?>" placeholder="0">
                    </div>

                    <div class="filter-group">
                        <label for="max_price">Цена до:</label>
                        <input type="number" name="max_price" id="max_price" class="form-control"
                               value="<?= Html::encode(Yii::$app->request->get('max_price')) ?>" placeholder="10000">
                    </div>

                    <div class="filter-group">
                        <button type="submit" class="btn btn-primary">Применить</button>
                        <a href="<?= Url::to(['main/catalog']) ?>" class="btn btn-outline-primary">Сбросить</a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Sort Options -->
        <div class="catalog-sort">
            <form method="get" class="sort-form">
                <?php foreach (Yii::$app->request->get() as $key => $value): ?>
                    <?php if ($key !== 'sort' && $key !== 'order'): ?>
                        <input type="hidden" name="<?= Html::encode($key) ?>" value="<?= Html::encode($value) ?>">
                    <?php endif; ?>
                <?php endforeach; ?>

                <label>Сортировка:</label>
                <select name="sort" onchange="this.form.submit()">
                    <option value="name" <?= Yii::$app->request->get('sort') === 'name' ? 'selected' : '' ?>>По названию</option>
                    <option value="price" <?= Yii::$app->request->get('sort') === 'price' ? 'selected' : '' ?>>По цене</option>
                    <option value="rating" <?= Yii::$app->request->get('sort') === 'rating' ? 'selected' : '' ?>>По рейтингу</option>
                </select>

                <select name="order" onchange="this.form.submit()">
                    <option value="asc" <?= Yii::$app->request->get('order') === 'asc' ? 'selected' : '' ?>>По возрастанию</option>
                    <option value="desc" <?= Yii::$app->request->get('order') === 'desc' ? 'selected' : '' ?>>По убыванию</option>
                </select>
            </form>
        </div>

        <!-- Services Grid -->
        <?php if (!empty($services)): ?>
            <div class="services-grid">
                <?php foreach ($services as $service): ?>
                    <div class="service-card-compact">
                        <div class="service-image">
                            <img src="<?= $service->image ?: '/images/no-image.png' ?>" alt="<?= Html::encode($service->name) ?>">
                        </div>
                        <div class="service-body">
                            <div class="service-header">
                                <span class="service-category"><?= Html::encode($service->category->name) ?></span>
                                <h3><?= Html::encode($service->name) ?></h3>
                            </div>
                            <div class="service-info-row">
                                <span class="service-duration">⏱ <?= $service->duration ?> мин</span>
                                <span class="service-price"><?= number_format($service->price, 0, '.', ' ') ?> ₽</span>
                            </div>
                            <div class="service-actions">
                                <a href="<?= Url::to(['main/service', 'id' => $service->id]) ?>" class="btn btn-outline">
                                    Подробнее
                                </a>
                                <a href="<?= Url::to(['main/book', 'service_id' => $service->id]) ?>" class="btn btn-primary">
                                    Записаться
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <!-- No Services -->
            <div class="no-services">
                <div class="no-services-icon">🔍</div>
                <h2>Услуги не найдены</h2>
                <p>Попробуйте изменить параметры фильтрации</p>
                <a href="<?= Url::to(['main/catalog']) ?>" class="btn btn-primary">Показать все услуги</a>
            </div>
        <?php endif; ?>
    </div>
</div>
