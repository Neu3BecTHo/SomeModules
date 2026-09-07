<?php

namespace app\modules\communal\modules\adminCommunal\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use app\modules\communal\models\Requests;
use app\modules\communal\models\RequestStatuses;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

// Наследуемся от базового контроллера админки!
class RequestController extends Controller
{
    /**
     * Список всех заявок
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Requests::find()->with(['user', 'serviceType', 'status']),
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Смена статуса (Принять / Отклонить)
     */
    public function actionSetStatus($id, $status_code)
    {
        $model = $this->findModel($id);

        // Ищем статус по коду из таблицы request_statuses
        $status = RequestStatuses::findOne(['code' => $status_code]);
        if ($status === null) {
            Yii::$app->session->setFlash('error', 'Статус с кодом "' . $status_code . '" не найден.');
            return $this->redirect(['index']);
        }

        // Обновляем ТОЛЬКО поле status_id, минуя валидацию/события
        $model->updateAttributes([
            'status_id' => $status->id,
        ]);

        Yii::$app->session->setFlash('success', 'Статус заявки обновлён.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Requests::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Заявка не найдена.');
    }
}
