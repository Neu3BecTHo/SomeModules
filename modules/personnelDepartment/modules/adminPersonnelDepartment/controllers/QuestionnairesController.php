<?php

namespace app\modules\personnelDepartment\modules\adminPersonnelDepartment\controllers;

use app\modules\personnelDepartment\assets\PersonnelAdminAsset;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\modules\personnelDepartment\models\Questionnaires;
use app\modules\PersonnelDepartment\models\Statuses;

class QuestionnairesController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            PersonnelAdminAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        $query = Questionnaires::find()
            ->alias('q')
            ->joinWith(['user u', 'status s'])
            ->orderBy(['q.created_at' => SORT_DESC]);

        // фильтры из GET
        $gender = Yii::$app->request->get('gender');
        $citizenship = Yii::$app->request->get('citizenship');
        $education = Yii::$app->request->get('education_level');
        $position = Yii::$app->request->get('position');
        $marital = Yii::$app->request->get('marital_status');

        if ($gender !== null && $gender !== '') {
            $query->andWhere(['q.gender' => $gender]);
        }
        if ($citizenship !== null && $citizenship !== '') {
            $query->andWhere(['q.citizenship' => $citizenship]);
        }
        if ($education !== null && $education !== '') {
            $query->andWhere(['q.education_level' => $education]);
        }
        if ($position !== null && $position !== '') {
            $query->andWhere(['like', 'q.position', $position]);
        }
        if ($marital !== null && $marital !== '') {
            $query->andWhere(['q.marital_status' => $marital]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize' => 10],
        ]);

        $statuses = Statuses::find()->indexBy('code')->all();

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'statuses' => $statuses,
            'filters' => [
                'gender' => $gender,
                'citizenship' => $citizenship,
                'education_level' => $education,
                'position' => $position,
                'marital_status' => $marital,
            ],
        ]);
    }

    public function actionSetStatus($id, $code)
    {
        $profile = Questionnaires::findOne($id);
        if (!$profile) {
            throw new \yii\web\NotFoundHttpException('Анкета не найдена.');
        }

        $statusId = Statuses::find()->select('id')->where(['code' => $code])->scalar();
        if (!$statusId) {
            Yii::$app->session->setFlash('error', 'Неизвестный статус.');
            return $this->redirect(['index']);
        }

        $profile->updateAttributes([
            'status_id' => (int)$statusId,
        ]);

        Yii::$app->session->setFlash('success', 'Статус анкеты обновлён.');
        return $this->redirect(['index']);
    }
}