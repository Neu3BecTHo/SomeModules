<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Пользователь: ' . $user->full_name;
?>

<div class="admin-container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($user->full_name) ?></h1>
        <div>
            <?= Html::a('← Назад', ['users'], ['class' => 'btn btn-outline']) ?>
            <?= Html::a('Редактировать', ['edit-user', 'id' => $user->id], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="rounded-circle bg-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                        <span class="display-4 text-white"><?= strtoupper(mb_substr($user->full_name, 0, 1)) ?></span>
                    </div>
                    <h5 class="card-title"><?= Html::encode($user->full_name) ?></h5>
                    <p class="text-muted">
                        <span class="badge bg-info"><?= $user->role === 'client' ? 'Клиент' : $user->role ?></span>
                    </p>
                    <hr>
                    <p><strong>Телефон:</strong><br><?= Html::encode($user->phone) ?></p>
                    <p><strong>Зарегистрирован:</strong><br><?= Yii::$app->formatter->asDate($user->created_at, 'd MMMM yyyy') ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Заказы клиента</h5>
                    <span class="badge bg-primary"><?= count($orders) ?> всего</span>
                </div>
                <div class="card-body">
                    <?php if ($orders): ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>№</th>
                                        <th>Услуга</th>
                                        <th>Мастер</th>
                                        <th>Дата</th>
                                        <th>Сумма</th>
                                        <th>Статус</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $order): ?>
                                        <tr>
                                            <td>
                                                <a href="<?= Url::to(['view-order', 'id' => $order->id]) ?>">#<?= $order->id ?></a>
                                            </td>
                                            <td><?= Html::encode($order->service->name) ?></td>
                                            <td><?= Html::encode($order->master->user->full_name) ?></td>
                                            <td><?= Yii::$app->formatter->asDate($order->appointment_date, 'd MMM') ?></td>
                                            <td><?= $order->total_price ?> ₽</td>
                                            <td>
                                                <span class="badge bg-<?= $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'info') ?>">
                                                    <?= $order->status ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">У клиента пока нет заказов</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
