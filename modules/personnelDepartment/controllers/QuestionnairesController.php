<?php

namespace app\modules\personnelDepartment\controllers;

use app\modules\personnelDepartment\assets\PersonnelQuestionnairesAsset;
use app\modules\PersonnelDepartment\models\Questionnaires;
use app\modules\personnelDepartment\models\QuestionnairesForm;
use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;

class QuestionnairesController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            PersonnelQuestionnairesAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        /** @var User $user */
        $user = Yii::$app->userPersonnelDepartment->identity;

        // Ищем анкету
        $profile = Questionnaires::findOne(['user_id' => $user->id]);

        // Если нет — создаём минимальную строку один раз
        if ($profile === null) {
            $profile = new Questionnaires();
            $profile->user_id = $user->id;
            $profile->status_id = $this->getNewStatusId();
            $profile->phone = $user->phone;
            $profile->email = $user->email;
            $profile->save(false);
        }

        $model = new QuestionnairesForm();
        $model->attributes = $profile->attributes;

        $fullName = trim($user->last_name . ' ' . $user->first_name . ' ' . $user->patronymic);

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->loadFiles();

            if ($model->validate()) {
                $attrs = [
                    'birth_date'               => $model->birth_date,
                    'gender'                   => $model->gender,
                    'citizenship'              => $model->citizenship,
                    'passport_series'          => $model->passport_series,
                    'passport_number'          => $model->passport_number,
                    'passport_issued_by'       => $model->passport_issued_by,
                    'passport_issued_at'       => $model->passport_issued_at,
                    'registration_address'     => $model->registration_address,
                    'marital_status'           => $model->marital_status,
                    'education_level'          => $model->education_level,
                    'education_org_name'       => $model->education_org_name,
                    'education_specialty'      => $model->education_specialty,
                    'education_diploma_series' => $model->education_diploma_series,
                    'education_diploma_number' => $model->education_diploma_number,
                    'snils_number'             => $model->snils_number,
                    'workplace'                => $model->workplace,
                    'position'                 => $model->position,
                    'experience_years'         => $model->experience_years,
                    'health_state'             => $model->health_state,
                    'phone'                    => $user->phone,
                    'email'                    => $user->email,
                    'extra_info'               => $model->extra_info,
                    'status_id'                => $this->getNewStatusId(), // «Новая»
                ];

                // одно массовое обновление всех полей
                $profile->updateAttributes($attrs);

                // файлы – как раньше
                $this->saveFile($profile->id, 'photo',         $model->photo_file);
                $this->saveFile($profile->id, 'passport_scan', $model->passport_scan);
                $this->saveFile($profile->id, 'diploma_scan',  $model->diploma_scan);
                $this->saveFile($profile->id, 'snils_scan',    $model->snils_scan);

                Yii::$app->session->setFlash('success', 'Анкета передана на рассмотрение.');
                return $this->redirect(['profile/index']);
            }
        }

        return $this->render('index', [
            'model'    => $model,
            'user'     => $user,
            'fullName' => $fullName,
        ]);
    }

    protected function getNewStatusId(): int
    {
        return (int)Yii::$app->personnelDepartment->createCommand("SELECT id FROM {{%statuses}} WHERE code = 'new'")->queryScalar();
    }

    protected function saveFile(int $profileId, string $type, ?UploadedFile $file): void
    {
        if (!$file) {
            return;
        }

        $basePath = Yii::getAlias('@webroot/uploads/hr');
        if (!is_dir($basePath)) {
            mkdir($basePath, 0775, true);
        }

        $fileName = $type . '_' . $profileId . '_' . time() . '.' . $file->extension;
        $path = $basePath . '/' . $fileName;

        if ($file->saveAs($path)) {
            Yii::$app->personnelDepartment->createCommand()->insert('{{%files}}', [
                'profile_id' => $profileId,
                'type' => $type,
                'file_path' => '/uploads/hr/' . $fileName,
                'file_name' => $file->name,
                'mime_type' => $file->type,
                'size' => $file->size,
                'created_at' => time(),
            ])->execute();
        }
    }
}