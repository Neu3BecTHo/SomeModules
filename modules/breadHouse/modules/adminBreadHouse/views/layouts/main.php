<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\breadHouse\assets\BreadHouseAdminAsset;

BreadHouseAdminAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="csrf-param" content="<?= Yii::$app->request->csrfParam ?>">
    <meta name="csrf-token" content="<?= Yii::$app->request->csrfToken ?>">
    <link rel="icon" type="image/svg+xml" href="/favicon-breadhouse.svg">
    <title><?= Html::encode($this->title) ?> — Админка Хлебного дворика</title>
    <?php $this->head() ?>
</head>
<body class="admin-body">
<?php $this->beginBody() ?>

<div class="admin-wrapper">
    <aside class="admin-sidebar">
        <div class="admin-sidebar__title">🍞 Хлебный дворик</div>
        <div class="admin-sidebar__subtitle">Панель управления</div>
        
        <div class="admin-nav">
            <a href="<?= Url::to(['/breadHouse']) ?>" class="admin-nav-link admin-nav-link--site">
                <span class="admin-nav-icon">🏠</span>
                <span class="admin-nav-text">На сайт</span>
            </a>
            
            <div class="admin-nav-divider"></div>
            
            <a href="<?= Url::to(['/breadHouse/admin']) ?>" class="admin-nav-link">
                <span class="admin-nav-icon">📊</span>
                <span class="admin-nav-text">Дэшборд</span>
            </a>
            
            <a href="<?= Url::to(['/breadHouse/admin/products']) ?>" class="admin-nav-link">
                <span class="admin-nav-icon">🛍️</span>
                <span class="admin-nav-text">Товары</span>
            </a>
            
            <a href="<?= Url::to(['/breadHouse/admin/categories']) ?>" class="admin-nav-link">
                <span class="admin-nav-icon">📁</span>
                <span class="admin-nav-text">Категории</span>
            </a>
            
            <a href="<?= Url::to(['/breadHouse/admin/orders']) ?>" class="admin-nav-link">
                <span class="admin-nav-icon">📋</span>
                <span class="admin-nav-text">Заказы</span>
            </a>
            
            <a href="<?= Url::to(['/breadHouse/admin/users']) ?>" class="admin-nav-link">
                <span class="admin-nav-icon">👥</span>
                <span class="admin-nav-text">Пользователи</span>
            </a>
        </div>
        
        <div class="admin-sidebar-footer">
            <?php $user = Yii::$app->userBreadHouse->identity ?>
            <div class="admin-user-info">
                <div class="admin-user-avatar">
                    <?= mb_substr($user->first_name ?? 'A', 0, 1) ?>
                </div>
                <div class="admin-user-details">
                    <div class="admin-user-name"><?= Html::encode($user->fullName()) ?></div>
                    <div class="admin-user-role">Администратор</div>
                </div>
            </div>
            
            <?= Html::beginForm(['/breadHouse/auth/logout'], 'post', ['class' => 'admin-logout-form']) ?>
                <?= Html::hiddenInput('_csrf', Yii::$app->request->csrfToken) ?>
                <button type="submit" class="admin-btn admin-btn--secondary admin-btn--full-width">
                    <span class="admin-btn-icon">🚪</span>
                    <span class="admin-btn-text">Выход</span>
                </button>
            <?= Html::endForm() ?>
        </div>
    </aside>

    <main class="admin-content">
        <div class="admin-header">
            <h1 class="admin-page-title"><?= Html::encode($this->title) ?></h1>
            <div class="admin-header-actions">
                <?php if (isset($this->params['breadcrumbs'])): ?>
                    <nav class="admin-breadcrumb">
                        <?php foreach ($this->params['breadcrumbs'] as $index => $breadcrumb): ?>
                            <?php if ($index === 0): ?>
                                <span class="admin-breadcrumb-current"><?= Html::encode($breadcrumb) ?></span>
                            <?php else: ?>
                                <span class="admin-breadcrumb-separator">›</span>
                                <span class="admin-breadcrumb-item"><?= Html::encode($breadcrumb) ?></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="admin-content-wrapper">
            <?= $content ?>
        </div>
    </main>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>