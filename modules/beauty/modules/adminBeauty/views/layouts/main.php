<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\modules\beauty\assets\AdminAsset;

AdminAsset::register($this);

$role = Yii::$app->userBeauty->identity->role ?? null;
$panelTitle = $role === 'admin' ? 'Админ панель' : ($role === 'master' ? 'Кабинет мастера' : 'Личный кабинет');

$this->beginPage();
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/svg+xml" href="/favicon-beauty.svg">
    <?php $this->head() ?>
    <title><?= Html::encode($this->title) ?> - <?= $panelTitle ?></title>
</head>
<body>
<?php $this->beginBody() ?>

<!-- Admin Header -->
<header class="admin-header navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <?= Html::a('Салон красоты - ' . $panelTitle, ['/beauty/admin'], ['class' => 'navbar-brand']) ?>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php if (Yii::$app->userBeauty->identity && Yii::$app->userBeauty->identity->role === 'admin'): ?>
                    <li class="nav-item">
                        <?= Html::a('Dashboard', ['/beauty/admin/dashboard'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Пользователи', ['/beauty/admin/users'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Мастера', ['/beauty/admin/masters'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Услуги', ['/beauty/admin/services'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Заявки', ['/beauty/admin/orders'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Отчеты', ['/beauty/admin/reports'], ['class' => 'nav-link']) ?>
                    </li>
                <?php elseif (Yii::$app->userBeauty->identity && Yii::$app->userBeauty->identity->role === 'master'): ?>
                    <li class="nav-item">
                        <?= Html::a('Кабинет', ['/beauty/admin/master-cabinet'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Профиль', ['/beauty/admin/master-cabinet/profile'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Услуги', ['/beauty/admin/master-cabinet/services'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Расписание', ['/beauty/admin/master-cabinet/schedule'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Галерея', ['/beauty/admin/master-cabinet/gallery'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Сертификаты', ['/beauty/admin/master-cabinet/certificates'], ['class' => 'nav-link']) ?>
                    </li>
                    <li class="nav-item">
                        <?= Html::a('Заявки', ['/beauty/admin/master-cabinet/orders'], ['class' => 'nav-link']) ?>
                    </li>
                <?php endif; ?>
            </ul>
            
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                        <?= Html::encode(Yii::$app->userBeauty->identity->full_name ?? 'Гость') ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><?= Html::a('На сайт', ['/beauty/main/index'], ['class' => 'dropdown-item']) ?></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><?= Html::beginForm(['/beauty/auth/logout'], 'post', ['class' => 'dropdown-item p-0']) ?>
                            <?= Html::hiddenInput(Yii::$app->request->csrfParam, Yii::$app->request->csrfToken) ?>
                            <?= Html::submitButton('Выход', ['class' => 'dropdown-item border-0 bg-transparent w-100 text-start']) ?>
                            <?= Html::endForm() ?></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="admin-main">
    <div class="container-fluid py-4">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= Yii::$app->session->getFlash('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= Yii::$app->session->getFlash('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?= $content ?>
    </div>
</main>

<!-- Footer -->
<footer class="admin-footer bg-light py-3 mt-auto">
    <div class="container-fluid text-center text-muted">
        <small>&copy; <?= date('Y') ?> Салон красоты Виктория - <?= $panelTitle ?></small>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
