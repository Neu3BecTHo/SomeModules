<?php
/** @var app\modules\tours\models\Tours $tour */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<article class="tour-card">
    <a href="<?= Url::to(['tours/view', 'id' => $tour->id]) ?>">
        <div class="tour-card__image"
             style="background-image: url('<?= Html::encode($tour->image ?: '/images/tours/slide3.jpg') ?>')">
        </div>
        <div class="tour-card__body">
            <h3><?= Html::encode($tour->title) ?></h3>
            <p><?= Html::encode($tour->short_description) ?></p>
            <div class="tour-card__meta">
                <span class="tour-card__price">
                    <?= Yii::$app->formatter->asCurrency($tour->price, 'RUB') ?>
                </span>
                <?php if ($tour->duration_days): ?>
                    <span class="tour-card__duration"><?= (int)$tour->duration_days ?> дн.</span>
                <?php endif; ?>
            </div>
        </div>
    </a>
</article>
