<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->title ?> - Админ-панель</title>
    <?php $this->head() ?>
</head>
<body>
    <div class="admin-wrapper">
        <nav class="admin-nav">
            <a href="/"><?= Yii::t('admin', 'На главную') ?></a>
            <?= Yii::$app->user->identity->username ?>
            <a href="<?= Yii::$app->user->logoutUrl ?>"><?= Yii::t('admin', 'Выход') ?></a>
        </nav>
        
        <main class="admin-content">
            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-error"><?= Yii::$app->session->getFlash('error') ?></div>
            <?php endif; ?>
            
            <?php if (Yii::$app->session->hasFlash('success')): ?>
                <div class="alert alert-success"><?= Yii::$app->session->getFlash('success') ?></div>
            <?php endif; ?>
            
            <?= $content ?>
        </main>
    </div>
    <?php $this->endBody() ?>
</body>
</html>
