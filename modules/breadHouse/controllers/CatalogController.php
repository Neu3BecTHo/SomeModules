<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseCatalogAsset;
use app\modules\breadHouse\models\Categories;
use app\modules\breadHouse\models\Product;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

/**
 * Catalog controller for products
 */
class CatalogController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseCatalogAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * Lists all products with filtering and sorting
     */
    public function actionIndex()
    {
        $query = Product::find()->where(['>', 'stock', 0]);

        // Filter by category if provided
        $categoryId = Yii::$app->request->get('category');
        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }

        // Sort
        $sort = Yii::$app->request->get('sort', 'new');
        switch ($sort) {
            case 'name':
                $query->orderBy(['name' => SORT_ASC]);
                break;
            case 'price_asc':
                $query->orderBy(['price' => SORT_ASC]);
                break;
            case 'price_desc':
                $query->orderBy(['price' => SORT_DESC]);
                break;
            case 'new':
            default:
                $query->orderBy(['created_at' => SORT_DESC]);
                break;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 12],
        ]);

        $categories = Categories::find()->orderBy(['title' => SORT_ASC])->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'currentCategory' => $categoryId,
            'currentSort' => $sort,
        ]);
    }
}
