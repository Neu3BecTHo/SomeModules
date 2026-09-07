<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\modules\boardwalk\models\Booking $model */
/** @var app\modules\boardwalk\models\GameSessions[] $sessions */

$this->title = 'Формирование заявки';
?>

<div class="container section">
    <h1 class="section-title"><?= Html::encode($this->title) ?></h1>

    <!-- ГРАФИК ИГР -->
    <div class="card" style="margin-bottom: 30px;">
        <h3>График игр на месяц</h3>
        <div class="table-wrapper">
            <table class="schedule-table">
                <thead>
                    <tr>
                        <th>Вид</th>
                        <th>Название</th>
                        <th>Дата и время</th>
                        <th>Адрес</th>
                        <th>Цена</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sessions as $s): ?>
                        <tr>
                            <td><?= Html::encode($s->game->category) ?></td>
                            <td><?= Html::encode($s->game->title) ?></td>
                            <td><?= Yii::$app->formatter->asDatetime($s->start_at, 'php:d.m.Y H:i') ?></td>
                            <td><?= Html::encode($s->address) ?></td>
                            <td><?= $s->price ?> ₽</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ФОРМА ЗАПИСИ -->
    <div class="form card">
        <?php $form = ActiveForm::begin(['id' => 'booking-form']); ?>

        <div class="form-row">
            <?= $form->field($model, 'game_type')->dropDownList([
                'Классические' => 'Классические',
                'Карточные' => 'Карточные',
                'Экономические' => 'Экономические',
                'Стратегии' => 'Стратегии',
                'Для детей' => 'Для детей'
            ], [
                'id' => 'booking-game_type', // Указываем ID для JS
                'prompt' => 'Выберите вид игры...'
            ]) ?>

            <?= $form->field($model, 'session_id')->dropDownList([], [
                'id' => 'booking-session_id', 
                'prompt' => 'Сначала выберите вид...'
            ]) ?>
        </div>

        <!-- БЛОК ДИНАМИЧЕСКОЙ ИНФОРМАЦИИ (Адрес и Цена) -->
        <div class="session-info-block" style="display:none; margin: 0 0 20px 0; padding: 15px; background: rgba(240, 180, 41, 0.1); border-radius: 8px; border-left: 4px solid var(--accent);">
            <div style="color: var(--muted); font-size: 13px; text-transform: uppercase; margin-bottom: 5px;">Детали выбранной игры:</div>
            <div style="color: var(--text-white);">📍 <strong>Адрес:</strong> <span id="display-address"></span></div>
            <div style="color: var(--accent); font-size: 18px; margin-top: 5px;">💰 <strong>Цена:</strong> <span id="display-price"></span></div>
        </div>

        <!-- ДАННЫЕ ПОЛЬЗОВАТЕЛЯ -->
        <div class="form-row">
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>
            <?= $form->field($model, 'email')->textInput(['readonly' => true]) ?>
            <?= $form->field($model, 'phone')->textInput(['readonly' => true]) ?>
        </div>

        <div class="form-row">
            <?= $form->field($model, 'player_status')->radioList([
                'Новичок' => 'Новичок', 
                'Любитель' => 'Любитель', 
                'Профессионал' => 'Профессионал'
            ], ['class' => 'radio']) ?>
            
            <?= $form->field($model, 'payment_method')->dropDownList([
                'Наличными' => 'Наличными',
                'Картой' => 'Картой',
                'Переводом' => 'Переводом'
            ]) ?>
        </div>

        <?= $form->field($model, 'agree', [
            'options' => ['class' => 'checkbox']
        ])->checkbox(['label' => 'Я согласен на обработку моих персональных данных']) ?>

        <button type="submit" class="btn btn-primary">Забронировать место</button>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
// Ссылка на контроллер для AJAX
$ajaxUrl = Url::to(['booking/get-games-by-category']);

$js = <<<JS
// 1. При выборе категории (game_type) подгружаем доступные игры/сессии
$('#booking-game_type').on('change', function() {
    let category = $(this).val();
    let sessionSelect = $('#booking-session_id');
    
    if (category) {
        $.get('$ajaxUrl', {category: category}, function(data) {
            sessionSelect.html(data);
            $('.session-info-block').fadeOut(); // Прячем инфо, пока не выбрана игра
        });
    } else {
        sessionSelect.html('<option value="">Сначала выберите вид...</option>');
        $('.session-info-block').fadeOut();
    }
});

// 2. При выборе конкретной сессии вытаскиваем цену и адрес из data-атрибутов
$(document).on('change', '#booking-session_id', function() {
    let selectedOption = $(this).find('option:selected');
    let price = selectedOption.data('price');
    let address = selectedOption.data('address');
    
    if (price && address) {
        $('#display-price').text(price + ' ₽');
        $('#display-address').text(address);
        $('.session-info-block').fadeIn(); // Показываем блок с инфой
    } else {
        $('.session-info-block').fadeOut();
    }
});
JS;

$this->registerJs($js, \yii\web\View::POS_READY);
?>
