<?php

use yii\bootstrap5\Html;
use app\modules\photoshoot\models\Gallery;

/* @var $this yii\web\View */
/* @var $gallery array */
/* @var $currentCategory string|null */

$this->title = 'Галерея работ';
?>
<div class="container py-5">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <div class="mb-4 text-center">
        <?= Html::a('Все', ['/photoshoot/main/gallery'], ['class' => 'btn ' . (!$currentCategory ? 'btn-primary' : 'btn-outline-primary')]) ?>
        <?php foreach (Gallery::getCategoryLabels() as $key => $label): ?>
            <?= Html::a($label, ['/photoshoot/main/gallery', 'category' => $key], ['class' => 'btn ' . ($currentCategory === $key ? 'btn-primary' : 'btn-outline-primary')]) ?>
        <?php endforeach; ?>
    </div>

    <div class="row">
        <?php foreach ($gallery as $item): ?>
            <div class="col-md-4 col-sm-6">
                <div class="gallery-item">
                    <img src="/uploads/photoshoot/<?= Html::encode($item->image) ?>" alt="<?= Html::encode($item->title) ?>">
                    <div class="gallery-overlay">
                        <h6><?= Html::encode($item->title) ?></h6>
                        <small><?= $item->getCategoryLabel() ?></small>
                        <?php if ($item->description): ?>
                            <p class="small mt-2"><?= Html::encode($item->description) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
