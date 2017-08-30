<?php

namespace app\modules\intranet\modules\servicop\modules\creditos\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
/**
 * 
 */
class SimuladorController extends Controller
{
    public function actionIndex()
    {
        $params = [];

        $lineasCredito = Yii::$app->controller->module->consultarWebService(Yii::$app->params['webServices']['servicop']['lineasCredito']);
        $selectLineasCredito = ArrayHelper::map($lineasCredito['response'], 'idCredito', 'nombreCredito');

        $params = [
            'lineasCredito' => $lineasCredito,
            'selectLineasCredito' => $selectLineasCredito,
        ];

        return $this->render('index', $params);
    }

    public function actionRenderWidgets($idCredito)
    {
        $session = Yii::$app->session;
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        
        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/detalle',
            ['idCredito' => $idCredito]
        )['response'];
        $session->set($params['servicop']['session']['lineaCredito'], $respuestaWS);
        $linea = $respuestaWS['lineaCredito'];
        $cupoMaximo = 1000;
        $tiposCuotaExtra = $respuestaWS['relaciones']['cuotasExtra'];
        $garantias = [];
        if (isset($respuestaWS['relaciones']['garantias'])) {
            $garantias = $respuestaWS['relaciones']['garantias'];
        }
        $combinadas = [];
        $noCombinadas = [];
        foreach ($garantias as $key => $garantia) {
            if ($garantia['combinada'] == 1) {
                $combinadas[] = $garantia;
            } else {
                $noCombinadas[] = $garantia;
            }
        }
        $widgets = [];

        $widgets['infoBasica'] = $this->renderPartial('_infoBasica', ['linea' => $linea, 'cupoMaximo' => $cupoMaximo]);
        $widgets['tiposCuotaExtra'] = $this->renderPartial('_tiposCuotaExtra', ['tiposCuotaExtra' => $tiposCuotaExtra]);
        $widgets['garantiasCombinadas'] = $this->renderPartial('_formGarantiasCombinadas', ['garantias' => $combinadas]);
        $widgets['garantiasNoCombinadas'] = $this->renderPartial('_formGarantias', ['garantias' => $noCombinadas]);

        $response['result'] = 'ok';
        $response['response'] = $widgets;
        return Json::encode($response);
    }

    public function actionRenderFormCuotaExtra($idCuota, $plazo)
    {
        $session = Yii::$app->session;
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;

        $respuestaWS = [];
        $formCuotaExtra = [];
        if ($session->has($params['servicop']['session']['lineaCredito'])) {
            $respuestaWS = $session->get($params['servicop']['session']['lineaCredito']);
        }
        $tipoCuotaExtra = $module->consultarWebService($params['webServices']['servicop']['tiposCuotaExtra'] . '/detalle', ['idCuota' => $idCuota])['response'];
        // $respuestaWS['lineaCredito'][''];
        $anios = $this->calcularPeriodosCuotas($plazo);
        // \yii\helpers\VarDumper::dump($tipoCuotaExtra,10,true);exit();
        if ($tipoCuotaExtra['frecuencia'] == 2) {
            $formCuotaExtra = $this->renderAjax('_formCuotaExtraSemestral', ['anios' => $anios, 'tipoCuotaExtra' => $tipoCuotaExtra]);
        } else {
            $formCuotaExtra = $this->renderAjax('_formCuotaExtraAnual', ['anios' => $anios, 'tipoCuotaExtra' => $tipoCuotaExtra]);
        }
        $response = [
            'result' => 'ok',
            'response' => $formCuotaExtra
        ];
        return Json::encode($response);

    }

    public function actionSimular()
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;

        $simulacion = [];
        $response = [];
        $datosFormulario = [];
        if ($request->isPost) {
            parse_str($request->post('datos'), $datosFormulario);
            $simulacion = $module->consultarWebService($params['webServices']['servicop']['simulador'] . '/simular', ['datos' => $datosFormulario], 'post');
        }
        if (!empty($simulacion)) {
            if ($simulacion['result'] == 'ok') {
                $response = ['result' => 'ok', 'response' => $simulacion['response']];
            } else {
                $response = ['result' => 'error', 'response' => $simulacion['response']];
            }
        } else {
            $response = ['result' => 'error', 'response' => $simulacion['response']];
        }
        return Json::encode($response);
    }

    public function actionConsultarCupoMaximo()
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        $response = [];
        $cupoMaximo = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/calcularCupoMaximo',
            [
                'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
                'lineaCredito' => $request->get('idCredito')
            ],
            'get'
        )['response'];
        $response = ['result' => 'ok', 'response' => $cupoMaximo];
        return Json::encode($response);
    }

    private function calcularPeriodosCuotas($quincenas)
    {
        $dias = ($quincenas * 15);
        $inicio = (int) date('Y');
        $final = $inicio;
        $cantidadAnios = ceil($dias / 365);
        $anios[] = $inicio;
        for ($i=1; $i < $cantidadAnios; $i++) { 
            $final ++;
            $anios[] = $final;
        }
        return $anios;
    }

}