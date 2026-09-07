<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    public $layout = 'main';

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        
        if ($exception !== null) {
            $statusCode = $exception->statusCode ?? 500;
            Yii::$app->response->statusCode = $statusCode;
        }
        
        return $this->render('error', [
            'exception' => $exception,
        ]);
    }
}