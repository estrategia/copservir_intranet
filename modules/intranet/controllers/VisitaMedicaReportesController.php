<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use app\modules\proveedores\modules\visitamedica\models\Reportes;

/**
* 
*/
class VisitaMedicaReportesController extends Controller
{

  public function behaviors()
  {
    return [
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/intranet/sitio/index']
            ],
            [
                'class' => \app\components\AuthItemFilter::className(),
                'except' => [
                    'seleccionar-laboratorio'
                ],
                'authsActions' => [
                    // 'index' => 'visitaMedica_reportes_index',
                    // 'acceso' => 'visitaMedica_reportes_acceso',
                    // 'producto' => 'visitaMedica_reportes_producto',
                    'index' => 'intranet_visita-medica-reportes_index',
                    'acceso' => 'intranet_visita-medica-reportes_acceso',
                    'producto' => 'intranet_visita-medica-reportes_producto',
                ],
           ],
        ];
  }

  public function actionIndex()
  {
    $terceros = $this->getTerceros();
    $tercerosSelect = ArrayHelper::map($terceros, 'NumeroDocumento', 'RazonSocial');
    return $this->render('reportes', ['tercerosSelect' => $tercerosSelect]);
  }

  public function actionProducto()
  {
    $modelo = new Reportes();
    if (!isset($ciudad)) {
        \Yii::$app->session->setFlash('error', "Por favor selecciona un proveedor para visualizar los reportes");
        return $this->redirect( \Yii::$app->getUrlManager()->getBaseUrl() . '/intranet/visitamedica/reportes');
      }
    if (isset($_GET['tiempo'])) {
      $tiempo = $_GET['tiempo'];
      
      $nitLaboratorio = Yii::$app->session[Yii::$app->params['visitamedica']['session']['nitLaboratorio']];
      
      $datosGrafica = [];
      $registros = $modelo->getRegistrosConsultaProductos($tiempo, $nitLaboratorio);

      if ($tiempo == 'hoy' || $tiempo == 'ayer') {
        $datosGrafica = $modelo->productosDia($registros);
      }

      if ($tiempo == 'semana' || $tiempo == 'semana-anterior') {
        $datosGrafica = $modelo->productosSemana($registros);
      }

      if ($tiempo == 'mes' || $tiempo == 'mes-anterior') {
        $datosGrafica = $modelo->productosMes($registros);
      }

      return $this->render('_reporteProducto', ['registros' => $registros, 'datosGrafica' => $datosGrafica, 'tiempo' => $tiempo]);
    }
  }

  public function actionAcceso()
  { 
    $modelo = new Reportes();
    if (!isset($ciudad)) {
        \Yii::$app->session->setFlash('error', "Por favor selecciona un proveedor para visualizar los reportes");
        return $this->redirect( \Yii::$app->getUrlManager()->getBaseUrl() . '/intranet/visitamedica/reportes');
      }
    $nitLaboratorio = Yii::$app->session[Yii::$app->params['visitamedica']['session']['nitLaboratorio']];

    if (isset($_GET['tiempo'])) {
      $tiempo = $_GET['tiempo'];
      
      $datosGrafica = [];
      $registros = $modelo->getRegistrosAcceso($tiempo, $nitLaboratorio);

      if ($tiempo == 'hoy' || $tiempo == 'ayer') {
        $datosGrafica = $modelo->accesosDia($registros);
      }
      if ($tiempo == 'semana' || $tiempo == 'semana-anterior') {
        $datosGrafica = $modelo->accesosSemana($registros);
      }
      if ($tiempo == 'mes' || $tiempo == 'mes-anterior') {
        $datosGrafica = $modelo->accesosMes($registros);
      }

      $resumen = $modelo->getResumenAcceso($registros);
      return $this->render('_reporteAcceso', ['registros' => $registros, 'datosGrafica' => $datosGrafica, 'tiempo' => $tiempo, 'resumen' => $resumen]);
    }
  }

  public function actionSeleccionarLaboratorio($nitLaboratorio)
  {
    Yii::$app->session[Yii::$app->params['visitamedica']['session']['nitLaboratorio']] = $nitLaboratorio;
    return json_encode(
        ['response' => 'ok', 
         'result' => Yii::$app->session[
              Yii::$app->params['visitamedica']['session']['nitLaboratorio']
            ]]);
  }

  protected function getTerceros() {
        ini_set("soap.wsdl_cache_enabled", 0);
        $client = new \SoapClient(Yii::$app->params['webServices']['productos']['terceros']);
        $arr = $client->getTerceros();
        if ($arr === null) {
            echo "NULL ERROR";
        } else {
            return $arr;
        }
    }
}

?>