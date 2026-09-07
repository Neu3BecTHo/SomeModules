<?php

namespace app\modules\photoshoot\controllers;

use app\modules\photoshoot\models\Booking;
use app\modules\photoshoot\models\Gallery;
use app\modules\photoshoot\models\News;
use app\modules\photoshoot\models\Review;
use app\modules\photoshoot\models\Service;
use yii\web\Controller;
use Yii;

class MainController extends Controller
{
    public function actionIndex()
    {
        $services = Service::find()
            ->where(['is_active' => 1])
            ->orderBy(['sort_order' => SORT_ASC])
            ->limit(6)
            ->all();

        $gallery = Gallery::find()
            ->where(['is_active' => 1])
            ->orderBy(['sort_order' => SORT_ASC])
            ->limit(8)
            ->all();

        $news = News::find()
            ->where(['is_active' => 1, 'type' => News::TYPE_PROMO])
            ->andWhere(['<=', 'date_start', date('Y-m-d')])
            ->andWhere(['or', ['>=', 'date_end', date('Y-m-d')], ['date_end' => null]])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(3)
            ->all();

        $reviews = Review::find()
            ->where(['is_published' => 1])
            ->with('user')
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(6)
            ->all();

        return $this->render('index', [
            'services' => $services,
            'gallery' => $gallery,
            'news' => $news,
            'reviews' => $reviews,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionServices()
    {
        $services = Service::find()
            ->where(['is_active' => 1])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        return $this->render('services', [
            'services' => $services,
        ]);
    }

    public function actionGallery()
    {
        $query = Gallery::find()->where(['is_active' => 1]);

        $category = Yii::$app->request->get('category');
        if ($category) {
            $query->andWhere(['category' => $category]);
        }

        $gallery = $query->orderBy(['sort_order' => SORT_ASC])->all();

        return $this->render('gallery', [
            'gallery' => $gallery,
            'currentCategory' => $category,
        ]);
    }

    public function actionNews()
    {
        $news = News::find()
            ->where(['is_active' => 1])
            ->orderBy(['created_at' => SORT_DESC])
            ->all();

        return $this->render('news', [
            'news' => $news,
        ]);
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }
}
