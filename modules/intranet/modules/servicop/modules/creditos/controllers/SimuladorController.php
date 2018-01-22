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
    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
        ];
    }
    
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

    public function actionRenderSelectLineasCredito($idTipoLineaCredito)
    {
        $lineasCredito = Yii::$app->controller->module->consultarWebService(Yii::$app->params['webServices']['servicop']['lineasCredito'], ['idTipoLineaCredito' => $idTipoLineaCredito]);
        $selectLineasCredito = ArrayHelper::map($lineasCredito['response'], 'idCredito', 'nombreCredito');        
        $response = [
            'result' => 'ok', 
            'response' => $this->renderAjax('_selectLineasCredito', ['selectLineasCredito' => $selectLineasCredito])
        ];
        return Json::encode($response);
    }

    public function actionRenderWidgets($idCredito)
    {
        $session = Yii::$app->session;
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        
        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/detalle',
            ['idCredito' => $idCredito]
        )['response'];
        $session->set($params['servicop']['session']['lineaCredito'], $respuestaWS);
        $linea = $respuestaWS['lineaCredito'];
        $cupoMaximo = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/calcularCupoMaximo',
            [
                'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
                // 'numeroDocumento' => 94504074,
                'lineaCredito' => $request->get('idCredito')
            ],
            'get'
        )['response'];
        // \yii\helpers\VarDumper::dump($cupoMaximo,10);exit();

        $tiposCuotaExtra = $respuestaWS['relaciones']['cuotasExtra'];
        $parametros = $respuestaWS['relaciones']['parametros'];
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
        $widgets['parametros'] = $this->renderPartial('_formParametros', ['parametros' => $parametros]);
        $widgets['descripcion'] = $this->renderPartial('_descripcion', ['linea' => $linea]);

        $response['result'] = 'ok';
        $response['response'] = $widgets;
        return Json::encode($response);
    }

    public function actionValidarAntiguedad($numeroDocumento, $idCredito)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;

        $response = [];

        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['solicitudes'] . '/validarAntiguedad',
            ['numeroDocumento' => $numeroDocumento,'idCredito' => $idCredito]
        );

        if ($respuestaWS['result'] == 'ok') {
            $response = ['result' => 'ok', 'response' => 1];
        } else {
            $response = ['result' => 'ok', 'response' => 0];
        }
        
        return Json::encode($response);
    }

    public function actionValidarCargo($numeroDocumento, $idCredito)
    {
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;

        $response = [];

        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['solicitudes'] . '/validarCargo',
            ['numeroDocumento' => $numeroDocumento,'idCredito' => $idCredito]
        );

        if ($respuestaWS['result'] == 'ok') {
            $response = ['result' => 'ok', 'response' => 1];
        } else {
            $response = ['result' => 'ok', 'response' => 0];
        }
        
        return Json::encode($response);
    }

    public function actionRenderWidgets2()
    {
        $session = Yii::$app->session;
        $params = Yii::$app->params;
        $module = Yii::$app->controller->module;
        $request = Yii::$app->request;
        // \yii\helpers\VarDumper::dump($_POST,10);exit();
        $datosFormulario = [];
        parse_str($request->post('datos'), $datosFormulario);
        $idCredito = $request->post('idCredito');
        $respuestaWS = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/detalle',
            ['idCredito' => $idCredito]
        )['response'];
        $session->set($params['servicop']['session']['lineaCredito'], $respuestaWS);
        $linea = $respuestaWS['lineaCredito'];
        // $cupoMaximo = $module->consultarWebService(
        //     $params['webServices']['servicop']['lineasCredito'] . '/calcularCupoMaximo',
        //     [
        //         'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
        //         // 'numeroDocumento' => 94504074,
        //         'lineaCredito' => $request->get('idCredito')
        //     ],
        //     'get'
        // )['response'];
        $cupoMaximo = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/calcularCupoMaximo',
            ['datos' => $datosFormulario], 'post')['response'];
        // \yii\helpers\VarDumper::dump($respuestaWS,10);
        // exit();
        // $cupoMaximo = 0;
        $tiposCuotaExtra = $respuestaWS['relaciones']['cuotasExtra'];
        $parametros = $respuestaWS['relaciones']['parametros'];
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
        $widgets['parametros'] = $this->renderPartial('_formParametros', ['parametros' => $parametros]);
        $widgets['descripcion'] = $this->renderPartial('_descripcion', ['linea' => $linea]);

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
        $sueldoBasico = $module->consultarWebService($params['webServices']['servicop']['simulador'] . '/sueldo', ['numeroDocumento' => Yii::$app->user->identity->numeroDocumento])['response'];
        $anios = $this->calcularPeriodosCuotas($plazo, $tipoCuotaExtra['frecuencia']);
        // \yii\helpers\VarDumper::dump($tipoCuotaExtra,10,true);exit();
        if ($tipoCuotaExtra['frecuencia'] == 2) {
            $maximo = $sueldoBasico / 2;
            $formCuotaExtra = $this->renderAjax('_formCuotaExtraSemestral', ['anios' => $anios, 'tipoCuotaExtra' => $tipoCuotaExtra, 'maximo' => $maximo]);
        } else {
            $maximo = $sueldoBasico / 1;
            $formCuotaExtra = $this->renderAjax('_formCuotaExtraAnual', ['anios' => $anios, 'tipoCuotaExtra' => $tipoCuotaExtra, 'maximo' => $maximo]);
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
        $datosFormulario = [];
        parse_str($request->post('datos'), $datosFormulario);
        $cupoMaximo = $module->consultarWebService(
            $params['webServices']['servicop']['lineasCredito'] . '/calcularCupoMaximo',
            ['datos' => $datosFormulario], 'post')['response'];
        // $cupoMaximo = 10000000;
        $response = ['result' => 'ok', 'response' => $cupoMaximo];
        return Json::encode($response);
    }

    private function calcularPeriodosCuotas2($quincenas)
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

    // Periodo 1=>Anual, 2=>Semestral
    private function calcularPeriodosCuotas($quincenas, $periodo=1)
    {
        $periodoAprobacion = 10;
        $dias = ($quincenas * 15);
        $fechaInicial = date('Y-m-d', strtotime("+ $periodoAprobacion days"));
        if (date('m') == '06' || date('m') == '12') {
            $mesSiguiente = $periodoAprobacion + 30;
            $fechaInicial = date('Y-m-d', strtotime("+ $mesSiguiente days"));
        }
        $fechaInicio = date('Y-06-01');
        $fechaFin = date('Y-m-d', strtotime("+ $dias days"));
        $mesInicio = date('m', strtotime($fechaInicial));
        if ($periodo == 1 || ($periodo == 2 && $mesInicio >= 6)) {
            $fechaInicio = date('Y-12-01');
        } 
        $fechas = [];
        $fecha = $fechaInicio;
        do {
            $fechas[] = $fecha;
            if ($periodo == 2) {
                $fecha = date('Y-m-01', strtotime("+ 6 months", strtotime($fecha)));
            } else {
                $fecha = date('Y-m-01', strtotime("+ 1 year", strtotime($fecha)));
            }
        } while ($fecha < $fechaFin);
        return $fechas;
    }

    public function actionPrueba()
    {
        return Json::encode($this->calcularPeriodosCuotas(24, 1));
    }

}