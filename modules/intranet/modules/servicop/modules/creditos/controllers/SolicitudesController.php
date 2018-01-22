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
    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
        ];
    }

    public function actionRenderWidgetDocumentos($idSolicitud)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $response = [];
        $respuestaWS = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/detalle', ['idSolicitud' => $idSolicitud], 'get')['response'];
        $solicitud = $respuestaWS['solicitud'];
        $relaciones = $respuestaWS['relaciones'];
        // \yii\helpers\VarDumper::dump($respuestaWS,10,true);
        // exit();
        $response = ['result' => 'ok', 'response' => $this->renderPartial('_widgetDocumento', ['solicitud' => $solicitud, 'relaciones' => $relaciones])];
        return Json::encode($response);
    }

    public function actionRadicar()
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        $result = [];
        $idSolicitud = $request->post('idSolicitud');
        $respuestaWS = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/radicar', ['idSolicitud' => $idSolicitud], 'post');
        if ($respuestaWS['result']  == 'ok') {
            $result = ['result' => 'ok', 'response' => $respuestaWS['response']];
        } else {
            $result = ['result' => 'error', 'response' => $respuestaWS['response']];
        }
        return Json::encode($result);
    }

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
            $solicitud = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/crear', ['datos' => $datosFormulario], 'post', ['content-type' => 'application/x-www-form-urlencoded']);
        }
        if ($solicitud['result'] == 'ok') {
            $response = ['result' => 'ok', 'response' => $solicitud['response']];
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
        $nombreDocumento = preg_replace('/\s+/', '_', $_POST['nombreDocumento']);
        $idSolicitud = $_POST['idSolicitud'];
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $rutaArchivo = Yii::$app->params['servicop']['rutas']['documentos'] . "/{$numeroDocumento}/servicoop/creditos/{$idSolicitud}/";
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
            // $response = ['error', $_FILES];
            return $response;
        }

        $respuestaWS = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/cargarDocumento', ['idSolicitudDocumento' => $modelId, 'rutaDocumento' => $nombreArchivo], 'post')['response'];
        
        $response = ['result' => 'ok', 'response' => $respuestaWS];
        return $response;
    }

    public function actionDescargarArchivo($idSolicitudDocumento)
    {
        $response = [];
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;

        $documento = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/detalleDocumento', ['idSolicitudDocumento' => $idSolicitudDocumento])['response'];

        Yii::$app->response->sendFile($documento['rutaDocumento']);
    }

    public function actionDescargarFormato($idSolicitudDocumento)
    {
        $response = [];
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;

        $documento = $module->consultarWebService($params['webServices']['servicop']['solicitudes'] . '/detalleFormato', ['idSolicitudDocumento' => $idSolicitudDocumento])['response'];

        Yii::$app->response->sendFile($documento['rutaFormato']);
    }
}