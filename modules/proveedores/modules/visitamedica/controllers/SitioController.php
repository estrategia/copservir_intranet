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
}
?>