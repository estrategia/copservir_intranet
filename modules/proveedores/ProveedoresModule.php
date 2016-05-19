<?php

namespace app\modules\proveedores;
use Yii;

class ProveedoresModule extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\proveedores\controllers';
    public $defaultRoute = 'sitio';
    public $layout = 'main';

    public function init() {
        parent::init();

        Yii::$app->errorHandler->errorAction = 'proveedores/sitio/error';


        // custom initialization code goes here
    }

}