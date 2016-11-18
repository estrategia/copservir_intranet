<?php

namespace app\modules\proveedores\modules\visitamedica\controllers;

use yii\web\Controller;

/**
 */
class SitioController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    public function actionTest(){
        \yii\helpers\VarDumper::dump(\Yii::$app->controller->module->module->module->module,10,true);
    }

}

?>