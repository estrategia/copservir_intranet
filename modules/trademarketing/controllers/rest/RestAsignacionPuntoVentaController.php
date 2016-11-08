<?php

namespace app\modules\trademarketing\controllers\rest;

use yii\rest\ActiveController;
use app\modules\trademarketing\models\AsignacionPuntoVentaSearch;

/**
* Controlador para api REST del modelo AsignacionPuntoVenta
*/
class RestAsignacionPuntoVentaController extends ActiveController
{

    public $modelClass = 'app\modules\trademarketing\models\AsignacionPuntoVenta';

    public function actions()
    {
        $actions = parent::actions();

        // Personaliza el dataProvider que va a usar la accion
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
        $actions['findByPV']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    // uso del dataProvider personalizado
    public function prepareDataProvider()
    {
        $searchModel = new AsignacionPuntoVentaSearch();
        return $searchModel->searchAll(\Yii::$app->request->queryParams);
    }
}
