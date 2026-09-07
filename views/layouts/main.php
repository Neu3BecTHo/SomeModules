<?php

use yii\helpers\Html;

/** @var \yii\web\View $this */
/** @var string $content */

$this->registerCssFile('@web/css/DashboardModules.css');

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <title><?= Html::encode($this->title ?: 'Проектные модули') ?></title>
    <?php $this->head() ?>
</head>
<body class="mods-body">
<?php $this->beginBody() ?>

<div class="mods-shell">
    <header class="mods-header">
        <div class="mods-header__brand">
            <span class="mods-header__mark">PRJ</span>
            <span class="mods-header__text">Учебные модули</span>
        </div>
    </header>

    <main class="mods-main">
        <div class="mods-main__card">
            <?= $content ?>
        </div>
    </main>

    <footer class="mods-footer">
        <span>Панель модулей проектной деятельности</span>
    </footer>
</div>

<style>
    .mods-body {
    margin: 0;
    font-family: system-ui, -apple-system, "Segoe UI", sans-serif;
    background: #e5e7eb;
    color: #111827;
}

.mods-shell {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

/* Header */

.mods-header {
    height: 52px;
    display: flex;
    align-items: center;
    padding: 0 24px;
    background: #111827;
    color: #f9fafb;
    border-bottom: 1px solid #020617;
}

.mods-header__brand {
    display: flex;
    align-items: center;
    gap: 10px;
}

.mods-header__mark {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #f97316;
    color: #111827;
    font-size: 14px;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
}

.mods-header__text {
    font-size: 15px;
    font-weight: 600;
}

/* Main */

.mods-main {
    flex: 1;
    padding: 24px 16px 20px;
    display: flex;
    justify-content: center;
}

.mods-main__card {
    width: 100%;
    max-width: 1100px;
    background: #020617;
    border-radius: 18px;
    padding: 18px 18px 16px;
    box-shadow: 0 18px 40px rgba(15, 23, 42, 0.35);
    border: 1px solid #111827;
    color: #e5e7eb;
}

/* Footer */

.mods-footer {
    height: 40px;
    border-top: 1px solid #d1d5db;
    background: #f9fafb;
    font-size: 12px;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
