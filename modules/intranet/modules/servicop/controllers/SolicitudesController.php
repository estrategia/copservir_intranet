<?php

namespace app\modules\intranet\modules\servicop\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
/**
 * 
 */
class SolicitudesController extends Controller
{
    public function actionIndex()
    {
        
    }

    public function actionCrear()
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;

        $solicitud = [];
        $response = [];
        $datosFormulario = [];
        if ($request->isPost) {
            parse_str($request->post('datos'), $datosFormulario);
            $solicitud = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/crear', ['datos' => $datosFormulario], 'post')['response'];
        }
        if (!empty($solicitud)) {
            $response = ['result' => 'ok', 'response' => $solicitud];
        } else {
            $response = ['result' => 'error', 'response' => $solicitud];
        }
        return Json::encode($response);
    }

    public function actionActualizar()
    {
        
    }

    public function actionDetalle($idSolicitud)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        // $response = [];
        $respuestaWS = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/detalle', ['idSolicitud' => $idSolicitud], 'get')['response'];
        $solicitud = $respuestaWS['solicitud'];
        $relaciones = $respuestaWS['relaciones'];
        return $this->render('detalle', ['solicitud' => $solicitud, 'relaciones' => $relaciones]);
    }

    public function actionCargarDocumento()
    {
        // var_dump($_FILES[]);
    }
}