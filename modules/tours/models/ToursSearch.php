<?php

namespace app\modules\tours\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ToursSearch extends Model
{
    public $date_from;
    public $date_to;
    public $price_from;
    public $price_to;

    public function rules()
    {
        return [
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
            [['price_from', 'price_to'], 'number', 'min' => 0],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Tours::find()->where(['is_active' => true]);

        $this->load($params);

        if (!$this->validate()) {
            $query->andWhere('0=1');
        }

        if ($this->price_from !== null && $this->price_from !== '') {
            $query->andWhere(['>=', 'price', $this->price_from]);
        }

        if ($this->price_to !== null && $this->price_to !== '') {
            $query->andWhere(['<=', 'price', $this->price_to]);
        }

        return new ActiveDataProvider([
            'query'      => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);
    }
}