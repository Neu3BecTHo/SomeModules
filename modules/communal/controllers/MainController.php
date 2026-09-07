<?php

namespace app\modules\communal\controllers;

use app\modules\communal\assets\CommunalMainAsset;
use yii\web\Controller;

/**
 * Default controller for the `communal` module
 */
class MainController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            CommunalMainAsset::register($this->view);
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
        return $this->render('index');
    }
}
