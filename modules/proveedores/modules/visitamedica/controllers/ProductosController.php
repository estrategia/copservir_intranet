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
  /**
  * 
  */
  class ProductosController extends Controller
  {

    public function behaviors()
    {
      return [
              [
                'class' => \app\modules\proveedores\modules\visitamedica\components\AccessFilter::className(),
                'only' => ['buscar', 'producto'],
              ],
              'verbs' => [
                  'class' => VerbFilter::className(),
                  'actions' => [
                      'delete' => ['POST'],
                  ],

              ],
              [
                  'class' => \app\components\AccessFilter::className(),
                  'only' => [
                      'buscar', 'producto'
                  ],
                  'redirectUri' => ['/intranet/usuario/autenticar']
              ],
          ];
    }

    public function actionBuscar()
    {

      if (isset($_GET['term'])) {
        $client = new Client();
        $url = \Yii::$app->params['webServices']['lrv'] . '/producto/buscar/' . $_GET['term'];
        $response = $client->createRequest()
        ->setMethod('get')
        ->setUrl($url)
        ->setData([''])
        ->setOptions([
          'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
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
      $urlDetallePdv = \Yii::$app->params['webServices']['lrv'] . '/producto/simular';

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