<?php

namespace app\modules\trademarketing\controllers\rest;

use yii\rest\ActiveController;
use app\modules\trademarketing\models\PorcentajeEspaciosPuntoVentaSearch;
use app\modules\trademarketing\models\Reporte;
use yii\helpers\VarDumper;

/**
* Controlador para api REST del modelo Reporte
*/
class RestReporteController extends ActiveController
{

    public $modelClass = 'app\modules\trademarketing\models\Reporte';

    public function actions()
    {
        $actions = parent::actions();

        // desactiva las acciones
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['options'], $actions['view'], $actions['index']);

        return $actions;
    }

    /**
    * Accion que indica la url donde se pedira la informacion del reporte
    * url generada para la peticion:
    * copservir_intranet/web/trademarketing/rest/rest-reporte/informacion-reporte?id=$id
    * @param $id: es el id de la asignacion
    * @return informacion del modelo Reporte
    */
    public function actionInformacionReporte($id)
    {
      $reporte = new Reporte($id);
      // $reporte->cearReporte($id);
      // $reporte->generarDatos();
      \Yii::$app->response->format = 'json';
      return $reporte->generarDatos();
      // VarDumper::dump($reporte->asignacion->calificaciones[0]->variable->categoria, 10,true);
      // VarDumper::dump($reporte->generarDatos(), 10, true);
      // return $reporte->generarTablaReporte();
    }
}
