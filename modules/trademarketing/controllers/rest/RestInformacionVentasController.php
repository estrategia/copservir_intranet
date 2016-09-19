<?php

namespace app\modules\trademarketing\controllers\rest;

use yii\rest\ActiveController;
use app\modules\trademarketing\models\InformacionVentasSearch;

/**
* Controlador para api REST del modelo AsignacionPuntoVenta
*/
class RestInformacionVentasController extends ActiveController
{

    public $modelClass = 'app\modules\trademarketing\models\InformacionVentas';

    public function actions()
    {
        $actions = parent::actions();

        // Personaliza el dataProvider que va a usar la accion
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    // uso del dataProvider personalizado
    public function prepareDataProvider()
    {
        $searchModel = new InformacionVentasSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }
}
