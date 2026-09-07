<?php

namespace app\modules\photoshoot\modules\adminPhotoshoot\controllers;

use app\modules\photoshoot\models\Gallery;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

class GalleryController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Gallery::find(),
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
        $model = new Gallery();

        if ($model->load(Yii::$app->request->post())) {
            $model->image = UploadedFile::getInstance($model, 'image');
            if ($model->image && $model->validate()) {
                $fileName = 'gallery_' . time() . '.' . $model->image->extension;
                $model->image->saveAs(Yii::getAlias('@webroot/uploads/photoshoot/' . $fileName));
                $model->image = $fileName;
            }

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Фотография добавлена в галерею.');
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
                $fileName = 'gallery_' . time() . '.' . $image->extension;
                $image->saveAs(Yii::getAlias('@webroot/uploads/photoshoot/' . $fileName));
                $model->image = $fileName;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Фотография обновлена.');
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

        Yii::$app->session->setFlash('success', 'Фотография удалена.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Gallery::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Фотография не найдена.');
    }
}
