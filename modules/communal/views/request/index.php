<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'История операций';
$this->registerCssFile('@web/css/request.css', ['depends' => [\app\modules\communal\assets\CommunalMainAsset::class]]);

$models = $dataProvider->getModels();
?>

<div class="comm-container profile-page">
    
    <div class="profile-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>

    <div class="profile-content">
        
        <!-- Кнопка сверху -->
        <div style="margin-bottom: 30px;">
             <?= Html::a('Передать показания', ['create'], [
                 'class' => 'profile-save-btn', 
                 'style' => 'text-decoration: none; max-width: 100%; padding: 12px; margin-top: 0;'
             ]) ?>
        </div>

        <?php if (count($models) > 0): ?>
            <div class="requests-compact-list">
                <?php foreach ($models as $request): ?>
                    <div class="req-card">
                        
                        <!-- Верхний ряд: Услуга и Деньги -->
                        <div class="req-row-top">
                            <div class="req-service">
                                <?= Html::encode($request->serviceType->title) ?>
                            </div>
                            <div class="req-amount">
                                <?= Yii::$app->formatter->asCurrency($request->amount, 'RUB') ?>
                            </div>
                        </div>

                        <!-- Средний ряд: Показания и Расход -->
                        <div class="req-row-mid">
                            <div class="req-vals">
                                <?= (float)$request->previous_value ?> 
                                <span class="req-arrow">→</span> 
                                <?= (float)$request->current_value ?>
                            </div>
                            <div class="req-consumption">
                                Расход: <b><?= (float)$request->consumption ?> <?= Html::encode($request->serviceType->unit) ?></b>
                            </div>
                        </div>

                        <!-- Нижний ряд: Дата и Статус -->
                        <div class="req-row-bot">
                            <div class="req-date">
                                <?= Yii::$app->formatter->asDate($request->created_at, 'php:d M Y') ?>
                            </div>
                            <div class="req-status status-<?= $request->status_id ?>">
                                <?= Html::encode($request->status->name ?? 'Обработка') ?>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Пагинация -->
            <div style="margin-top: 20px; text-align: center;">
                 <?= \yii\widgets\LinkPager::widget([
                    'pagination' => $dataProvider->pagination,
                ]) ?>
            </div>

        <?php else: ?>
            <div style="text-align: center; color: #64748b; padding: 40px;">
                История пуста.
            </div>
        <?php endif; ?>
    </div>
</div>
