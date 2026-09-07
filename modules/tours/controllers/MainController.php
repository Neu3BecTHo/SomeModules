<?php

namespace app\modules\tours\controllers;

use app\modules\tours\assets\ToursMainAsset;
use app\modules\tours\models\Reviews;
use app\modules\tours\models\Tours;
use yii\web\Controller;

/**
 * Default controller for the `communal` module
 */
class MainController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            ToursMainAsset::register($this->view);
            return true;
        }
        return false;
    }
    
    public function actionIndex()
    {
        // несколько активных туров для карточек
        $tours = Tours::find()
            ->where(['is_active' => true])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(6)
            ->all();

        // последние отзывы с подгруженными турами и пользователями
        $reviews = Reviews::find()
            ->with(['tour', 'user'])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(6)
            ->all();

        return $this->render('index', [
            'tours' => $tours,
            'reviews' => $reviews,
        ]);
    }

    public function actionContacts()
    {
        return $this->render('contacts');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }
}
