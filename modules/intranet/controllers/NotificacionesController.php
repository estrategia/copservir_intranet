<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use app\modules\intranet\models\Notificaciones;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

class NotificacionesController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /*
      renderiza el index
      retorna las lineas de tiempo y su respectivo contenido s
     */

    public function actionIndex() {
        $dataProvider = new ActiveDataProvider([
            'query' => Notificaciones::consultarNotificaciones(Yii::$app->user->identity->numeroDocumento, true),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionResumen() {
        echo Json::encode(array('result' => 'error', 'response' => "No autenticado"));
        Yii::$app->end();
        /* if(Yii::$app->user->isGuest){
          echo Json::encode(array('result' => 'error', 'response' => "No autenticado"));
          Yii::$app->end();
          } */

        set_time_limit(0); //Establece el número de segundos que se permite la ejecución de un script.
        $fecha_ac = isset($_POST['timestamp']) ? intval($_POST['timestamp']) : 0;

        //Yii::info("notificacionResumen:: ".\yii\helpers\VarDumper::dumpAsString($_POST['timestamp']));

        $fecha_bd = $fecha_ac;
        $objNotificacion = null;
        //Yii::info("notificacionResumen::0: ".$fecha_bd);

        while ($fecha_bd <= $fecha_ac) {
            $objNotificacion = Notificaciones::find()->orderBy('fechaRegistro DESC')->one();

            /* $objNotificacion = Notificaciones::find()
              ->where("numeroDocumentoDirigido='".Yii::$app->user->identity->numeroDocumento."'")
              ->orderBy('fechaRegistro DESC')->one();
              Yii::info("notificacionResumen::1: ".\yii\helpers\VarDumper::dumpAsString($objNotificacion)); */

            usleep(100000); //anteriormente 10000
            clearstatcache();
            if ($objNotificacion !== null) {
                $fecha_bd = \DateTime::createFromFormat('Y-m-d H:i:s', $objNotificacion->fechaRegistro);
                //Yii::info("notificacionResumen::2: ".\yii\helpers\VarDumper::dumpAsString($fecha_bd));
                $fecha_bd = $fecha_bd->getTimestamp();
                //Yii::info("notificacionResumen::3: ".\yii\helpers\VarDumper::dumpAsString($fecha_bd));
            }
        }

        if (Yii::$app->user->isGuest) {
            echo Json::encode(array('result' => 'error', 'response' => "No autenticado"));
            Yii::$app->end();
        }

        $cantidad = Notificaciones::cantidadNoVistas(Yii::$app->user->identity->numeroDocumento);
        $html = $this->renderPartial('resumen', ['listNotificaciones' => Notificaciones::consultarNotificaciones(Yii::$app->user->identity->numeroDocumento)]);
        echo Json::encode(array('result' => 'ok', 'response' => ['html' => $html, 'timestamp' => $fecha_bd, 'count' => $cantidad]));
        Yii::$app->end();
    }

    public function actionVisto() {
        Notificaciones::updateAll(['estadoNotificacion' => Notificaciones::ESTADO_VISTA], 'numeroDocumentoDirigido=' . Yii::$app->user->identity->numeroDocumento);
        $cantidad = Notificaciones::cantidadNoVistas(Yii::$app->user->identity->numeroDocumento);
        $html = $this->renderPartial('resumen', ['listNotificaciones' => Notificaciones::consultarNotificaciones(Yii::$app->user->identity->numeroDocumento)]);
        echo Json::encode(array('result' => 'ok', 'response' => ['html' => $html, 'count' => $cantidad]));
        Yii::$app->end();
    }

}
