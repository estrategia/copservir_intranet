<?php

namespace app\modules\proveedores;

class ProveedoresModule extends \yii\base\Module
{
		public $controllerNamespace = 'app\modules\proveedores\controllers';
		//public $defaultRoute = 'sitio';
		public $layout = 'main';

    public function init()
    {
        parent::init();

        // ...  otro código de inicialización ...
				//Yii::$app->errorHandler->errorAction = 'proveedores/sitio/error';
    }

}

?>
