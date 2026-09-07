<?php
use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Расписание - Личный кабинет';

$dayLabels = [
    1 => 'Понедельник',
    2 => 'Вторник',
    3 => 'Среда',
    4 => 'Четверг',
    5 => 'Пятница',
    6 => 'Суббота',
    7 => 'Воскресенье',
];
?>
<div class="master-schedule">
    <h1>Мое расписание</h1>
    
    <div class="card">
        <div class="card-body">
            <?php $form = ActiveForm::begin(); ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>День</th>
                            <th>Рабочий день</th>
                            <th>Начало</th>
                            <th>Конец</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dayLabels as $day => $label): 
                            $schedule = $schedules[$day] ?? null;
                        ?>
                            <tr>
                                <td><?= $label ?></td>
                                <td>
                                    <?= Html::checkbox("day_{$day}[is_available]", $schedule ? $schedule->is_available : ($day <= 5), ['class' => 'form-check-input']) ?>
                                </td>
                                <td>
                                    <?= Html::input('time', "day_{$day}[start]", $schedule ? $schedule->start_time : '09:00', ['class' => 'form-control']) ?>
                                </td>
                                <td>
                                    <?= Html::input('time', "day_{$day}[end]", $schedule ? $schedule->end_time : '18:00', ['class' => 'form-control']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="form-group">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
