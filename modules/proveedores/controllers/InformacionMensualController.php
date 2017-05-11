<?php

namespace app\modules\proveedores\controllers;
use Yii;
use yii\helpers\Html;


class InformacionMensualController extends \yii\web\Controller 
{
	
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
                    'index',
                ],
                'authsActions' => [
                    'index' => 'proveedores_informe-ventas',
                ],
           ],
		   
           [
                'class' => \app\components\TerminosFilter::className(),

           ],			   
        
        ];
    }

	public function actionIndex()
	{	
		return $this->render('informacion-mensual');	
	}
}