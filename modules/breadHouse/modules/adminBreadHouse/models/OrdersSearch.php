<?php

namespace app\modules\breadHouse\modules\adminBreadHouse\models;

use app\modules\breadHouse\models\Orders;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * OrdersSearch represents the model behind the search form of `app\modules\breadHouse\models\Orders`.
 */
class OrdersSearch extends Orders
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status_id', 'created_at', 'updated_at'], 'integer'],
            [['total'], 'number'],
            [['payment_method', 'delivery_type', 'delivery_address', 'delivery_time'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Orders::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'status_id' => $this->status_id,
            'total' => $this->total,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'payment_method', $this->payment_method])
            ->andFilterWhere(['like', 'delivery_type', $this->delivery_type])
            ->andFilterWhere(['like', 'delivery_address', $this->delivery_address])
            ->andFilterWhere(['like', 'delivery_time', $this->delivery_time]);

        return $dataProvider;
    }
}
