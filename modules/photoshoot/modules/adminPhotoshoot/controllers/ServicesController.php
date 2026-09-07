<?php

namespace app\modules\photoshoot\modules\adminPhotoshoot\controllers;

use app\modules\photoshoot\models\Service;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

class ServicesController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Service::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort_order' => SORT_ASC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Service();

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image && $model->validate()) {
                $fileName = 'service_' . time() . '.' . $model->image->extension;
                $model->image->saveAs(Yii::getAlias('@webroot/uploads/photoshoot/' . $fileName));
                $model->image = $fileName;
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Услуга создана.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($model, 'image');
            if ($image && $image->tempName) {
                $fileName = 'service_' . time() . '.' . $image->extension;
                $image->saveAs(Yii::getAlias('@webroot/uploads/photoshoot/' . $fileName));
                $model->image = $fileName;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Услуга обновлена.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->delete();

        Yii::$app->session->setFlash('success', 'Услуга удалена.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Услуга не найдена.');
    }
}
