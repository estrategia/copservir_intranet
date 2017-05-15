<?php

namespace app\modules\proveedores\controllers;
use Yii;
use yii\helpers\Html;


class CitasMercanciaController extends \yii\web\Controller 
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
                    'index' => 'proveedores_citas-mercancia',
                ],
           ],

           [
                'class' => \app\components\TerminosFilter::className(),

           ],			   
        
        ];
    }

	public function actionIndex()
	{	
		return $this->render('citas-mercancia');	
	}
}