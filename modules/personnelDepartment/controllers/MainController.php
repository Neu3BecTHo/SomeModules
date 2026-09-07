<?php

namespace app\modules\personnelDepartment\controllers;

use app\modules\personnelDepartment\assets\PersonnelMainAsset;
use yii\web\Controller;

/**
 * Default controller for the `communal` module
 */
class MainController extends Controller
{
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            PersonnelMainAsset::register($this->view);
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
