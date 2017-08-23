<?php

namespace app\modules\intranet\modules\servicop\modules\creditos\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;

/**
 * 
 */
class SolicitudesController extends Controller
{
    public function actionIndex()
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $solicitudes = $solicitud = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/solicitudesUsuario', ['numeroDocumento' => $numeroDocumento], 'get')['response'];
        return $this->render('index', ['solicitudes' => $solicitudes]);
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
        $response = [];
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $modelId = $_POST['idSolitudDocumento'];
        $nombreDocumento = $_POST['nombreDocumento'];
        $idSolicitud = $_POST['idSolicitud'];
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $rutaArchivo = Yii::$app->params['servicop']['rutas']['documentos'] . "/{$numeroDocumento}/{$idSolicitud}/";
        $nombreArchivo = $rutaArchivo . "{$nombreDocumento}.pdf";

        if (!is_dir($rutaArchivo)) {
            // mkdir($rutaArchivo);
            FileHelper::createDirectory($rutaArchivo, 0777, true);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $archivoMovido = move_uploaded_file(
            $_FILES['documento']['tmp_name'],
            $nombreArchivo
        );

        if (!$archivoMovido) {
            $response = ['error', 'no se ha podido guardar el archivo'];
            $response = ['error', $_FILES];
            return $response;
        }

        $respuestaWS = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/cargarDocumento', ['idSolicitudDocumento' => $modelId, 'rutaDocumento' => $nombreArchivo], 'post')['response'];
        
        $response = ['result' => 'ok', 'response' => $respuestaWS];
        return $response;
    }
}