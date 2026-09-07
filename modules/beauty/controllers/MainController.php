<?php

namespace app\modules\beauty\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\beauty\models\Service;
use app\modules\beauty\models\Category;
use app\modules\beauty\models\Master;
use app\modules\beauty\models\Order;
use app\modules\beauty\models\BookingForm;

/**
 * Main controller
 */
class MainController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $categories = Category::find()
            ->where(['is_active' => true])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        $services = Service::find()
            ->where(['is_active' => true])
            ->limit(6)
            ->all();

        $masters = Master::find()
            ->where(['is_approved' => true])
            ->with('user')
            ->limit(4)
            ->all();

        return $this->render('index', [
            'categories' => $categories,
            'services' => $services,
            'masters' => $masters,
        ]);
    }

    /**
     * Displays catalog page.
     *
     * @return string
     */
    public function actionCatalog()
    {
        $query = Service::find()
            ->where(['is_active' => true])
            ->with(['category', 'masters.user']);

        // Apply filters
        $categoryId = Yii::$app->request->get('category');
        $masterId = Yii::$app->request->get('master');
        $minPrice = Yii::$app->request->get('min_price');
        $maxPrice = Yii::$app->request->get('max_price');

        if ($categoryId) {
            $query->andWhere(['category_id' => $categoryId]);
        }

        if ($masterId) {
            $query->joinWith('masters')
                ->andWhere(['{{%masters}}.id' => $masterId]);
        }

        if ($minPrice) {
            $query->andWhere(['>=', 'price', $minPrice]);
        }

        if ($maxPrice) {
            $query->andWhere(['<=', 'price', $maxPrice]);
        }

        // Apply sorting
        $sort = Yii::$app->request->get('sort', 'name');
        $order = Yii::$app->request->get('order', 'asc');
        
        switch ($sort) {
            case 'price':
                $query->orderBy(['price' => $order === 'desc' ? SORT_DESC : SORT_ASC]);
                break;
            case 'rating':
                $query->orderBy(['rating' => $order === 'desc' ? SORT_DESC : SORT_ASC]);
                break;
            default:
                $query->orderBy(['name' => $order === 'desc' ? SORT_DESC : SORT_ASC]);
        }

        $services = $query->all();
        $categories = Category::find()->where(['is_active' => true])->all();
        $masters = Master::find()->where(['is_approved' => true])->with('user')->all();

        return $this->render('catalog', [
            'services' => $services,
            'categories' => $categories,
            'masters' => $masters,
        ]);
    }

    /**
     * Displays service page.
     *
     * @param int $id
     * @return string
     */
    public function actionService($id)
    {
        $service = Service::find()
            ->where(['id' => $id, 'is_active' => true])
            ->with(['category', 'masters.user'])
            ->one();

        if (!$service) {
            throw new NotFoundHttpException('Услуга не найдена.');
        }

        return $this->render('service', [
            'service' => $service,
        ]);
    }

    /**
     * Displays master page.
     *
     * @param int $id
     * @return string
     */
    public function actionMaster($id)
    {
        $master = Master::find()
            ->where(['id' => $id])
            ->with(['user', 'services.category', 'photos', 'schedule'])
            ->one();

        if (!$master) {
            throw new NotFoundHttpException('Мастер не найден.');
        }

        return $this->render('master', [
            'master' => $master,
        ]);
    }

    /**
     * Booking page.
     *
     * @param int $service_id
     * @return string|\yii\web\Response
     */
    public function actionBook($service_id = null)
    {
        if (Yii::$app->userBeauty->isGuest) {
            return $this->redirect(['/beauty/auth/login']);
        }

        if (!$service_id) {
            Yii::$app->session->setFlash('error', 'Пожалуйста, выберите услугу для записи.');
            return $this->redirect(['/beauty/catalog']);
        }

        $service = Service::findOne($service_id);
        if (!$service) {
            throw new NotFoundHttpException('Услуга не найдена.');
        }

        $model = new BookingForm();
        $model->service_id = $service_id;

        if ($model->load(Yii::$app->request->post())) {
            $order = $model->createOrder();
            if ($order) {
                Yii::$app->session->setFlash('success', 'Заявка успешно создана! Мастер свяжется с вами для подтверждения.');
                return $this->redirect(['/beauty/orders/index']);
            }
            // Если заказ не создан, показываем ошибки через flash
            if ($model->hasErrors()) {
                $errors = $model->getFirstErrors();
                Yii::$app->session->setFlash('error', implode('<br>', $errors));
            }
        }

        $masters = $service->masters;

        return $this->render('book', [
            'model' => $model,
            'service' => $service,
            'masters' => $masters,
        ]);
    }

    /**
     * About page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Contacts page.
     *
     * @return string
     */
    public function actionContacts()
    {
        return $this->render('contacts');
    }
}
