<?php
namespace app\modules\intranet\modules\servicop\modules\contribuciones\controllers;

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
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $solicitudes = $module->consultarWebService($params['webServices']['servicop']['solicitudesContribuciones'] . '/solicitudesUsuario', ['numeroDocumento' => $numeroDocumento], 'get')['response'];
        $estados = $module->consultarWebService($params['webServices']['servicop']['solicitudesContribuciones'] . '/estados')['response'];
        return $this->render('index', ['solicitudes' => $solicitudes, 'estados' => $estados]);
    }

    public function actionDetalle($idSolicitudContribucion)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        // $response = [];
        $respuestaWS = $module->consultarWebService($params['webServices']['servicop']['solicitudesContribuciones'] . '/detalle', ['idSolicitudContribucion' => $idSolicitudContribucion], 'get')['response'];
        $estados = $module->consultarWebService($params['webServices']['servicop']['solicitudesContribuciones'] . '/estados')['response'];
        $solicitud = $respuestaWS['solicitud'];
        $relaciones = $respuestaWS['relaciones'];
        return $this->render('detalle', ['solicitud' => $solicitud, 'relaciones' => $relaciones, 'estados' => $estados]);
    }

    public function actionCrear()
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;

        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['contribuciones']);
        $contribuciones = $respuestaWS['response'];
        $selectContribuciones = ArrayHelper::map($contribuciones, 'idContribucion', 'nombreContribucion');
        // var_dump($respuestaWS); exit();
        return $this->render('crear', ['selectContribuciones' => $selectContribuciones]);
    }

    public function actionSolicitar()
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;

        $solicitud = [];
        $response = [];
        $datosFormulario = [];
        if ($request->isPost) {
            parse_str($request->post('datos'), $datosFormulario);
            $datosFormulario['numeroDocumento'] = Yii::$app->user->identity->numeroDocumento;
            $solicitud = $module->consultarWebService($params['webServices']['servicop']['solicitudesContribuciones'] . '/crear', $datosFormulario, 'post')['response'];
        }
        if (!empty($solicitud)) {
            $response = ['result' => 'ok', 'response' => $solicitud];
        } else {
            $response = ['result' => 'error', 'response' => $datosFormulario];
        }
        return Json::encode($response);
    }

    public function actionRenderWidgetBeneficiario($idParentesco)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        // $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $numeroDocumento = 1130670869;
        $respuestaWS['Parenescos'] = [
            ['IdGrupoFamiliar' => 20546, 'IdParentesco' => 7, 'Parentesco' => 'Conyugue', 'ApellidosNombres' => 'Puentes Suares Maria Angelica', 'NumeroDocumentoFamiliar' => 38643725, 'VerificacionParentesco' => 1],
            ['IdGrupoFamiliar' => 23764, 'IdParentesco' => 1, 'Parentesco' => 'Madre', 'ApellidosNombres' => 'diaz qui\u00f1ones maria lucia', 'NumeroDocumentoFamiliar' => 634578, 'VerificacionParentesco' => 0]
        ];

        $parentescos = $respuestaWS['Parenescos'];
        // $respuestaWS = $module->consultarWebService(
        //     $params['webServices']['servicop']['parentescos'] . "/id/{$numeroDocumento}/Parentesco/{$idParentesco}"
        // );
        
        $response = ['result' => 'ok', 'response' => $this->renderAjax('_widgetBeneficiario', ['parentescos' => $parentescos])];
        return Json::encode($response);
    }

    public function actionRenderWidgetParentesco($idContribucion)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;

        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['contribuciones'] . '/detalle', ['idContribucion' => $idContribucion])['response'];
        $contribucion = $respuestaWS['contribucion'];
        $parentescos = $respuestaWS['relaciones']['beneficiarios'];
        
        $response = ['result' => 'ok', 'response' => $this->renderAjax('_widgetParentesco', ['parentescos' => $parentescos])];
        return Json::encode($response);

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
        $rutaArchivo = Yii::$app->params['servicop']['contribuciones']['rutas']['documentos'] . "/{$numeroDocumento}/{$idSolicitud}/";
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

        $respuestaWS = $module->consultarWebService($params['webServices']['servicop']['solicitudesContribuciones'] . '/cargarDocumento', ['idSolicitudDocumento' => $modelId, 'rutaDocumento' => $nombreArchivo], 'post')['response'];
        
        $response = ['result' => 'ok', 'response' => $respuestaWS];
        return $response;
    }
}