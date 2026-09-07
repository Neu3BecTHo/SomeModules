<?php

namespace app\modules\tours\models;

use yii\base\Model;

class RequestForm extends Model
{
    public $tour_id;
    public $date;
    public $participants_count;
    public $options;
    public $wishes;
    public $comment;
    public $payment_method;

    public function rules()
    {
        return [
            [['tour_id', 'date', 'participants_count', 'payment_method'], 'required'],

            ['tour_id', 'integer'],
            ['date', 'date', 'format' => 'php:Y-m-d'],
            ['participants_count', 'integer', 'min' => 1, 'max' => 50],

            [['wishes', 'comment'], 'string', 'max' => 255],
            ['payment_method', 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tour_id' => 'Тур',
            'date' => 'Дата поездки',
            'participants_count' => 'Количество участников',
            'options' => 'Дополнительные опции',
            'wishes' => 'Дополнительные пожелания',
            'comment' => 'Комментарий',
            'payment_method' => 'Способ оплаты',
        ];
    }

    public function create(int $userId): ?Requests
    {
        if (!$this->validate()) {
            return null;
        }

        $request = new Requests();
        $request->user_id = $userId;
        $request->tour_id = $this->tour_id;
        $request->date = $this->date;
        $request->participants_count = $this->participants_count;
        $request->options = $this->options;
        $request->wishes = $this->wishes;
        $request->comment = $this->comment;
        $request->payment_method = $this->payment_method;
        $request->status = 'new';

        return $request->save() ? $request : null;
    }
}
