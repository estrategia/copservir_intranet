<?php

namespace app\modules\proveedores\controllers;
use Yii;
use yii\helpers\Html;


class RetencionController extends \yii\web\Controller 
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
                    'index'
                ],
                'authsActions' => [
                    //'index' => 'proveedores_admin',
					'index' => 'proveedores_certificados-tributarios'
                ],
           ],
        
        ];
    }
*/	
	public function actionIndex()
	{	
		$model = new \app\modules\proveedores\models\Retencion();
		$nit = "";
		$nitPost = "";
		
		if($model->load(Yii::$app->request->post()) && $model->validate())
		{
			$nit = Yii::$app->request->post('Retencion');
			$nitPost = $nit['nit'];
		}
		
		return $this->render("retencion", ["model" => $model, "nitPost" => $nitPost]);	
	}
}