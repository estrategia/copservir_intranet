<?php

namespace app\modules\trademarketing\controllers\rest;

use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use app\modules\trademarketing\models\AsignacionPuntoVenta;
use app\modules\trademarketing\models\AsignacionPuntoVentaSearch;

class RestAsignacionPuntoVentaController extends ActiveController
{
    public $modelClass = 'app\modules\trademarketing\models\AsignacionPuntoVenta';

    public function actions()
    {
        $actions = parent::actions();

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    public function prepareDataProvider()
    {
        $searchModel = new AsignacionPuntoVentaSearch();
        return $searchModel->searchAll(\Yii::$app->request->queryParams);
    }

}
