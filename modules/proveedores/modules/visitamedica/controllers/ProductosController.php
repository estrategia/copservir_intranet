<?php 
  namespace app\modules\proveedores\modules\visitamedica\controllers;

  use yii\web\Controller;
  use yii\httpclient\Client;
  // use yii\web\Session;
  use yii\web\NotFoundHttpException;
  use yii\filters\VerbFilter;
  use yii\helpers\Json;
  use yii\helpers\VarDumper;
  use app\modules\proveedores\modules\visitamedica\models\RegistroAccesoDetalleProducto;
  use app\modules\proveedores\models\UsuarioProveedor;
  /**
  * 
  */
  class ProductosController extends Controller
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
    							'buscar', 'producto',
    					],
    					'authsActions' => [
    							'buscar' => 'visitaMedica_productos_buscar',
    							'producto' => 'visitaMedica_productos_buscar',
    					],
    			],
    			[
    					'class' => \app\modules\proveedores\modules\visitamedica\components\AccessFilter::className(),
    					'only' => ['buscar', 'producto'],
    			],
    	];
    }

    public function actionBuscar()
    {
      $ciudad = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['ciudad']);
      if (!isset($ciudad)) {
        \Yii::$app->session->setFlash('error', "Por favor selecciona una ubicacion");
        return $this->redirect( \Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/ubicacion');
      }

      $idFabricante = -1;
      $objUsuarioProv = UsuarioProveedor::findOne(\Yii::$app->user->identity->numeroDocumento);
      
      if($objUsuarioProv!==null){
      	$idFabricante = $objUsuarioProv->idFabricante;
      }

      if (isset($_GET['term'])) {
        $client = new Client();
        $url = \Yii::$app->params['webServices']['lrv'] . '/producto/buscar/' . $_GET['term'] . '/' . $idFabricante;
        $response = $client->createRequest()
        ->setMethod('get')
        ->setUrl($url)
        ->setData([''])
        ->setOptions([
          'timeout' => 30, // set timeout to 5 seconds for the case server is not responding
        ])
        ->send();
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $productos = json_decode( preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $response->content), true );
        echo $this->render('busqueda', ['productos' => $productos]);
      } else {
        echo $this->render('busqueda');
      }
    }

    public function actionProducto()
    {

      $codigoProducto = 0; 
      if (isset($_GET['codigoProducto'])) {
        $codigoProducto = $_GET['codigoProducto'];
      }
      $client = new Client();
      $codigoCiudad = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['ciudad']);
      $nombreCiudad = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreCiudad']);
      $codigoSector = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['sector']);
      $nombreSector = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['nombreSector']);

      // $codigoCiudad = 76001;
      // $nombreCiudad = 'Medellin';
      // $codigoSector = 22;
      // $nombreSector = 'hOLA';
      $urlDetalleProducto = \Yii::$app->params['webServices']['lrv'] . '/producto/' . $codigoProducto . '/ciudad/' . 
      $codigoCiudad . '/sector/' . $codigoSector;

      // echo $urlDetalleProducto;
      $urlDetallePdv = \Yii::$app->params['webServices']['visitaMedica']['detallePDV'];
      // $urlDetallePdv = 'http://siidesarrollo.copservir.com:8080/WebSaldosVisitaMedica/webresources/service/saldos?refe=12722&codciu=11001&sector=17&sha1=95dabdca3b584651eccd1bdf3c9ad3c8606a1e7a';

      $detalleProducto = $client->createRequest()
      ->setMethod('get')
      ->setUrl($urlDetalleProducto)
      ->setData([''])
      ->setOptions([
        'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
      ])
      ->send();

      $detallePdv = $client->createRequest()
      ->setMethod('get')
      ->setUrl($urlDetallePdv)
      ->setData([''])
      ->setOptions([
        'timeout' => 5,
      ])
      ->send();

      $infoSector = JSON::decode($detallePdv->content);
      // VarDumper::dump($infoSector['response'], 10, true);
      // var_dump($infoSector);
      $producto = JSON::decode($detalleProducto->content);

      $registroAcceso = new RegistroAccesoDetalleProducto();
      $registroAcceso->codigoProducto = $codigoProducto;
      $registroAcceso->descripcionProducto = $producto['descripcionProducto'];
      $registroAcceso->presentacionProducto = $producto['presentacionProducto'];
      $registroAcceso->codigoCiudad = $codigoCiudad;
      $registroAcceso->nombreCiudad = $nombreCiudad;
      $registroAcceso->codigoSector = $codigoSector;
      $registroAcceso->nombreSector = $nombreSector;
      $registroAcceso->fechaConsulta = date('YmdHis');
      $registroAcceso->ip = $registroAcceso->getRealIp(); //Yii::$app->getRequest()->getUserIP() ;
      $registroAcceso->save();

      echo $this->render('producto', ['producto' => $producto, 'infoSector' => $infoSector['response']]);

    }
  }
?>