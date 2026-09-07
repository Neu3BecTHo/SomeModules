<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseProfileAsset;
use app\modules\breadHouse\models\Reviews;
use Yii;
use yii\web\Controller;

/**
 * Profile controller for user profile management
 */
class ProfileController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if (Yii::$app->userBreadHouse->isGuest) {
                return $this->redirect(['auth/login']);
            }
            BreadHouseProfileAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * View and edit profile
     */
    public function actionIndex()
    {
        $user = Yii::$app->userBreadHouse->identity;

        if (Yii::$app->request->isPost) {
            $user->scenario = 'profile';
            $user->load(Yii::$app->request->post());
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Профиль обновлен.');
            }
        }

        // Get user's reviews
        $reviews = Reviews::find()
            ->where(['user_id' => $user->id])
            ->with('product')
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'user' => $user,
            'reviews' => $reviews,
        ]);
    }
}
