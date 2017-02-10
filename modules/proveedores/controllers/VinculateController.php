<?php

namespace app\modules\proveedores\controllers;
use Yii;
use yii\helpers\Html;


class VinculateController extends \yii\web\Controller 
{
/*	
	public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/proveedores/usuario/autenticar']
            ],

            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'index', 'productos_nuevos',
                ],
                'authsActions' => [
                    'index' => 'proveedores_usuario',
                ],
           ],
        
        ];
    }
*/	
	public function actionIndex()
	{	
		return $this->render('vinculate');	
	}
}