<?php

namespace app\modules\intranet\modules\servicop\modules\creditos\controllers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;

/**
 * Default controller for the `sascop` module
 */
class DefaultController extends Controller
{
    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $params = [];

        $tiposLineaCredito = Yii::$app->controller->module->consultarWebService(Yii::$app->params['webServices']['servicop']['tiposLineaCredito']);
        $selectTiposLineaCredito = ArrayHelper::map($tiposLineaCredito['response'], 'idTipoLineaCredito', 'nombre');

        $params = [
            'tiposLineaCredito' => $tiposLineaCredito,
            'selectTiposLineaCredito' => $selectTiposLineaCredito,
        ];

        return $this->render('index', $params);
    }

    public function actionRenderSelectLinea($idTipoLineaCredito)
    {
        $lineasCredito = Yii::$app->controller->module->consultarWebService(Yii::$app->params['webServices']['servicop']['lineasCredito'], ['idTipoLineaCredito' => $idTipoLineaCredito]);
        $selectLineasCredito = ArrayHelper::map($lineasCredito['response'], 'idCredito', 'nombreCredito');        
        $response = [
            'result' => 'ok', 
            'response' => $this->renderAjax('selectLineas', ['selectLineasCredito' => $selectLineasCredito])
        ];
        return Json::encode($response);
    }

    public function actionRenderDetalleLinea($idCredito)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        
        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/detalle',
            ['idCredito' => $idCredito]
        )['response'];
        $linea = $respuestaWS['lineaCredito'];
        $response = [
            'result' => 'ok',
            'response' => $linea
        ];
        return Json::encode($response);
    }
}
