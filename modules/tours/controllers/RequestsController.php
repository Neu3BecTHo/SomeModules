<?php

namespace app\modules\tours\controllers;

use app\modules\tours\assets\ToursRequestsAsset;
use app\modules\tours\models\RequestForm;
use app\modules\tours\models\Requests;
use app\modules\tours\models\Reviews;
use app\modules\tours\models\Tours;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RequestsController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            ToursRequestsAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * Мои заявки.
     */
    public function actionIndex()
    {
        $query = Requests::find()
            ->with(['tour'])
            ->where(['user_id' => Yii::$app->userTours->id])
            ->orderBy(['created_at' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Оформление заявки.
     * @param int|null $tourId
     */
    public function actionCreate($tourId = null)
    {
        $model = new RequestForm();

        if ($tourId) {
            $model->tour_id = (int)$tourId;
        }

        // Список туров для выпадающего списка
        $tours = Tours::find()
            ->where(['is_active' => true])
            ->orderBy(['title' => SORT_ASC])
            ->all();

        if ($model->load(Yii::$app->request->post()) &&
            ($request = $model->create(Yii::$app->userTours->id))) {

            Yii::$app->session->setFlash('success', 'Заявка отправлена и направлена на рассмотрение администратору.');
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
            'tours' => $tours,
        ]);
    }

    /**
     * Создание отзыва по завершённой заявке.
     * @param int $id ID заявки
     */
    public function actionReview($id)
    {
        $request = Requests::findOne([
            'id' => $id,
            'user_id' => Yii::$app->userTours->id,
        ]);

        if (!$request) {
            throw new NotFoundHttpException('Заявка не найдена.');
        }

        if (!in_array($request->status, ['accepted', 'Заявка принята'], true)) {
            Yii::$app->session->setFlash('error', 'Отзыв можно оставить только по принятой заявке.');
            return $this->redirect(['index']);
        }

        $review = new Reviews();
        $review->tour_id = $request->tour_id;
        $review->user_id = $request->user_id;
        $review->request_id = $request->id;
        $review->rating = 5;

        if ($review->load(Yii::$app->request->post()) && $review->save()) {
            Yii::$app->session->setFlash('success', 'Спасибо за отзыв!');
            return $this->redirect(['index']);
        }

        return $this->render('review', [
            'model' => $review,
            'request' => $request,
        ]);
    }
}
