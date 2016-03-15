<?php

namespace app\modules\intranet\controllers;

use yii\web\Controller;

class DefaultController extends Controller
{
    public function actionIndex()
    {
        echo \Yii::$app->params['grupo']['*'];
        //return $this->render('index');
    }

}
