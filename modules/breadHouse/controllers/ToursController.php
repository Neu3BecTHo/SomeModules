<?php

namespace app\modules\tours\controllers;

use app\modules\tours\assets\ToursToursAsset;
use app\modules\tours\models\Reviews;
use app\modules\tours\models\Tours;
use app\modules\tours\models\ToursSearch;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ToursController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            ToursToursAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * Каталог туров с фильтрацией по цене/датам.
     */
    public function actionIndex()
    {
        $searchModel = new ToursSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /** @var Tours[] $tours */
        $tours = $dataProvider->query->all();

        return $this->render('index', [
        'searchModel' => $searchModel,
        'tours'       => $tours,
    ]);
    }

    /**
     * Просмотр одного тура + отзывы.
     *
     * @param int $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = Tours::findOne(['id' => $id, 'is_active' => true]);
        if ($model === null) {
            throw new NotFoundHttpException('Тур не найден.');
        }

        $reviews = Reviews::find()
            ->with(['user'])
            ->where(['tour_id' => $model->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('view', [
            'model'   => $model,
            'reviews' => $reviews,
        ]);
    }
}