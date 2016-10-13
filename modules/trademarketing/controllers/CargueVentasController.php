<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use app\modules\trademarketing\models\CargueVentasForm;
use yii\helpers\VarDumper;
use yii\web\HttpException;


class CargueVentasController extends Controller
{
    /*public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],

            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                   'index'
                 ],
                 'authsActions' => [
                     //colocar los permisos
                      'index' => 'tradeMarketing_asignaciones_supervisor',
                 ]
             ],
        ];
    }*/

	public function actionIndex(){
    	$model = new CargueVentasForm;
    	
    	if ($model->load(Yii::$app->request->post())) {
    		ini_set('memory_limit', -1);
    		try{
    			$model->guardarArchivo();
    			$model->procesarArchivo();
    			$registros = $model->cargarArchivo();
    			Yii::$app->session->setFlash('success', "Se cargaron $registros registros");
    		}catch (\Exception $exc){
    			Yii::$app->session->setFlash('error', "[".$exc->getCode()."] " . $exc->getMessage());
    		}
    	}
    	
    	return $this->render('index', ['model' => $model]);
    }
    
}
