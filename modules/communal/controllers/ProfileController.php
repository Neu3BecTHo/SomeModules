<?php

namespace app\modules\communal\controllers;

use app\modules\communal\assets\CommunalProfileAsset;
use app\modules\communal\models\ProfileForm;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `communal` module
 */
class ProfileController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            CommunalProfileAsset::register($this->view);
            return true;
        }
        return false;
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->userCommunal->isGuest) {
            return $this->redirect(['auth/login']);
        }

        $user = Yii::$app->userCommunal->identity;
        $model = new ProfileForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('success', 'Профиль успешно обновлен');
            return $this->refresh();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
