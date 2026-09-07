<?php

namespace app\modules\personnelDepartment\controllers;

use app\modules\personnelDepartment\assets\PersonnelProfileAsset;
use app\modules\personnelDepartment\models\Questionnaires;
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
            PersonnelProfileAsset::register($this->view);
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
        $user = Yii::$app->userPersonnelDepartment->identity;
        $profile = Questionnaires::findOne(['user_id' => $user->id]);

        if (!$profile) {
            return $this->redirect(['questionnaires/index']);
        }

        // полезно подтянуть файлы
        $files = (new \yii\db\Query())
            ->from('{{%files}}')
            ->where(['profile_id' => $profile->id])
            ->all(Yii::$app->personnelDepartment);

        $filesByType = [];
        foreach ($files as $file) {
            $filesByType[$file['type']][] = $file;
        }

        return $this->render('index', [
            'user' => $user,
            'profile' => $profile,
            'filesByType' => $filesByType,
        ]);
    }
}
