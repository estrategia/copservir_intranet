<?php

namespace app\modules\proveedores\modules\visitamedica;

/**
 * visitamedica module definition class
 */
class VisitaMedicaModule extends \yii\base\Module {
	public $controllerNamespace = 'app\modules\proveedores\modules\visitamedica\controllers';
	public $defaultRoute = 'productos/buscar';
	public $layout = 'main';
	
	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init ();
		\Yii::$app->errorHandler->errorAction = 'proveedores/visitamedica/sitio/error';
	}
}
