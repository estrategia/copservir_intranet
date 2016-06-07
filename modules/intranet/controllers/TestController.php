<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use app\modules\intranet\models\Contenido;
use yii\helpers\Html;
use yii\web\Response;

class TestController extends Controller {
    public function actionDatatable(){
        echo "";
        return $this->render("datatable");
    }
  
}
