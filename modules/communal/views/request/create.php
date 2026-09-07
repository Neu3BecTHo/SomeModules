<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Json;

/* @var $this yii\web\View */
/* @var $model app\modules\communal\models\RequestForm */
/* @var $items array */
/* @var $serviceData array */

$this->title = 'Передача показаний';

// Передаем массив тарифов в JS
$this->registerJs("var serviceData = " . Json::encode($serviceData) . ";", \yii\web\View::POS_HEAD);
?>

<div class="comm-container profile-page">
    <div class="comm-container profile-page">
        <div class="profile-header">
            <h1>Передача показаний</h1>
        </div>

        <?php $form = ActiveForm::begin(['id' => 'request-create-form']); ?>

        <!-- Шаг 1 -->
        <span class="section-title">1. Выберите услугу</span>
        <?= $form->field($model, 'service_type_id')->dropDownList($items, [
            'class' => 'comm-input', 
            'id' => 'service-select'
        ])->label(false) ?>

        <!-- Плашка тарифа -->
        <div id="tariff-info" style="display:none;">
            <span style="margin-right: 5px; opacity: 0.7;">Тариф:</span>
            <strong id="tariff-val">0</strong>&nbsp;руб./<span id="unit-val"></span>
        </div>

        <!-- Шаг 2 -->
        <span class="section-title">2. Введите показания</span>

        <label class="request-label">Предыдущие показания</label>
        <?= $form->field($model, 'previous_value')->textInput([
            'class' => 'comm-input', 
            'id' => 'prev-val',
            'readonly' => true 
        ])->label(false) ?>

        <label class="request-label">Текущие показания</label>
        <?= $form->field($model, 'current_value')->textInput([
            'class' => 'comm-input', 
            'id' => 'curr-val',
            'placeholder' => '0.00'
        ])->label(false) ?>

        <!-- Кнопка -->
        <?= Html::submitButton('Отправить заявку', ['class' => 'profile-save-btn']) ?>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php
// JS скрипт: автозаполнение предыдущих + калькулятор
$script = <<< JS
    var serviceSelect = $('#service-select');
    var prevInput = $('#prev-val');
    var currInput = $('#curr-val');
    var calcBlock = $('#calc-block');
    var tariffInfo = $('#tariff-info');

    // Функция обновления данных (вынесли отдельно)
    function updateServiceData() {
        var id = serviceSelect.val();
        
        // Если ничего не выбрано (пустота), скрываем всё
        if (!id) {
            tariffInfo.hide();
            calcBlock.hide();
            prevInput.val(''); 
            return;
        }

        // 1. Показываем тариф
        var data = serviceData[id];
        if (data) {
            $('#tariff-val').text(data.tariff);
            $('#unit-val').text(data.unit);
            $('.calc-unit').text(data.unit);
            tariffInfo.css('display', 'flex'); 
        }

        // 2. Грузим предыдущие показания
        $.get('last-value', { service_id: id }, function(value) {
            prevInput.val(value || 0);
            
            // Если мы перезагрузили страницу и в поле "Текущие" что-то осталось (от браузера)
            // можно попробовать пересчитать, но безопаснее очистить или оставить как есть.
            // calculate(); 
        });
    }

    // Обработчик смены селекта
    serviceSelect.on('change', function() {
        currInput.val(''); // При смене услуги очищаем текущее
        calcBlock.hide();
        updateServiceData();
    });

    // Обработчик ввода цифр
    currInput.on('input keyup', calculate);

    function calculate() {
        var id = serviceSelect.val();
        if (!id) return;

        var prev = parseFloat(prevInput.val()) || 0;
        var curr = parseFloat(currInput.val()) || 0;
        var tariff = parseFloat(serviceData[id].tariff) || 0;

        if (curr > prev) {
            calcBlock.show();
            var diff = curr - prev;
            var total = diff * tariff;

            $('#calc-consumption').text(diff.toFixed(2));
            $('#calc-total').text(total.toFixed(2));
        } else {
            calcBlock.hide();
        }
    }

    // ВАЖНО: Запускаем проверку при загрузке страницы!
    // Если браузер запомнил выбор или там выбрано первое значение по умолчанию
    if (serviceSelect.val()) {
        updateServiceData();
    }

JS;
$this->registerJs($script);
?>