<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use app\modules\intranet\models\EventosCalendario;

class CalendarioController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    

    /*
      renderiza el index
      visualiza calendario
     */

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionEventos() {
        $request = Yii::$app->request;
        $start = $request->post('inicio');
        $end = $request->post('fin');

        if ($start === null || $end == null) {
            echo Json::encode(array('result' => 'error', 'response' => 'Solicitud inv&aacute;lida'));
            Yii::$app->end();
        }

        $fstart = new \DateTime;
        $fstart->setTimestamp($start);
        $fend = new \DateTime;
        $fend->setTimestamp($end);

        try {
            $models = EventosCalendario::consultarEventos($fstart->format('Y-m-d'), $fend->format('Y-m-d'));
            $eventos = [];

            foreach ($models as $model) {
                $eventos[] = $model->convertirEvento();
            }

            echo Json::encode(array('result' => 'ok', 'response' => Json::encode($eventos)));
            Yii::$app->end();
        } catch (Exception $exc) {
            //Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            echo Json::encode(array('result' => 'error', 'response' => 'Error al cargar programaci&oacute;n. ' . $exc->getMessage()));
            Yii::$app->end();
        }
    }

    public function actionResumen() {
        $request = Yii::$app->request;
        $inicio = $request->post('inicio');
        $fin = $request->post('fin');
        $vista = $request->post('vista');

        if ($inicio === null || $fin == null || $vista === null) {
            echo Json::encode(array('result' => 'error', 'response' => 'Solicitud inv&aacute;lida'));
            Yii::$app->end();
        }
        
        $fInicio = \DateTime::createFromFormat('Y-m-d H:i:s', "$inicio 00:00:00");
        $fFin = \DateTime::createFromFormat('Y-m-d H:i:s', "$fin 23:59:00");

        if ($vista == 1) {
            $dias = \app\modules\intranet\models\Funciones::diasTranscurridos($inicio, $fin)/2;
            $fInicio->modify("+$dias days");
            $fInicio->modify('first day of this month');
            $anho = $fInicio->format('Y');
            $mes = $fInicio->format('n');
            $fInicio = \DateTime::createFromFormat('Y-m-d H:i:s', "$anho-$mes-01 00:00:00");
            $ultimoDia = date("d", (mktime(0, 0, 0, $mes + 1, 1, $anho) - 1));
            $fFin = \DateTime::createFromFormat('Y-m-d H:i:s', "$anho-$mes-$ultimoDia 23:59:00");
        }else{
            $fFin->modify('-1 day');
        }

        try {
            $listEventos = EventosCalendario::consultarEventos($fInicio->format('Y-m-d'), $fFin->format('Y-m-d'), true);
            $resumen = $this->renderAjax('resumen', ['vista' => $vista, 'fInicio' => $fInicio, 'fFin' => $fFin, 'listEventos'=>$listEventos]);
            echo Json::encode(array('result' => 'ok', 'response' => $resumen));
            Yii::$app->end();
        } catch (Exception $exc) {
            //Yii::log($exc->getMessage() . "\n" . $exc->getTraceAsString(), CLogger::LEVEL_ERROR, 'application');
            echo Json::encode(array('result' => 'error', 'response' => 'Error al cargar programaci&oacute;n. ' . $exc->getMessage()));
            Yii::$app->end();
        }
    }

}
