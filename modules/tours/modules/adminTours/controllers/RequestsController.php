<?php

namespace app\modules\tours\modules\adminTours\controllers;

use app\modules\tours\assets\ToursAdminAsset;
use app\modules\tours\models\Requests;
use app\modules\tours\models\TourRequestSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RequestsController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            ToursAdminAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $searchModel = new TourRequestSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRequestUpdateStatus($id, $status)
    {
        $request = Requests::findOne($id);
        if (!$request) {
            throw new NotFoundHttpException('Заявка не найдена.');
        }

        if (!in_array($status, ['new', 'in_review', 'accepted'], true)) {
            throw new NotFoundHttpException('Некорректный статус.');
        }

        $request->updateAttributes(['status' => $status]);

        Yii::$app->session->setFlash('success', 'Статус заявки обновлён.');
        return $this->redirect(['index']);
    }
}