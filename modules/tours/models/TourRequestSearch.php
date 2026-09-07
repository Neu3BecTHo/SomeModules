<?php

namespace app\modules\tours\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class TourRequestSearch extends Model
{
    public $status;
    public $tour_id;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['status'], 'string'],
            [['tour_id'], 'integer'],
            [['date_from', 'date_to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = Requests::find()->with(['tour', 'user']);

        $this->load($params);

        if ($this->tour_id) {
            $query->andWhere(['tour_id' => $this->tour_id]);
        }

        if ($this->status) {
            $query->andWhere(['status' => $this->status]);
        }

        if ($this->date_from) {
            $query->andWhere(['>=', 'date', $this->date_from]);
        }

        if ($this->date_to) {
            $query->andWhere(['<=', 'date', $this->date_to]);
        }

        return new ActiveDataProvider([
            'query' => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 15],
        ]);
    }
}
