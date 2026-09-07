<?php

namespace app\modules\beauty\modules\adminBeauty\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use app\modules\beauty\models\User;
use app\modules\beauty\models\Master;
use app\modules\beauty\models\Order;
use app\modules\beauty\models\Service;
use app\modules\beauty\models\Category;

/**
 * Users controller for admin module
 */
class UsersController extends Controller
{
    /**
     * Lists all users.
     *
     * @return string
     */
    public function actionIndex()
    {
        $users = User::find()
            ->where(['role' => 'client'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'users' => $users,
        ]);
    }

    /**
     * Lists all masters.
     *
     * @return string
     */
    public function actionMasters()
    {
        $masters = Master::find()
            ->with(['user'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('masters', [
            'masters' => $masters,
        ]);
    }

    /**
     * Approves a master.
     *
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionApprove($id)
    {
        $master = Master::findOne($id);
        if (!$master) {
            throw new NotFoundHttpException('Мастер не найден.');
        }

        $master->is_approved = true;
        $master->save();

        Yii::$app->session->setFlash('success', 'Мастер успешно одобрен.');
        return $this->redirect(['masters']);
    }

    /**
     * Deletes a user.
     *
     * @param int $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }

        if ($user->delete()) {
            Yii::$app->session->setFlash('success', 'Пользователь успешно удален.');
        }

        return $this->redirect(['index']);
    }
}
