<?php

namespace app\modules\cleaner\models;

use yii\base\Model;
use Yii;
use app\modules\cleaner\models\Orders;
use app\modules\cleaner\models\Statuses;

class OrderForm extends Model
{
    public $category_id;
    public $address;
    public $payment_type;
    public $extra_info_enabled;
    public $extra_info;

    public $item_type;
    public $material;
    public $pollution_level;
    public $carpet_size;

    public function rules()
    {
        return [
            [['category_id', 'address', 'payment_type'], 'required'],
            [['category_id'], 'integer'],
            [['extra_info_enabled'], 'boolean'],
            [['extra_info'], 'string'],
            [['item_type', 'material', 'pollution_level', 'carpet_size'], 'string', 'max' => 100],
            ['payment_type', 'in', 'range' => ['cash', 'cashless']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'category_id'        => 'Категория услуги',
            'address'            => 'Адрес проживания',
            'payment_type'       => 'Способ оплаты',
            'extra_info_enabled' => 'Дополнительная информация по услуге',
            'extra_info'         => 'Комментарий',
            'item_type'          => 'Вид (обувь/одежда/мебель)',
            'material'           => 'Материал',
            'pollution_level'    => 'Степень загрязнения',
            'carpet_size'        => 'Размер ковра',
        ];
    }

    public function create()
    {
        if (!$this->validate()) {
            return null;
        }

        $order = new Orders();
        $order->user_id         = Yii::$app->userCleaner->id;
        $order->category_id     = $this->category_id;
        $order->address         = $this->address;
        $order->payment_type    = $this->payment_type;
        $order->extra_info      = $this->extra_info_enabled ? $this->extra_info : null;
        $order->item_type       = $this->item_type;
        $order->material        = $this->material;
        $order->pollution_level = $this->pollution_level;
        $order->carpet_size     = $this->carpet_size;

        return $order->save() ? $order : null;
    }
}