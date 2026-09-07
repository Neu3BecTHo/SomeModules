<?php

namespace app\modules\photoshoot\modules\adminPhotoshoot\controllers;

use app\modules\photoshoot\models\User;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use Yii;

class UsersController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
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

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionToggleAdmin($id)
    {
        $model = $this->findModel($id);
        $model->is_admin = $model->is_admin ? 0 : 1;
        $model->save();

        Yii::$app->session->setFlash('success', 'Роль пользователя обновлена.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Пользователь не найден.');
    }
}
