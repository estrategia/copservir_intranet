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


        // $this->modules = [
        //     'visitaMedica' => [
        //         // you should consider using a shorter namespace here!
        //         'class' => 'app\modules\proveedores\modules\visitamedica\visitaMedica',
        //     ],
        // ];
    }

}