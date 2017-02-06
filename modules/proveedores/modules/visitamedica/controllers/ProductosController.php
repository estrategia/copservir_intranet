<?php 
  namespace app\modules\proveedores\modules\visitamedica\controllers;

  use Yii;
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
          [
              'class' => \app\components\TerminosFilter::className(),
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

      if (isset($_GET['term']) && ($_GET['term'] != '')) {
        $client = new Client();
        $url = \Yii::$app->params['webServices']['lrv'] . '/producto/buscar/' . $_GET['term'] . '/' . $idFabricante;
        $url = str_replace(' ', '%20', $url);
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
        if (array_key_exists('term', $_GET))
          Yii::$app->session->setFlash('error', 'Ingresa un producto a buscar');
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
      // $codigoProducto = 12722;
      $urlDetalleProducto = \Yii::$app->params['webServices']['lrv'] . '/producto/' . $codigoProducto . '/ciudad/' . 
      $codigoCiudad . '/sector/' . $codigoSector;

      // $urlDetallePdv = \Yii::$app->params['webServices']['visitaMedica']['detallePDV'];
      $urlDetallePdv = \Yii::$app->params['webServices']['visitaMedica']['detallePDV'] . "?refe={$codigoProducto}&codciu={$codigoCiudad}&sector={$codigoSector}&sha1=95dabdca3b584651eccd1bdf3c9ad3c8606a1e7a";
      // $urlDetallePdv = 'http://siidesarrollo.copservir.com:8080/WebSaldosVisitaMedica/webresources/service/saldos?refe=38045&codciu=76001&sector=26&sha1=95dabdca3b584651eccd1bdf3c9ad3c8606a1e7a';

      $detalleProducto = $client->createRequest()
      ->setMethod('get')
      // ->setUrl('http://192.168.1.24/lrv/rest/producto/10002/ciudad/76001/sector/17')
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
      // $producto = null;
      $producto = JSON::decode($detalleProducto->content);

      $registroAcceso = new RegistroAccesoDetalleProducto();
      $registroAcceso->codigoProducto = $producto['codigoProducto'];
      $registroAcceso->descripcionProducto = $producto['descripcionProducto'];
      $registroAcceso->presentacionProducto = $producto['presentacionProducto'];
      $registroAcceso->codigoCiudad = $codigoCiudad;
      $registroAcceso->nombreCiudad = $nombreCiudad;
      $registroAcceso->codigoSector = $codigoSector;
      $registroAcceso->nombreSector = $nombreSector;
      $registroAcceso->codigoProveedor = $producto['codigoProveedor'];
      $registroAcceso->nitLaboratorio = $this->searchNit($producto['codigoProveedor']);
      $registroAcceso->fechaConsulta = date('YmdHis');
      $registroAcceso->ip = $registroAcceso->getRealIp(); //Yii::$app->getRequest()->getUserIP() ;
      $registroAcceso->save();
      // \yii\helpers\VarDumper::dump($infoSector, 10, true); exit();
      echo $this->render('producto', ['producto' => $producto, 'infoSector' => $infoSector[0]['response'], 'result' => $infoSector[0]['result']]);

    }

    protected function getTerceros() {

        ini_set("soap.wsdl_cache_enabled", 0);

        // $condiciones = array();
        //$condiciones['idSede']['valor'] = 2;
        //$condiciones['centroCosto']['valor'] = "003";
        //$condiciones['puntosVenta']['valor'] = "124";
        //$condiciones['puntosVenta']['condicional'] = 'OR';
        //$condiciones['nombreZona']['valor'] = 'cali';
        //$condiciones['nombreZona']['like'] = true;

        $client = new \SoapClient(Yii::$app->params['webServices']['productos']['terceros']);
        $arr = $client->getTerceros();

        if ($arr === null) {
            echo "NULL ERROR";
        } else {
            return $arr;
        }
    }

    protected function searchNit($idFabricante) {
      $terceros = $this->getTerceros();
      foreach ($terceros as $key => $value) {
        if ($value['IdFabricante'] == $idFabricante) {
          return $value['NumeroDocumento'];
        }
      }
    }

  }
?>