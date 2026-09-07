<?php

namespace app\modules\breadHouse\modules\adminBreadHouse\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\modules\breadHouse\models\User;
use app\modules\breadHouse\assets\BreadHouseAdminAsset;

/**
 * User management for admin
 */
class UserController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionToggleAdmin($id)
    {
        $user = $this->findModel($id);
        $user->is_admin = $user->is_admin ? 0 : 1;
        $user->save(false);
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
