<?php

namespace app\modules\trademarketing\controllers\rest;

use yii\rest\ActiveController;
use app\modules\trademarketing\models\InformacionVentas;
/**
* Controlador para api REST del modelo AsignacionPuntoVenta
*/
class RestInformacionVentasController extends ActiveController
{

    public $modelClass = 'app\modules\trademarketing\models\InformacionVentas';

    public function actions()
    {
        $actions = parent::actions();

        // desactiva las acciones
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['options'], $actions['view'], $actions['index']);

        return $actions;
    }

    /**
    * Accion que indica la url donde se pedira la informacion del reporte de ventas
    * url generada para la peticion:
    * copservir_intranet/web/trademarketing/rest/rest-informacion-ventas/informacion-reporte-ventas?mesInicio=$mesInicio&mesFin=$mesFin&puntoVenta=$puntoVenta
    * @param $mesInicio, $mesFin, $puntoVenta
    * @return informacion del modleo InformacionVentas
    */
    public function actionInformacionReporteVentas($mesInicio, $puntoVenta)
    {
      
        $model = new InformacionVentas($mesInicio, $puntoVenta);
        $info = $model->crecimientoAñoAnterior();
        return $info;
    }
}
