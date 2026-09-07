<?php

namespace app\modules\tours\modules\adminTours\controllers;

use app\modules\tours\assets\ToursAdminAsset;
use app\modules\tours\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsersController extends Controller
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
        $users = User::find()->orderBy(['created_at' => SORT_DESC])->all();

        return $this->render('index', [
            'users' => $users,
        ]);
    }

    public function actionUserUpdate($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }

        $form = new \yii\base\DynamicModel([
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'patronymic' => $user->patronymic,
            'phone' => $user->phone,
            'email' => $user->email,
            'address' => $user->address,
        ]);

        $form->addRule(['first_name', 'last_name', 'patronymic', 'phone', 'email', 'address', 'role'], 'required')
            ->addRule('email', 'email');

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $user->updateAttributes([
                'first_name' => $form->first_name,
                'last_name' => $form->last_name,
                'patronymic' => $form->patronymic,
                'phone'   => $form->phone,
                'email'   => $form->email,
                'address' => $form->address,
            ]);

            Yii::$app->session->setFlash('success', 'Данные пользователя обновлены.');
            return $this->redirect(['index']);
        }

        return $this->render('user-update', [
            'formModel' => $form,
            'user'      => $user,
        ]);
    }

    public function actionUserDelete($id)
    {
        if (($model = User::findOne($id)) !== null) {
            $model->delete();
        }
        return $this->redirect(['index']);
    }
}