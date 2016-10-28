<?php

namespace app\modules\proveedores\modules\visitamedica\controllers;

use yii\web\Controller;
use yii\httpclient\Client;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
* 
*/
class UbicacionController extends Controller
{

  public $apiUrl = 'http://localhost/lrv/rest';

  public function behaviors()
  {
    return [
    		[
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/proveedores/visitamedica']
            ],
    		[
	    		'class' => \app\components\AuthItemFilter::className(),
	    		'only' => [
	    			'index',
	    		],
	    		'authsActions' => [
	    			'index' => 'visitaMedica_productos_buscar',
	    		],
    		],
    ];
  }

  public function actionIndex()
  {
    return $this->render('index');
  }
  
  public function actionMapa()
  {
    $client = new Client();
    $url = $this->apiUrl . '/ciudad';

    $response = $client->createRequest()
    ->setMethod('get')
    ->setUrl($url)
    ->setData([])
    ->setOptions([
        'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
    ])
    ->send();
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $ciudades = json_decode($response->content);
    echo $this->renderPartial('_ubicacionMapa', ['ciudades' => $ciudades]);
  }

  public function actionSeleccionar()
  {
    $client = new Client();
    // $url = $this->apiUrl . '/puntoventacercano/lat/'.$_POST['lat'].'/lon/'.$_POST['lon'];
    $url = $this->apiUrl . '/puntoventacercano/lat/4.57260484961044/lon/-59.91441403124998';

    $response = $client->createRequest()
    ->setMethod('get')
    ->setUrl($url)
    ->setData([])
    ->setOptions([
        'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
    ])
    ->send();
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $data = json_decode($response->content);
    $session = \Yii::$app->session;
    
    if ($data->result == 'ok') {
      $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['ciudad'], $data->response->codigoCiudad);
      $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['sector'], $data->response->codigoSector);
      $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad'], $data->response->nombreCiudad);
      $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreSector'], $data->response->nombreSector);
      
      // var_dump($data->response);
      // var_dump($session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['ciudad']));

      return json_encode(['result' => 'ok', 
                          'response' => [
                                         'nombreCiudad' => $data->response->nombreCiudad,
                                         'nombreSector' => $data->response->nombreSector,
                                         'codigoCiudad' => $data->response->codigoCiudad,
                                         'codigoSector' => $data->response->codigoSector,
                                        ]
      ]);
    } else {
      return $response->content;
    }
  }

  public function actionConfirmar()
  {
    $session = \Yii::$app->session;

    $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['ciudad'], $_POST['codigoCiudad']);
    $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['sector'], $_POST['codigoSector']);
    $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad'], $_POST['nombreCiudad']);
    $session->set(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreSector'], $_POST['nombreSector']);
    return $this->redirect( \Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/productos/buscar');
  }

  public function actionGetSectores()
  {
    $client = new Client();
    $url = $this->apiUrl . '/ciudad/'.$_POST['codigoCiudad'].'/sectores/';
    // $url = $this->apiUrl . '/puntoventacercano/lat/3.4659033727724675/lon/-76.52805958483886';

    $response = $client->createRequest()
    ->setMethod('get')
    ->setUrl($url)
    ->setData([])
    ->setOptions([
        'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
    ])
    ->send();
    return json_encode(['response' => $response->data]);
  }
}

?>