<?php

namespace app\modules\intranet\modules\servicop\modules\creditos\controllers;

use Yii;
use yii\web\Controller;
use yii\httpclient\Client;
use yii\helpers\Json;
/**
 * 
 */
class ReportesController extends Controller
{
    public function actionVolanteNomina()
    {
        $url = Yii::$app->params['webServices']['servicop']['reportes'] . 'volanteNomina';
        $parametros = [
            'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
            // 'numeroDocumento' => 10002383,
            'mes' => date('m'),
            'anio' => date('Y')
        ];
        $datos = $this->consultarWebService($url, $parametros);
        return $this->render('volante-nomina', ['datos' => $datos['response']]);
    }

    public function actionLiquidacionVacaciones()
    {
        $url = Yii::$app->params['webServices']['servicop']['reportes'] . 'liquidacionVacaciones';
        $parametros = [
            'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
            // 'numeroDocumento' => 10002383,
            'mes' => date('m'),
            'anio' => date('Y')
        ];
        $datos = $this->consultarWebService($url, $parametros);
        return $this->render('liquidacion-vacaciones', ['datos' => $datos['response']]);
    }

    public function actionPagoRodamientos()
    {
        $url = Yii::$app->params['webServices']['servicop']['reportes'] . 'pagoRodamientos';
        $parametros = [
            'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
            // 'numeroDocumento' => 10002383,
            'mes' => date('m'),
            'anio' => date('Y')
        ];
        $datos = $this->consultarWebService($url, $parametros);
        return $this->render('pago-rodamientos', ['datos' => $datos['response']]);
    }

    public function actionCuotasFondoMutuo()
    {
        $url = Yii::$app->params['webServices']['servicop']['reportes'] . 'cuotasFondoMutuo';
        $parametros = [
            'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
            // 'numeroDocumento' => 10002383,
            'mes' => date('m'),
            'anio' => date('Y')
        ];
        $datos = $this->consultarWebService($url, $parametros);
        return $this->render('cuotas-fondo-mutuo', ['datos' => $datos['response']]);
    }

    public function actionFinanciero()
    {
        $url = Yii::$app->params['webServices']['servicop']['reportes'] . 'financiero';
        $parametros = [
            'numeroDocumento' => Yii::$app->user->identity->numeroDocumento,
            // 'numeroDocumento' => 10002383,
        ];
        $datos = $this->consultarWebService($url, $parametros);
        return $this->render('financiero', ['datosReporte' => $datos['response']]);
    }

    private function consultarWebService($url, $parametros, $metodo='get')
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod($metodo)
            ->setUrl($url)
            ->setData($parametros)
            ->send();
        return Json::decode($response->content);
    }   
}