<?php

namespace app\modules\proveedores\modules\visitamedica\controllers;

use yii\web\Controller;

/**
 */
class SitioController extends Controller {
	public function behaviors()
	{
		return [
			[
				'class' => \app\components\TerminosFilter::className(),
			],
		];
	}
	
	public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
}
?>