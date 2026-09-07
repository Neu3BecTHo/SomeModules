<?php

namespace app\modules\cleaner\controllers;

use app\modules\cleaner\assets\CleanerOrdersAsset;
use app\modules\cleaner\models\Orders;
use app\modules\cleaner\models\OrderForm;
use app\modules\cleaner\models\Categories;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;

class OrdersController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            CleanerOrdersAsset::register($this->view);

            if (Yii::$app->userCleaner->isGuest) {
                return $this->redirect(['main/index']);
            }
            return true;
        }
        return false;
    }

    /**
     * Мои заявки.
     */
    public function actionIndex()
    {
        $userId = Yii::$app->userCleaner->id;

        $orders = Orders::find()
            ->where(['user_id' => $userId])
            ->with('category')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'orders' => $orders,
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->userCleaner->isGuest) {
            return $this->redirect(['main/index']);
        }
        $model = new OrderForm();

        $categories = ArrayHelper::map(
            Categories::find()->orderBy(['id' => SORT_ASC])->all(),
            'id',
            'title'
        );

        if ($model->load(Yii::$app->request->post()) && ($order = $model->create())) {
            return $this->redirect(['orders/index']);
        }

        return $this->render('create', [
            'model'      => $model,
            'categories' => $categories,
        ]);
    }
}
