<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\intranet\models\Contenido;
use app\modules\intranet\models\LineaTiempo;

class SitioController extends Controller {

    public $layout = 'main';

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

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['autenticar']);
            exit();
        }

        $contenidoModel = new Contenido();
        $lineasTiempo = LineaTiempo::find()->where(['estado' => 1])->all();
        return $this->render('index', [
                    'contenidoModel' => $contenidoModel,
                    'lineasTiempo' => $lineasTiempo
        ]);
    }


    /*
      accion para seleccionar una linea de tiempo
      retorna la liena de tiempo y su respectivo contenido
    */
    public function actionCambiarLineaTiempo($lineaTiempo) {

        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();

        $noticias = Contenido::traerNoticias($lineaTiempo);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_lineaTiempo', [
                'linea' => $linea,
                'noticias' => $noticias
        ]
        )];
        return $items;
    }

    /*
      accion para guardar un contenido en alguna linea de tiempos
    */
    public function actionGuardarContenido() {

        $contenido = new Contenido();
        if ($contenido->load(Yii::$app->request->post())) {
            $contenido->idUsuarioPublicacion = Yii::$app->user->identity->idUsuario;
            $contenido->fechaPublicacion = $contenido->fechaActualizacion = Date("Y-m-d h:i:s");

            $lineaTiempo = LineaTiempo::find()->where(['=', 'idLineaTiempo', $contenido->idLineaTiempo])->one();

            if ($lineaTiempo->autorizacionAutomatica == 1) {
                $contenido->idEstado = 2; // estado aprobado
                $contenido->fechaAprobacion = Date("Y-m-d h:i:s");
                $contenido->fechaInicioPublicacion = Date("Y-m-d h:i:s");
            } else {
                $contenido->idEstado = 1; // estado pendiente por aprobacion
            }
            if ($contenido->save()) {
                $contenidoModel = new Contenido();
                $linea = LineaTiempo::find()->where(['idLineaTiempo' => $contenido->idLineaTiempo])->one();

                $noticias = Contenido::traerNoticias($contenido->idLineaTiempo);
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $items = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('_lineaTiempo', [
                        'contenidoModel' => $contenidoModel,
                        'linea' => $linea,
                        'noticias' => $noticias
                ])];
                return $items;
            };
        } else {
            echo "error";
        }
    }

    /*
      accion para renderizar el formulario para publicar un contenido en una linea de tiempo
    */
    public function actionFormNoticia($lineaTiempo)
    {
      $contenidoModel = new Contenido();
      $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();

      echo $this->renderAjax('formNoticia', [
                  'contenidoModel' => $contenidoModel,
                  'linea' => $linea,
      ]);
    }


    public function actionTareas()
    /*
    accion para renderizar la vista tareas
    */
    {
        return $this->render('tareas', []);
    }

    /*
    accion para renderizar la vista calendario
    */
    public function actionCalendario()
    {
        return $this->render('calendario', []);
    }

    /*
    accion para renderizar la vista publicaciones
    */
    public function actionPublicaciones()
    {
        return $this->render('publicaciones', []);
    }

    /*
    accion para renderizar la vista organigrama
    */
    public function actionOrganigrama()
    {
        return $this->render('organigrama', []);
    }

}
