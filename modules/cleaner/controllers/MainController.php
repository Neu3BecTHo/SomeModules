<?php

namespace app\modules\cleaner\controllers;

use app\modules\cleaner\assets\CleanerMainAsset;
use app\modules\cleaner\models\Categories;
use yii\web\Controller;

/**
 * Default controller for the `communal` module
 */
class MainController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            CleanerMainAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        // Берём все категории из БД
        $categories = Categories::find()->orderBy(['id' => SORT_ASC])->all();

        // Можно мапнуть к структуре "услуг"
        $services = [];
        foreach ($categories as $category) {
            $services[] = [
                'title' => $category->title,
                // пока захардкоженные цены, потом можно добавить в таблицу поле price
                'price' => 'от 500 ₽',
                'note'  => 'Описание услуги для категории: ' . $category->title,
            ];
        }

        $benefits = [
            [
                'title' => 'Бережные технологии',
                'text'  => 'Подбираем средства под конкретный материал, чтобы сохранить цвет и форму.',
            ],
            [
                'title' => 'Забор и доставка',
                'text'  => 'Курьер заберёт и привезёт ваши вещи в удобное время.',
            ],
            [
                'title' => 'Онлайн‑заявка',
                'text'  => 'Оформление заявок и отслеживание статуса прямо на сайте.',
            ],
        ];

        $contacts = [
            'phone'    => '8(999)999-99-99',
            'address'  => 'г. Курган, ул. Примерная, д. 10',
            'email'    => 'info@himchistka.local',
            'worktime' => 'ежедневно с 9:00 до 20:00',
        ];

        return $this->render('index', [
            'services'  => $services,
            'benefits'  => $benefits,
            'contacts'  => $contacts,
            'categories'=> $categories,
        ]);
    }
}
