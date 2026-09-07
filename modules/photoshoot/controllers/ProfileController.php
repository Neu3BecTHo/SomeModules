<?php

namespace app\modules\photoshoot\controllers;

use app\modules\photoshoot\models\User;
use yii\web\Controller;
use yii\filters\AccessControl;
use Yii;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'user' => 'userPhotoshoot',
            ],
        ];
    }

    public function actionIndex()
    {
        $model = User::findOne(Yii::$app->userPhotoshoot->id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Профиль обновлен.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
