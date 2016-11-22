<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use app\modules\trademarketing\models\CargueVentasForm;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use app\modules\trademarketing\models\InformacionVentasActual;
use app\modules\trademarketing\models\InformacionVentasAnterior;
use app\models\SIICOP;


class CargueVentasController extends Controller
{
    public function behaviors()
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
                      'index' => 'tradeMarketing_cargue-ventas_index',
                 ]
             ],
        ];
    }

	public function actionIndex(){
    	$model = new CargueVentasForm;
    	$objFecha = new \DateTime;
    	
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
    
    public function actionVentasActual(){
    	$objFecha = new \DateTime;
    	echo "<br>Fecha: " . $objFecha->format('Y-m-d H:i:s') . "<br><br>";
    	$listVentas = InformacionVentasActual::find()->all();
    	foreach($listVentas as $objVentas){
    		VarDumper::dump($objVentas->attributes, 10, true);
    		echo "<br><br>";
    	}
    	
    }
    
    public function actionVentasAnterior(){
    	$objFecha = new \DateTime;
    	echo "<br>Fecha: " . $objFecha->format('Y-m-d H:i:s') . "<br><br>";
    	$listVentas = InformacionVentasAnterior::find()->all();
    	foreach($listVentas as $objVentas){
    		VarDumper::dump($objVentas->attributes, 10, true);
    		echo "<br><br>";
    	}
    	 
    }
    
    public function actionPoblarAnterior(){
    	$sql = "INSERT INTO t_TRMA_InformacionVentasAnterior (idInformacionVentasAnterior, idComercial, idAgrupacion, mes, valor, unidades)
			SELECT idInformacionVentasActual, idComercial, idAgrupacion, mes, valor-10000000, unidades-500 FROM  t_TRMA_InformacionVentasActual
			WHERE NOT EXISTS (
			    SELECT idInformacionVentasAnterior FROM t_TRMA_InformacionVentasAnterior
			)";
    	\Yii::$app->db->createCommand($sql)->execute();
    }
    
    public function actionTestproc(){
    	$sql1 = "SELECT SPECIFIC_NAME, ROUTINE_DEFINITION FROM INFORMATION_SCHEMA.ROUTINES WHERE ROUTINE_TYPE = 'PROCEDURE' AND ROUTINE_NAME like  '%trademarketing%' ";
    	$result1 = \Yii::$app->db->createCommand($sql1)->queryAll();
    	
    	
    	$sql2 = "SELECT trigger_schema, trigger_name, action_statement from information_schema.triggers where trigger_name LIKE '%trademarketing%'";
    	$result2 = \Yii::$app->db->createCommand($sql2)->queryAll();
    	
    	echo "PROCEDIMIENTOS: <br>";
    	VarDumper::dump($result1,10,true);
    	echo "<br><br>";
    	
    	
    	echo "TRIGGERS: <br>";
    	VarDumper::dump($result2,10,true);
    	echo "<br>";
    	
    	
    	
    }
    
    
}
