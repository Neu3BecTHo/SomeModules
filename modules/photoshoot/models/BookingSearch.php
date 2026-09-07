<?php

namespace app\modules\photoshoot\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class BookingSearch extends Model
{
    public $id;
    public $user_id;
    public $service_type;
    public $hall_type;
    public $status;
    public $date_from;
    public $date_to;

    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['service_type', 'hall_type', 'status', 'date_from', 'date_to'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Booking::find()->with('user');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'service_type' => $this->service_type,
            'hall_type' => $this->hall_type,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['>=', 'booking_date', $this->date_from])
            ->andFilterWhere(['<=', 'booking_date', $this->date_to]);

        return $dataProvider;
    }
}
