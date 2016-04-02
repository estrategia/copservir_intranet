<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
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
        
        return $this->render('index', ['dataProvider'=>$dataProvider]);
        
    }

    public function actionResumen() {
        set_time_limit(0); //Establece el número de segundos que se permite la ejecución de un script.
        $fecha_ac = isset($_POST['timestamp']) ? $_POST['timestamp'] : 0;

        $fecha_bd = $fecha_ac;
        $objNotificacion = null;

        while ($fecha_bd <= $fecha_ac) {
            $objNotificacion = Notificaciones::find()->orderBy('fechaRegistro DESC')->one();

            //$query3 = "SELECT timestamp FROM mensajes ORDER BY timestamp DESC LIMIT 1";
            //$con = mysql_query($query3);
            //$ro = mysql_fetch_array($con);

            usleep(100000); //anteriormente 10000
            clearstatcache();
            if ($objNotificacion !== null) {
                $fecha_bd = \DateTime::createFromFormat('Y-m-d H:i:s', $objNotificacion->fechaRegistro);
                $fecha_bd = $fecha_bd->getTimestamp();
            }
        }


        $html = $this->renderPartial('resumen', ['listNotificaciones' => Notificaciones::consultarNotificaciones(Yii::$app->user->identity->numeroDocumento)]);
        echo Json::encode(array('result' => 'ok', 'response' => ['html' => $html, 'timestamp' => $fecha_bd]));
        Yii::$app->end();
    }


}
