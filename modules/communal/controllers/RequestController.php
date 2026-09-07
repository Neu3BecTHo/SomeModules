<?php

namespace app\modules\communal\controllers;

use app\modules\communal\assets\CommunalRequestAsset;
use app\modules\communal\models\RequestForm;
use Yii;
use yii\web\Controller;
use app\modules\communal\models\Requests;
use app\modules\communal\models\ServiceTypes;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Response;

class RequestController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            CommunalRequestAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        if (Yii::$app->userCommunal->isGuest) {
            return $this->redirect(['auth/login']);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => Requests::find()
                ->where(['user_id' => Yii::$app->userCommunal->id])
                ->with(['serviceType', 'status']),
            'sort' => ['defaultOrder' => ['created_at' => SORT_DESC]],
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->userCommunal->isGuest) {
            return $this->redirect(['auth/login']);
        }

        $model = new RequestForm();

        // Если форма отправлена и валидна
        if ($model->load(Yii::$app->request->post()) && $model->createRequest(Yii::$app->userCommunal->id)) {
            Yii::$app->session->setFlash('success', 'Показания успешно переданы!');
            return $this->redirect(['index']);
        }

        $services = ServiceTypes::find()->all();
        $items = ArrayHelper::map($services, 'id', 'title');

        // Данные для JS (тарифы и единицы измерения)
        // Формат: { 1: {tariff: 5.03, unit: 'кВт'}, 2: {...} }
        $serviceData = [];
        foreach ($services as $s) {
            $serviceData[$s->id] = [
                'tariff' => $s->tariff,
                'unit' => $s->unit,
            ];
        }

        return $this->render('create', [
            'model' => $model,
            'items' => $items,
            'serviceData' => $serviceData,
        ]);
    }
    public function actionLastValue($service_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (Yii::$app->userCommunal->isGuest) {
            return 0;
        }

        // Ищем последнюю заявку этого пользователя по этой услуге
        $lastRequest = Requests::find()
            ->where([
                'user_id' => Yii::$app->userCommunal->id,
                'service_type_id' => $service_id
            ])
            ->orderBy(['created_at' => SORT_DESC])
            ->one();

        return $lastRequest ? $lastRequest->current_value : 0;
    }
}
