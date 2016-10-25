<?php

namespace app\modules\proveedores\modules\visitamedica\controllers;

use yii\web\Controller;
use yii\httpclient\Client;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\proveedores\modules\visitamedica\models\Reportes;
use yii\helpers\VarDumper;


/**
* 
*/
class ReportesController extends Controller
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
                    'index', 'producto', 'acceso'
                ],
                'authsActions' => [
                    'index' => 'visitaMedica_reportes_index',
                    'acceso' => 'visitaMedica_reportes_acceso',
                    'producto' => 'visitaMedica_reportes_producto',
                ],
           ],
        ];
  }

  public function actionIndex()
  {
    return $this->render('reportes');
  }

  public function actionProducto()
  {
    $modelo = new Reportes();
    if (isset($_GET['tiempo'])) {
      $tiempo = $_GET['tiempo'];
      $datosGrafica = [];
      $registros = $modelo->getRegistrosConsultaProductos($tiempo);

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
    if (isset($_GET['tiempo'])) {
      $tiempo = $_GET['tiempo'];
      $datosGrafica = [];
      $registros = $modelo->getRegistrosAcceso($tiempo);

      if ($tiempo == 'hoy' || $tiempo == 'ayer') {
        $datosGrafica = $modelo->accesosDia($registros);
      }

      if ($tiempo == 'semana' || $tiempo == 'semana-anterior') {
        $datosGrafica = $modelo->accesosSemana($registros);
      }
      if ($tiempo == 'mes' || $tiempo == 'mes-anterior') {
        $datosGrafica = $modelo->accesosMes($registros);
      }
      return $this->render('_reporteAcceso', ['registros' => $registros, 'datosGrafica' => $datosGrafica, 'tiempo' => $tiempo]);
    }
  }
}

?>