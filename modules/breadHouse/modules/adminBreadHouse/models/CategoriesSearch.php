<?php

namespace app\modules\breadHouse\modules\adminBreadHouse\models;

use app\modules\breadHouse\models\Categories;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CategoriesSearch represents the model behind the search form of `app\modules\breadHouse\models\Categories`.
 */
class CategoriesSearch extends Categories
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title'], 'safe'],
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
        $query = Categories::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
