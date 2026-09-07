<?php

namespace app\modules\photoshoot\modules\adminPhotoshoot\controllers;

use app\modules\photoshoot\models\News;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

class NewsController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find(),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new News();

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image && $model->validate()) {
                $fileName = 'news_' . time() . '.' . $model->image->extension;
                $model->image->saveAs(Yii::getAlias('@webroot/uploads/photoshoot/' . $fileName));
                $model->image = $fileName;
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Новость/акция создана.');
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
                $fileName = 'news_' . time() . '.' . $image->extension;
                $image->saveAs(Yii::getAlias('@webroot/uploads/photoshoot/' . $fileName));
                $model->image = $fileName;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Новость/акция обновлена.');
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

        Yii::$app->session->setFlash('success', 'Новость/акция удалена.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Новость не найдена.');
    }
}
