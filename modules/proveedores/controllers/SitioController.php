<?php

namespace app\modules\proveedores\controllers;

use Yii;
use yii\web\Controller;

class SitioController extends Controller
{
    public function actionIndex()
    {
        //echo "proveedores";
        return $this->render('index');
    }

}

?>
