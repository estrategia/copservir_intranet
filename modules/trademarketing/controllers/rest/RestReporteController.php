<?php

namespace app\modules\trademarketing\controllers\rest;

use yii\rest\ActiveController;
use app\modules\trademarketing\models\PorcentajeEspaciosPuntoVentaSearch;
use app\modules\trademarketing\models\Reporte;

class RestReporteController extends ActiveController
{

    public $modelClass = 'app\modules\trademarketing\models\Reporte';

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create'], $actions['update'], $actions['options'], $actions['view'], $actions['index']);

        return $actions;
    }

    public function actionInformacionReporte($id)
    {
      $reporte = new Reporte($id);
      return $reporte;
    }
}
