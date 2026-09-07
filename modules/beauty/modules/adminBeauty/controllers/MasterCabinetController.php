<?php

namespace app\modules\beauty\modules\adminBeauty\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\modules\beauty\models\Master;
use app\modules\beauty\models\Service;
use app\modules\beauty\models\MasterService;
use app\modules\beauty\models\Schedule;
use app\modules\beauty\models\Photo;
use app\modules\beauty\models\Certificate;
use app\modules\beauty\models\Order;

/**
 * MasterCabinet controller - Personal cabinet for masters
 */
class MasterCabinetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'update-order-status' => ['GET', 'POST'],
                ],
            ],
        ];
    }

    /**
     * Master dashboard
     */
    public function actionIndex()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();

        if (!$master) {
            return $this->redirect(['profile']);
        }

        $stats = [
            'total' => Order::find()->where(['master_id' => $master->id])->count(),
            'new' => Order::find()->where(['master_id' => $master->id, 'status' => 'new'])->count(),
            'accepted' => Order::find()->where(['master_id' => $master->id, 'status' => 'accepted'])->count(),
            'completed' => Order::find()->where(['master_id' => $master->id, 'status' => 'completed'])->count(),
        ];

        $recentOrders = Order::find()
            ->where(['master_id' => $master->id])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(5)
            ->all();

        return $this->render('index', [
            'master' => $master,
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }

    /**
     * Edit master profile
     */
    public function actionProfile()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();

        if (!$master) {
            $master = new Master();
            $master->user_id = $user->id;
        }

        if ($master->load(Yii::$app->request->post())) {
            $photo = UploadedFile::getInstance($master, 'photoFile');
            if ($photo) {
                $filename = 'master_' . $user->id . '_' . time() . '.' . $photo->extension;
                $path = Yii::getAlias('@app/web/uploads/beauty/masters/');
                if (!is_dir($path)) mkdir($path, 0755, true);
                if ($photo->saveAs($path . $filename)) {
                    $master->photo = '/uploads/beauty/masters/' . $filename;
                }
            }

            if ($master->save()) {
                Yii::$app->session->setFlash('success', 'Профиль сохранен!');
                return $this->redirect(['index']);
            }
        }

        return $this->render('profile', ['master' => $master]);
    }

    /**
     * Manage services
     */
    public function actionServices()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();

        if (!$master) {
            throw new NotFoundHttpException('Сначала создайте профиль мастера');
        }

        if (Yii::$app->request->isPost) {
            // Add single service
            $serviceId = Yii::$app->request->post('service_id');
            $customPrice = Yii::$app->request->post('custom_price');
            if ($serviceId) {
                $ms = new MasterService();
                $ms->master_id = $master->id;
                $ms->service_id = $serviceId;
                $ms->custom_price = $customPrice ?: null;
                $ms->save();
                Yii::$app->session->setFlash('success', 'Услуга добавлена!');
            }
            return $this->redirect(['services']);
        }

        // Get available services (not yet added by this master)
        $myServiceIds = MasterService::find()->where(['master_id' => $master->id])->select('service_id')->column();
        $availableServices = Service::find()->where(['not in', 'id', $myServiceIds ?: [0]])->all();
        $masterServices = MasterService::find()->where(['master_id' => $master->id])->with('service')->all();

        return $this->render('services', [
            'master' => $master,
            'availableServices' => $availableServices,
            'masterServices' => $masterServices,
        ]);
    }

    /**
     * Delete service from master
     */
    public function actionDeleteService($id)
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();
        $ms = MasterService::find()->where(['id' => $id, 'master_id' => $master->id])->one();

        if ($ms) {
            $ms->delete();
            Yii::$app->session->setFlash('success', 'Услуга удалена!');
        }
        return $this->redirect(['services']);
    }

    /**
     * Manage schedule
     */
    public function actionSchedule()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();

        if (!$master) {
            throw new NotFoundHttpException('Сначала создайте профиль мастера');
        }

        $days = [1 => 'Понедельник', 2 => 'Вторник', 3 => 'Среда', 4 => 'Четверг', 5 => 'Пятница', 6 => 'Суббота', 7 => 'Воскресенье'];

        if (Yii::$app->request->isPost) {
            foreach ($days as $day => $label) {
                $schedule = Schedule::find()->where(['master_id' => $master->id, 'day_of_week' => $day])->one();
                if (!$schedule) {
                    $schedule = new Schedule();
                    $schedule->master_id = $master->id;
                    $schedule->day_of_week = $day;
                }
                $data = Yii::$app->request->post("day_$day", []);
                $schedule->is_available = !empty($data['is_available']);
                $schedule->start_time = $data['start'] ?? '09:00';
                $schedule->end_time = $data['end'] ?? '18:00';
                $schedule->save();
            }
            Yii::$app->session->setFlash('success', 'Расписание обновлено!');
            return $this->redirect(['schedule']);
        }

        $schedules = Schedule::find()->where(['master_id' => $master->id])->indexBy('day_of_week')->all();
        foreach ($days as $day => $label) {
            if (!isset($schedules[$day])) {
                $schedules[$day] = new Schedule(['master_id' => $master->id, 'day_of_week' => $day, 'is_available' => $day <= 5, 'start_time' => '09:00', 'end_time' => '18:00']);
            }
        }

        return $this->render('schedule', ['master' => $master, 'schedules' => $schedules, 'days' => $days]);
    }

    /**
     * Photo gallery
     */
    public function actionGallery()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();

        if (!$master) {
            throw new NotFoundHttpException('Сначала создайте профиль мастера');
        }

        if (Yii::$app->request->isPost) {
            $files = UploadedFile::getInstancesByName('photos');
            foreach ($files as $file) {
                $filename = 'work_' . $master->id . '_' . time() . rand(1000, 9999) . '.' . $file->extension;
                $path = Yii::getAlias('@app/web/uploads/beauty/gallery/');
                if (!is_dir($path)) mkdir($path, 0755, true);
                if ($file->saveAs($path . $filename)) {
                    $photo = new Photo();
                    $photo->master_id = $master->id;
                    $photo->image = '/uploads/beauty/gallery/' . $filename;
                    $photo->save();
                }
            }
            if (!empty($files)) {
                Yii::$app->session->setFlash('success', 'Фото добавлены!');
            }
            return $this->redirect(['gallery']);
        }

        $photos = Photo::find()->where(['master_id' => $master->id])->orderBy(['created_at' => SORT_DESC])->all();
        return $this->render('gallery', ['master' => $master, 'photos' => $photos]);
    }

    /**
     * Delete photo
     */
    public function actionDeletePhoto($id)
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();
        $photo = Photo::find()->where(['id' => $id, 'master_id' => $master->id])->one();

        if ($photo) {
            $path = Yii::getAlias('@app/web') . $photo->image;
            if (file_exists($path)) unlink($path);
            $photo->delete();
            Yii::$app->session->setFlash('success', 'Фото удалено!');
        }
        return $this->redirect(['gallery']);
    }

    /**
     * Certificates
     */
    public function actionCertificates()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();

        if (!$master) {
            throw new NotFoundHttpException('Сначала создайте профиль мастера');
        }

        if (Yii::$app->request->isPost) {
            $files = UploadedFile::getInstancesByName('certificates');
            foreach ($files as $file) {
                $filename = 'cert_' . $master->id . '_' . time() . rand(1000, 9999) . '.' . $file->extension;
                $path = Yii::getAlias('@app/web/uploads/beauty/certificates/');
                if (!is_dir($path)) mkdir($path, 0755, true);
                if ($file->saveAs($path . $filename)) {
                    $cert = new Certificate();
                    $cert->master_id = $master->id;
                    $cert->image = '/uploads/beauty/certificates/' . $filename;
                    $cert->title = Yii::$app->request->post('cert_title');
                    $cert->issued_date = Yii::$app->request->post('cert_issued') ?: date('Y-m-d');
                    $cert->expiry_date = Yii::$app->request->post('cert_expiry');
                    $cert->save();
                }
            }
            if (!empty($files)) {
                Yii::$app->session->setFlash('success', 'Сертификаты добавлены!');
            }
            return $this->redirect(['certificates']);
        }

        $certificates = Certificate::find()->where(['master_id' => $master->id])->all();
        return $this->render('certificates', ['master' => $master, 'certificates' => $certificates]);
    }

    /**
     * Delete certificate
     */
    public function actionDeleteCertificate($id)
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();
        $cert = Certificate::find()->where(['id' => $id, 'master_id' => $master->id])->one();

        if ($cert) {
            $path = Yii::getAlias('@app/web') . $cert->image;
            if (file_exists($path)) unlink($path);
            $cert->delete();
            Yii::$app->session->setFlash('success', 'Сертификат удален!');
        }
        return $this->redirect(['certificates']);
    }

    /**
     * Orders management
     */
    public function actionOrders()
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();

        if (!$master) {
            throw new NotFoundHttpException('Сначала создайте профиль мастера');
        }

        $query = Order::find()->where(['master_id' => $master->id])->with(['client', 'service']);

        $status = Yii::$app->request->get('status');
        $dateFrom = Yii::$app->request->get('date_from');
        $dateTo = Yii::$app->request->get('date_to');

        if ($status) {
            $query->andWhere(['status' => $status]);
        }
        if ($dateFrom) {
            $query->andWhere(['>=', 'appointment_date', $dateFrom]);
        }
        if ($dateTo) {
            $query->andWhere(['<=', 'appointment_date', $dateTo]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['appointment_date' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('orders', [
            'dataProvider' => $dataProvider,
            'status' => $status,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    /**
     * Update order status
     */
    public function actionUpdateOrderStatus($id, $status)
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();
        $order = Order::find()->where(['id' => $id, 'master_id' => $master->id])->one();

        if ($order && in_array($status, ['new', 'accepted', 'rejected', 'completed', 'cancelled'])) {
            $order->status = $status;
            $order->save();
            Yii::$app->session->setFlash('success', 'Статус обновлен!');
        }
        return $this->redirect(['orders']);
    }

    /**
     * View order details
     */
    public function actionViewOrder($id)
    {
        $user = Yii::$app->userBeauty->identity;
        $master = Master::find()->where(['user_id' => $user->id])->one();
        $order = Order::find()->where(['id' => $id, 'master_id' => $master->id])->with(['client', 'service', 'reviews'])->one();

        if (!$order) {
            throw new NotFoundHttpException('Заявка не найдена');
        }
        return $this->render('view-order', ['order' => $order]);
    }
}
