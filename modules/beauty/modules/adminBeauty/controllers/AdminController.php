<?php

namespace app\modules\beauty\modules\adminBeauty\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use app\modules\beauty\models\User;
use app\modules\beauty\models\Master;
use app\modules\beauty\models\Service;
use app\modules\beauty\models\Category;
use app\modules\beauty\models\Order;
use app\modules\beauty\models\Review;
use app\modules\beauty\models\MasterService;

/**
 * Admin controller - Main administrator panel
 */
class AdminController extends Controller
{
    /**
     * Admin dashboard with statistics
     */
    public function actionIndex()
    {
        // Statistics
        $stats = [
            'users' => User::find()->where(['role' => 'client'])->count(),
            'masters' => Master::find()->count(),
            'masters_pending' => Master::find()->where(['is_approved' => false])->count(),
            'services' => Service::find()->count(),
            'orders_total' => Order::find()->count(),
            'orders_new' => Order::find()->where(['status' => 'new'])->count(),
            'orders_completed' => Order::find()->where(['status' => 'completed'])->count(),
            'reviews' => Review::find()->count(),
        ];

        // Recent orders
        $recentOrders = Order::find()
            ->with(['client', 'master', 'service'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(10)
            ->all();

        // Pending masters
        $pendingMasters = Master::find()
            ->where(['is_approved' => false])
            ->with('user')
            ->all();

        return $this->render('index', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'pendingMasters' => $pendingMasters,
        ]);
    }

    /**
     * List all users (clients)
     */
    public function actionUsers()
    {
        $search = Yii::$app->request->get('search');
        $query = User::find()->where(['!=', 'role', 'admin']);

        if ($search) {
            $query->andWhere(['or',
                ['like', 'full_name', $search],
                ['like', 'phone', $search],
            ]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('users', [
            'dataProvider' => $dataProvider,
            'search' => $search,
        ]);
    }

    /**
     * View user details
     */
    public function actionViewUser($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        $orders = Order::find()
            ->where(['client_id' => $user->id])
            ->with(['master', 'service'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('view-user', [
            'user' => $user,
            'orders' => $orders,
        ]);
    }

    /**
     * Edit user
     */
    public function actionEditUser($id)
    {
        $user = User::findOne($id);
        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден');
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            Yii::$app->session->setFlash('success', 'Пользователь обновлен!');
            return $this->redirect(['users']);
        }

        return $this->render('edit-user', ['user' => $user]);
    }

    /**
     * Delete user
     */
    public function actionDeleteUser($id)
    {
        $user = User::findOne($id);
        if ($user && $user->delete()) {
            Yii::$app->session->setFlash('success', 'Пользователь удален!');
        }
        return $this->redirect(['users']);
    }

    /**
     * List all masters
     */
    public function actionMasters()
    {
        $status = Yii::$app->request->get('status');
        $query = Master::find()->with('user');

        if ($status === 'pending') {
            $query->andWhere(['is_approved' => false]);
        } elseif ($status === 'approved') {
            $query->andWhere(['is_approved' => true]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('masters', [
            'dataProvider' => $dataProvider,
            'status' => $status,
        ]);
    }

    /**
     * Approve master
     */
    public function actionApproveMaster($id)
    {
        $master = Master::findOne($id);
        if ($master) {
            $master->is_approved = true;
            $master->save();
            Yii::$app->session->setFlash('success', 'Мастер одобрен!');
        }
        return $this->redirect(['masters']);
    }

    /**
     * Reject/disapprove master
     */
    public function actionRejectMaster($id)
    {
        $master = Master::findOne($id);
        if ($master) {
            $master->is_approved = false;
            $master->save();
            Yii::$app->session->setFlash('success', 'Мастер отклонен!');
        }
        return $this->redirect(['masters']);
    }

    /**
     * View master details
     */
    public function actionViewMaster($id)
    {
        $master = Master::find()->where(['id' => $id])->with(['user', 'services', 'certificates', 'photos'])->one();
        if (!$master) {
            throw new NotFoundHttpException('Мастер не найден');
        }

        $orders = Order::find()
            ->where(['master_id' => $master->id])
            ->with(['client', 'service'])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('view-master', [
            'master' => $master,
            'orders' => $orders,
        ]);
    }

    /**
     * Delete master
     */
    public function actionDeleteMaster($id)
    {
        $master = Master::findOne($id);
        if ($master) {
            // Delete related data
            MasterService::deleteAll(['master_id' => $id]);
            // Delete master but keep user
            $master->delete();
            Yii::$app->session->setFlash('success', 'Мастер удален!');
        }
        return $this->redirect(['masters']);
    }

    /**
     * List all services
     */
    public function actionServices()
    {
        $categoryId = Yii::$app->request->get('category');
        $query = Service::find()->with('category');

        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['name' => SORT_ASC]),
            'pagination' => ['pageSize' => 20],
        ]);

        $categories = Category::find()->all();

        return $this->render('services', [
            'dataProvider' => $dataProvider,
            'categories' => $categories,
            'categoryId' => $categoryId,
        ]);
    }

    /**
     * Create service
     */
    public function actionCreateService()
    {
        $service = new Service();

        if ($service->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($service, 'imageFile');
            if ($image) {
                $filename = 'service_' . time() . '.' . $image->extension;
                $path = Yii::getAlias('@app/web/uploads/beauty/services/');
                if (!is_dir($path)) mkdir($path, 0755, true);
                if ($image->saveAs($path . $filename)) {
                    $service->image = '/uploads/beauty/services/' . $filename;
                }
            }

            if ($service->save()) {
                Yii::$app->session->setFlash('success', 'Услуга создана!');
                return $this->redirect(['services']);
            }
        }

        $categories = Category::find()->all();
        return $this->render('create-service', [
            'service' => $service,
            'categories' => $categories,
        ]);
    }

    /**
     * Edit service
     */
    public function actionEditService($id = null)
    {
        $id = $id ?? Yii::$app->request->get('id');
        if (!$id) {
            throw new NotFoundHttpException('Услуга не найдена');
        }
        $service = Service::findOne($id);
        if (!$service) {
            throw new NotFoundHttpException('Услуга не найдена');
        }

        if ($service->load(Yii::$app->request->post())) {
            $image = UploadedFile::getInstance($service, 'imageFile');
            if ($image) {
                $filename = 'service_' . time() . '.' . $image->extension;
                $path = Yii::getAlias('@app/web/uploads/beauty/services/');
                if (!is_dir($path)) mkdir($path, 0755, true);
                if ($image->saveAs($path . $filename)) {
                    $service->image = '/uploads/beauty/services/' . $filename;
                }
            }

            if ($service->save()) {
                Yii::$app->session->setFlash('success', 'Услуга обновлена!');
                return $this->redirect(['services']);
            }
        }

        $categories = Category::find()->all();
        return $this->render('edit-service', [
            'service' => $service,
            'categories' => $categories,
        ]);
    }

    /**
     * Delete service
     */
    public function actionDeleteService($id = null)
    {
        $id = $id ?? Yii::$app->request->get('id');
        $service = Service::findOne($id);
        if ($service) {
            MasterService::deleteAll(['service_id' => $id]);
            $service->delete();
            Yii::$app->session->setFlash('success', 'Услуга удалена!');
        }
        return $this->redirect(['services']);
    }

    /**
     * Manage service masters (which masters provide which services)
     */
    public function actionServiceMasters($id = null)
    {
        // Try route param, then query, then post
        $id = $id ?? Yii::$app->request->get('id') ?? Yii::$app->request->post('id');
        if (!$id) {
            throw new NotFoundHttpException('Услуга не найдена');
        }
        $service = Service::findOne($id);
        if (!$service) {
            throw new NotFoundHttpException('Услуга не найдена');
        }

        if (Yii::$app->request->isPost) {
            $masterIds = Yii::$app->request->post('masters', []);
            MasterService::deleteAll(['service_id' => $id]);

            foreach ($masterIds as $masterId) {
                $ms = new MasterService();
                $ms->master_id = $masterId;
                $ms->service_id = $id;
                $ms->custom_price = Yii::$app->request->post("price_$masterId");
                $ms->save();
            }
            Yii::$app->session->setFlash('success', 'Мастера обновлены!');
            return $this->redirect(['services']);
        }

        $masters = Master::find()->where(['is_approved' => true])->with('user')->all();
        $serviceMasters = MasterService::find()->where(['service_id' => $id])->indexBy('master_id')->all();

        return $this->render('service-masters', [
            'service' => $service,
            'masters' => $masters,
            'serviceMasters' => $serviceMasters,
        ]);
    }

    /**
     * List categories
     */
    public function actionCategories()
    {
        $categories = Category::find()->orderBy(['name' => SORT_ASC])->all();
        return $this->render('categories', ['categories' => $categories]);
    }

    /**
     * Create category
     */
    public function actionCreateCategory()
    {
        $category = new Category();

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            Yii::$app->session->setFlash('success', 'Категория создана!');
            return $this->redirect(['categories']);
        }

        return $this->render('create-category', ['category' => $category]);
    }

    /**
     * Edit category
     */
    public function actionEditCategory($id)
    {
        $category = Category::findOne($id);
        if (!$category) {
            throw new NotFoundHttpException('Категория не найдена');
        }

        if ($category->load(Yii::$app->request->post()) && $category->save()) {
            Yii::$app->session->setFlash('success', 'Категория обновлена!');
            return $this->redirect(['categories']);
        }

        return $this->render('edit-category', ['category' => $category]);
    }

    /**
     * Delete category
     */
    public function actionDeleteCategory($id)
    {
        $category = Category::findOne($id);
        if ($category) {
            // Reassign services to no category or delete them
            Service::updateAll(['category_id' => null], ['category_id' => $id]);
            $category->delete();
            Yii::$app->session->setFlash('success', 'Категория удалена!');
        }
        return $this->redirect(['categories']);
    }

    /**
     * List all orders
     */
    public function actionOrders()
    {
        $status = Yii::$app->request->get('status');
        $masterId = Yii::$app->request->get('master_id');
        $dateFrom = Yii::$app->request->get('date_from');
        $dateTo = Yii::$app->request->get('date_to');

        $query = Order::find()->with(['client', 'master', 'service']);

        if ($status) {
            $query->andWhere(['status' => $status]);
        }
        if ($masterId) {
            $query->andWhere(['master_id' => $masterId]);
        }
        if ($dateFrom) {
            $query->andWhere(['>=', 'appointment_date', $dateFrom]);
        }
        if ($dateTo) {
            $query->andWhere(['<=', 'appointment_date', $dateTo]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        $masters = Master::find()->where(['is_approved' => true])->with('user')->all();

        return $this->render('orders', [
            'dataProvider' => $dataProvider,
            'masters' => $masters,
            'status' => $status,
            'masterId' => $masterId,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'statusLabels' => ['new' => 'Новая', 'accepted' => 'Принята', 'rejected' => 'Отклонена', 'completed' => 'Завершена', 'cancelled' => 'Отменена'],
        ]);
    }

    /**
     * Update order status
     */
    public function actionUpdateOrderStatus($id, $status)
    {
        $order = Order::findOne($id);
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
        $order = Order::find()->where(['id' => $id])->with(['client', 'master', 'service', 'reviews'])->one();
        if (!$order) {
            throw new NotFoundHttpException('Заявка не найдена');
        }
        return $this->render('view-order', ['order' => $order]);
    }

    /**
     * List reviews
     */
    public function actionReviews()
    {
        $query = Review::find()->with(['client', 'master']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['created_at' => SORT_DESC]),
            'pagination' => ['pageSize' => 20],
        ]);

        return $this->render('reviews', ['dataProvider' => $dataProvider]);
    }

    /**
     * Toggle review visibility/moderation
     */
    public function actionToggleReview($id)
    {
        $review = Review::findOne($id);
        if ($review) {
            $review->is_visible = !$review->is_visible;
            $review->save();
            Yii::$app->session->setFlash('success', 'Отзыв обновлен!');
        }
        return $this->redirect(['reviews']);
    }

    /**
     * Delete review
     */
    public function actionDeleteReview($id)
    {
        $review = Review::findOne($id);
        if ($review && $review->delete()) {
            Yii::$app->session->setFlash('success', 'Отзыв удален!');
        }
        return $this->redirect(['reviews']);
    }

    /**
     * Reports page
     */
    public function actionReports()
    {
        // Orders by status
        $ordersByStatus = Order::find()
            ->select(['status', 'COUNT(*) as count'])
            ->groupBy('status')
            ->asArray()
            ->all();

        // Revenue by month (last 6 months)
        $revenueData = Order::find()
            ->select([
                "DATE_FORMAT(appointment_date, '%Y-%m') as month",
                'SUM(total_price) as revenue',
                'COUNT(*) as count'
            ])
            ->where(['status' => 'completed'])
            ->andWhere(['>=', 'appointment_date', date('Y-m-d', strtotime('-6 months'))])
            ->groupBy('month')
            ->orderBy('month')
            ->asArray()
            ->all();

        // Popular services
        $popularServices = Order::find()
            ->select(['service_id', 'COUNT(*) as count', 'SUM(total_price) as revenue'])
            ->where(['status' => 'completed'])
            ->with('service')
            ->groupBy('service_id')
            ->orderBy(['count' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        // Master workload
        $masterWorkload = Order::find()
            ->select(['master_id', 'COUNT(*) as count', 'SUM(total_price) as revenue'])
            ->where(['status' => 'completed'])
            ->with('master.user')
            ->groupBy('master_id')
            ->orderBy(['count' => SORT_DESC])
            ->limit(10)
            ->asArray()
            ->all();

        return $this->render('reports', [
            'ordersByStatus' => $ordersByStatus,
            'revenueData' => $revenueData,
            'popularServices' => $popularServices,
            'masterWorkload' => $masterWorkload,
        ]);
    }
}
