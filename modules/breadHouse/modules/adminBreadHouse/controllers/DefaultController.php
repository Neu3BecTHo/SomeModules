<?php

namespace app\modules\breadHouse\modules\adminBreadHouse\controllers;

use Yii;
use yii\web\Controller;
use app\modules\breadHouse\models\Orders;
use app\modules\breadHouse\modules\adminBreadHouse\models\OrdersSearch;
use app\modules\breadHouse\assets\BreadHouseAdminAsset;

/**
 * Default admin controller
 */
class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseAdminAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
