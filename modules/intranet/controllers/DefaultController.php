<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\Notificaciones;
use yii\web\Controller;
use yii\web\Session;
use app\modules\intranet\models\EventosCalendario;

class DefaultController extends Controller {

  public function actionIndex() {
    echo date('Y-m-d H:i:s');
    echo "<br>";
    $objNotificacion = Notificaciones::find()->orderBy('fechaRegistro DESC')->one();
    \yii\helpers\VarDumper::dump($objNotificacion, 10, true);
    echo "<br>";

    echo date('Y-m-d H:i:s');
    echo "<br>";
    $objNotificacion = Notificaciones::find()
    ->where("numeroDocumentoDirigido=:usuario", [':usuario' => Yii::$app->user->identity->numeroDocumento])
    ->orderBy('fechaRegistro DESC')->one();
    \yii\helpers\VarDumper::dump($objNotificacion, 10, true);
    echo "<br>";
  }

  public function actionSession() {
    //var_dump(\Yii::$app->user->identity);
    //return $this->render('index');
    //$session = new Session;
    //$session->open();
    $session = \Yii::$app->session;

    //$value1 = $session['name1'];  // get session variable 'name1'
    //$value2 = $session['name2'];  // get session variable 'name2'
    //foreach ($session as $name => $value) // traverse all session variables
    var_dump($session['prueba']);
  }

  public function actionEventos() {
    //$models = EventosCalendario::consultarEventos();
    $inicio = '2016-03-01';
    $fin = '2016-03-31';


    $listEventos = EventosCalendario::consultarEventos($inicio, $fin, 'intranet', [], false);

    \yii\helpers\VarDumper::dump($listEventos, 5, true);
  }

  public function actionFecha() {
    echo date('Y-m-d H:i:s');
  }

  public function actionNotif() {
    $listNotificaciones = \app\modules\intranet\models\Notificaciones::cantidadNoVistas(\Yii::$app->user->identity->numeroDocumento);

    \yii\helpers\VarDumper::dump($listNotificaciones, 10, true);
  }

  public function actionPrueba()
  {


        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {
            //$result_forma1 = $client->getPersona(8724911, true, null);
            $result_forma3 = $client->getPersonaWithModel(8724911, true, null);
            //$result_forma2 = $client->__soapCall("getCredito", <parametros>); 14888822

            //$funcs = $client->__getFunctions();
            //\yii\helpers\VarDumper::dump($funcs, 10, true);
            \yii\helpers\VarDumper::dump($result_forma3);
            echo "<br>";echo "<br>";echo "<br>";
            \yii\helpers\VarDumper::dump(\Yii::$app->user->identity->getCargoCodigo());
            echo "<br>";echo "<br>";echo "<br>";
            \yii\helpers\VarDumper::dump(\Yii::$app->user->identity->getGruposCodigos() );
            echo "<br>";echo "<br>";echo "<br>";
            \yii\helpers\VarDumper::dump(\Yii::$app->user->identity->getCiudadCodigo() );

            //$reqHello = $client->__getLastRequest();

        } catch (SoapFault $exc) {

        } catch (Exception $exc) {

        }

  }

  public function actionPruebaAniversarios()
  {


        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {
            //$result_forma1 = $client->getPersona(8724911, true, null);
            $result = $client->getAniversarios(date("m"), date("d"));
            //$result_forma2 = $client->__soapCall("getCredito", <parametros>); 14888822

            //$funcs = $client->__getFunctions();
            //\yii\helpers\VarDumper::dump($funcs, 10, true);
            \yii\helpers\VarDumper::dump($result);
            //$reqHello = $client->__getLastRequest();

        } catch (SoapFault $exc) {

        } catch (Exception $exc) {

        }

  }

  public function actionPruebaCumpleanos()
  {


        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {
            //$result_forma1 = $client->getPersona(8724911, true, null);
            $result = $client->getCumpleanos(date("m"), date("d"));
            //$result_forma2 = $client->__soapCall("getCredito", <parametros>); 14888822

            //$funcs = $client->__getFunctions();
            //\yii\helpers\VarDumper::dump($funcs, 10, true);
            \yii\helpers\VarDumper::dump($result);
            //$reqHello = $client->__getLastRequest();

        } catch (SoapFault $exc) {

        } catch (Exception $exc) {

        }

  }

}
