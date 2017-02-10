<?php

namespace app\modules\proveedores\controllers;
use Yii;
//use yii\web\UploadedFile;
//use app\modules\intranet\models\ProyectosSearch;
use yii\helpers\Html;

/*
echo '<pre>';
print_r(Yii::$app->user->identity->objUsuarioProveedor);
echo  '</pre>';
*/
class MisproductosController extends \yii\web\Controller 
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
                    'index', //'productos-nuevos',
                ],
                'authsActions' => [
                    //'index' => 'proveedores_admin',
					'index' => 'proveedores_mis-productos',
					//'productos-nuevos' => 'proveedores_usuario',
					//'productos-nuevos' => 'proveedores_admin',
                ],
           ],

           [
                'class' => \app\components\TerminosFilter::className(),

           ],		   
        
        ];
    }
	
	public function actionIndex()
	{	
		ini_set('default_socket_timeout', 5);//se configura tiempo maximo de respuesta
		$client = new \SoapClient(null, array(
			'location' => Yii::$app->params['webServices']['misproductos'],
			'uri' => "",
			'trace' => 1,
			'connection_timeout' => 5,
		));
		try {
		$result = $client->__soapCall("ConsultarMisProductos", array('codigoProveedor' => Yii::$app->user->identity->objUsuarioProveedor->idFabricante));
			return $this->render("productos", ["result" => $result]);
		} catch (\SoapFault $exc) {
			//aqui se coloca el codigo correspondiente si se quiere capturar excepcion de falla del webservice
		} catch (Exception $exc) {
			 //aqui se coloca el codigo correspondiente si se quiere capturar excepcion de falla de cualquier otro tipo (conexion, .. )
		}	
	}

	public function actionProductosNuevos()
	{	
		ini_set('default_socket_timeout', 5);//se configura tiempo maximo de respuesta
		$client = new \SoapClient(null, array(
			'location' => Yii::$app->params['webServices']['misproductos'],
			'uri' => "",
			'trace' => 1,
			'connection_timeout' => 5,
		));
		try {
		$result = $client->__soapCall("ConsultarProductosNuevos", array());
			return $this->render("productos-nuevos", ["result" => $result]);
		} catch (\SoapFault $exc) {
			//aqui se coloca el codigo correspondiente si se quiere capturar excepcion de falla del webservice
		} catch (Exception $exc) {
			 //aqui se coloca el codigo correspondiente si se quiere capturar excepcion de falla de cualquier otro tipo (conexion, .. )
		}	
	}	
}