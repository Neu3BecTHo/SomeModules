<?php

namespace app\modules\breadHouse\modules\adminBreadHouse\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use app\modules\breadHouse\models\Product;
use app\modules\breadHouse\modules\adminBreadHouse\models\ProductSearch;
use app\modules\breadHouse\assets\BreadHouseAdminAsset;

/**
 * Product management for admin
 */
class ProductController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseAdminAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post())) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            
            if ($model->validate()) {
                if ($model->save()) {
                    // Handle multiple images upload
                    if (!empty($model->imageFiles)) {
                        $uploadResult = $model->uploadMultipleImages();
                        if (!$uploadResult) {
                            Yii::$app->session->setFlash('error', 'Ошибка при загрузке изображений. Проверьте формат и размер файлов.');
                        }
                    }
                    
                    // Set first image as main image if uploaded
                    $firstImage = \app\modules\breadHouse\models\ProductImages::find()
                        ->where(['product_id' => $model->id])
                        ->orderBy(['sort_order' => SORT_ASC])
                        ->one();
                    if ($firstImage) {
                        $model->image = $firstImage->image;
                        $model->save();
                    }
                    
                    return $this->redirect(['index']);
                }
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
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            
            if ($model->validate()) {
                if ($model->save()) {
                    // Handle multiple images upload
                    if (!empty($model->imageFiles)) {
                        $uploadResult = $model->uploadMultipleImages();
                        if (!$uploadResult) {
                            Yii::$app->session->setFlash('error', 'Ошибка при загрузке изображений. Проверьте формат и размер файлов.');
                        }
                    }
                    
                    // If no main image exists, set first uploaded image as main
                    if (!$model->image) {
                        $firstImage = \app\modules\breadHouse\models\ProductImages::find()
                            ->where(['product_id' => $model->id])
                            ->orderBy(['sort_order' => SORT_ASC])
                            ->one();
                        if ($firstImage) {
                            $model->image = $firstImage->image;
                            $model->save();
                        }
                    }
                    
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteAllImages(); // Delete all image files
        $model->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Товар не найден.');
    }
}
