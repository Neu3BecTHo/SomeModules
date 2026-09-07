<?php

namespace app\modules\breadHouse\controllers;

use app\modules\breadHouse\assets\BreadHouseMainAsset;
use app\modules\breadHouse\models\Categories;
use app\modules\breadHouse\models\Product;
use yii\web\Controller;

/**
 * Default controller for the `communal` module
 */
class MainController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            BreadHouseMainAsset::register($this->view);
            return true;
        }
        return false;
    }

    public function actionIndex()
    {
        // Категории товаров
        $categories = Categories::find()->orderBy(['id' => SORT_ASC])->all();

        // Популярные товары (например, с высоким рейтингом)
        $featuredProducts = Product::find()
            ->where(['>', 'rating', 4.0])
            ->andWhere(['>', 'stock', 0])
            ->orderBy(['rating' => SORT_DESC])
            ->limit(6)
            ->all();

        // Новые товары
        $newProducts = Product::find()
            ->where(['>', 'stock', 0])
            ->orderBy(['created_at' => SORT_DESC])
            ->limit(6)
            ->all();

        $benefits = [
            [
                'title' => 'Свежие ингредиенты',
                'text'  => 'Используем только свежие и качественные ингредиенты для наших изделий.',
            ],
            [
                'title' => 'Быстрая доставка',
                'text'  => 'Доставляем заказы в кратчайшие сроки по городу.',
            ],
            [
                'title' => 'Онлайн-заказ',
                'text'  => 'Удобное оформление заказов через сайт с возможностью самовывоза.',
            ],
        ];

        $contacts = [
            'phone'    => '8(999)999-99-99',
            'address'  => 'г. Курган, ул. Пекарная, д. 15',
            'email'    => 'info@breadhouse.local',
            'worktime' => 'ежедневно с 8:00 до 21:00',
        ];

        return $this->render('index', [
            'categories'      => $categories,
            'featuredProducts' => $featuredProducts,
            'newProducts'     => $newProducts,
            'benefits'        => $benefits,
            'contacts'        => $contacts,
        ]);
    }
}
