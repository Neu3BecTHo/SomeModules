<?php

use yii\bootstrap5\Html;
use app\modules\photoshoot\models\News;

/* @var $this yii\web\View */
/* @var $news array */

$this->title = 'Акции и новости';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <?php foreach ($news as $item): ?>
            <div class="col-md-6">
                <div class="service-card">
                    <div class="d-flex justify-content-between align-items-start">
                        <span class="badge bg-<?= $item->type === News::TYPE_PROMO ? 'warning text-dark' : 'info' ?>">
                            <?= $item->getTypeLabel() ?>
                        </span>
                        <?php if ($item->date_end): ?>
                            <small class="text-muted">До <?= Yii::$app->formatter->asDate($item->date_end) ?></small>
                        <?php endif; ?>
                    </div>
                    <h4 class="mt-3"><?= Html::encode($item->title) ?></h4>
                    <p><?= nl2br(Html::encode($item->content)) ?></p>
                    <small class="text-muted"><?= Yii::$app->formatter->asDate($item->created_at) ?></small>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
