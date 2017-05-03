<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use app\modules\intranet\models\EventosCalendario;
use app\modules\intranet\models\Portal;
use app\modules\intranet\models\EventosCalendarioPortalesDestino;

abstract class ControllerCalendar extends Controller {

/*  public function behaviors()
  {
      return [
          [
              'class' => \app\components\AccessFilter::className(),
          ],
          [
               'class' => \app\components\AuthItemFilter::className(),
               'only' => [
                  'index', 'eventos', 'resumen'
               ],
               'authsActions' => [
                   'index' => 'intranet_usuario',
                   'eventos' => 'intranet_usuario',
                   'resumen' => 'intranet_usuario',
               ]
           ],
      ];
  }*/

    public function actionIndex() {
        return $this->render('//common/calendario/index');
    }

    public function actionTest() {
        $portales = Portal::find()->where(['estado' => 1])->all();
        $response = \yii\helpers\ArrayHelper::map($portales, 'idPortal', 'nombrePortal');
        return JSON::encode($response);
        // $portal = $this->module->id;
        // $destino = array();

        // if ($portal == "intranet") {
        //     if(Yii::$app->user->isGuest){
        //         echo Json::encode(array('result' => 'error', 'response' => 'Solicitud inv&aacute;lida'));
        //         Yii::$app->end();
        //     }else{
        //         $destino['grupos'] = implode(',', Yii::$app->user->identity->getGruposCodigos());
        //         $destino['ciudad'] = Yii::$app->user->identity->getCiudadCodigo();
        //     }
        // }

        // $fin = "2016-06-12";
        // $inicio = "2016-03-01";
        // $fInicio = \DateTime::createFromFormat('Y-m-d H:i:s', "$inicio 00:00:00");
        // $fFin = \DateTime::createFromFormat('Y-m-d H:i:s', "$fin 23:59:00");

        // \yii\helpers\VarDumper::dump(EventosCalendario::consultarEventos($fInicio->format('Y-m-d'),$fFin->format('Y-m-d'),$portal,$destino), 10, true);

    }

    public function actionEventos() {
        $portal = $this->module->id;
        $destino = array();

        if ($portal == "intranet") {
            if(Yii::$app->user->isGuest){
                echo Json::encode(array('result' => 'error', 'response' => 'Solicitud inv&aacute;lida'));
                Yii::$app->end();
            }else{
                $destino['grupos'] = implode(',', Yii::$app->user->identity->getGruposCodigos());
                $destino['ciudad'] = Yii::$app->user->identity->getCiudadCodigo();
            }
        }

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
            $models = EventosCalendario::consultarEventos($fstart->format('Y-m-d'),$fend->format('Y-m-d'),$portal, $destino);
            $eventos = [];

            foreach ($models as $model) {
                $eventos[] = $model->convertirEvento($portal);
            }

            echo Json::encode(array('result' => 'ok', 'response' => Json::encode($eventos)));
            Yii::$app->end();
        } catch (Exception $exc) {
            Yii::error($exc->getMessage() . "\n" . $exc->getTraceAsString());
            echo Json::encode(array('result' => 'error', 'response' => 'Error al cargar programaci&oacute;n. ' . $exc->getMessage()));
            Yii::$app->end();
        }
    }

    public function actionResumen() {
        $portal = $this->module->id;
        $destino = array();

        if ($portal == "intranet") {
            if(Yii::$app->user->isGuest){
                echo Json::encode(array('result' => 'error', 'response' => 'Solicitud inv&aacute;lida'));
                Yii::$app->end();
            }else{
                $destino['grupos'] = implode(',', Yii::$app->user->identity->getGruposCodigos());
                $destino['ciudad'] = Yii::$app->user->identity->getCiudadCodigo();
            }
        }

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
            $dias = \app\modules\intranet\models\Funciones::diasTranscurridos($inicio, $fin) / 2;
            $fInicio->modify("+$dias days");
            $fInicio->modify('first day of this month');
            $anho = $fInicio->format('Y');
            $mes = $fInicio->format('n');
            $fInicio = \DateTime::createFromFormat('Y-m-d H:i:s', "$anho-$mes-01 00:00:00");
            $ultimoDia = date("d", (mktime(0, 0, 0, $mes + 1, 1, $anho) - 1));
            $fFin = \DateTime::createFromFormat('Y-m-d H:i:s', "$anho-$mes-$ultimoDia 23:59:00");
        } else {
            $fFin->modify('-1 day');
        }

        try {
            $listEventos = EventosCalendario::consultarEventos($fInicio->format('Y-m-d'),$fFin->format('Y-m-d'),$portal, $destino, true);
            $resumen = $this->renderAjax('//common/calendario/resumen', ['vista' => $vista, 'fInicio' => $fInicio, 'fFin' => $fFin, 'listEventos' => $listEventos]);
            echo Json::encode(array('result' => 'ok', 'module' => $this->module->id, 'response' => $resumen));
            Yii::$app->end();
        } catch (Exception $exc) {
            Yii::error($exc->getMessage() . "\n" . $exc->getTraceAsString());
            echo Json::encode(array('result' => 'error', 'response' => 'Error al cargar programaci&oacute;n. ' . $exc->getMessage()));
            Yii::$app->end();
        }
    }

}
