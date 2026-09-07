<?php

namespace app\modules\tours\modules\adminTours\controllers;

use app\modules\tours\assets\ToursAdminAsset;
use app\modules\tours\models\Tours;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ToursController extends Controller
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
        $tours = Tours::find()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', [
            'tours' => $tours,
        ]);
    }

    public function actionTourCreate()
    {
        $model = new Tours();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->uploadAndSave()) {
                Yii::$app->session->setFlash('success', 'Тур создан.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('tour-form', ['model' => $model]);
    }

    public function actionTourUpdate($id)
    {
        $model = Tours::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('Тур не найден.');
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->validate(['title', 'short_description', 'description', 'price', 'duration_days', 'is_active', 'imageFile'])) {

                if ($model->imageFile) {
                    $fileName = 'tour_' . time() . '_' . mt_rand(1000, 9999) . '.' . $model->imageFile->extension;
                    $path = Yii::getAlias('@webroot/uploads/tours/' . $fileName);

                    if (!is_dir(dirname($path))) {
                        mkdir(dirname($path), 0775, true);
                    }

                    if ($model->imageFile->saveAs($path)) {
                        $model->updateAttributes([
                            'image' => '/uploads/tours/' . $fileName,
                        ]);
                    }
                }

                $model->updateAttributes([
                    'title'             => $model->title,
                    'short_description' => $model->short_description,
                    'description'       => $model->description,
                    'price'             => $model->price,
                    'duration_days'     => $model->duration_days,
                    'is_active'         => (int)$model->is_active,
                ]);

                Yii::$app->session->setFlash('success', 'Тур обновлён.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('tour-form', ['model' => $model]);
    }

    public function actionTourDelete($id)
    {
        if ($tour = Tours::findOne($id)) {
            $tour->delete();
        }
        return $this->redirect(['index']);
    }
}