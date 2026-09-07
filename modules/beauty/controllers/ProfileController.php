<?php

namespace app\modules\beauty\controllers;

use Yii;
use yii\web\Controller;
use app\modules\beauty\models\Master;
use app\modules\beauty\models\User;

/**
 * Profile controller
 */
class ProfileController extends Controller
{

    /**
     * Displays user profile.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = User::findOne(Yii::$app->userBeauty->id);
        $master = null;
        
        if ($user->role === 'master') {
            $master = Master::find()
                ->where(['user_id' => $user->id])
                ->with(['services', 'photos', 'schedule'])
                ->one();
        }

        return $this->render('index', [
            'user' => $user,
            'master' => $master,
        ]);
    }

    /**
     * Updates user profile.
     *
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        $user = User::findOne(Yii::$app->userBeauty->id);
        
        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('success', 'Профиль успешно обновлен!');
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'user' => $user,
        ]);
    }
}
