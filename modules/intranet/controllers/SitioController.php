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
use app\modules\intranet\models\UsuariosOpcionesFavoritos;
use app\modules\intranet\models\MeGustaContenidos;
use app\modules\intranet\models\ContenidosComentarios;
use app\modules\intranet\models\Indicadores;
use app\modules\intranet\models\OfertasLaborales;
use app\modules\intranet\models\Notificaciones;
use app\modules\intranet\models\Tareas;

class SitioController extends Controller {

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
            return $this->redirect(['usuario/autenticar']);
            exit();
        }
        $fecha = Date("Y-m-d h:i:s");
        $contenidoModel = new Contenido();
        $lineasTiempo = LineaTiempo::find()->where(['estado' => 1])->all();
        $indicadores = Indicadores::find()->all();
        $ofertasLaborales = OfertasLaborales::find()
                ->with(['objCargo', 'objArea', 'objCiudad', 'objInformacionContactoOferta'])
                ->where(
                        ['and',
                            ['<=', 'fechaInicioPublicacion', $fecha],
                            ['>=', 'fechaFinPublicacion', $fecha]
                ])
                ->all();

        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $tareasUsuario = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', 0])->andWhere(['!=', 'estadoTarea', 3])->all();



        return $this->render('index', [
                    'contenidoModel' => $contenidoModel,
                    'lineasTiempo' => $lineasTiempo,
                    'indicadores' => $indicadores,
                    'ofertasLaborales' => $ofertasLaborales,
                    'tareasUsuario' => $tareasUsuario,
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

    public function actionMenu() {
        return $this->render('menu');
    }

    public function actionAgregarOpcionMenu() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            if ($post['value'] == 1) {// crear la opcion
                $nuevodato = new UsuariosOpcionesFavoritos();
                $nuevodato->idUsuario = Yii::$app->user->identity->numeroDocumento;
                $nuevodato->idMenu = $post['idMenu'];
                $nuevodato->save();
            } else {// eliminar la opcion
                UsuariosOpcionesFavoritos::deleteAll('idMenu = :idMenu AND idUsuario = :idUsuario', [':idMenu' => $post['idMenu'], ':idUsuario' => Yii::$app->user->identity->numeroDocumento]);
            }
        }
    }

    public function actionMeGustaContenido() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $result = true;
            if ($post['value'] == 1) {// crear la opcion
                $meGusta = new MeGustaContenidos();
                $meGusta->idContenido = $post['idContenido'];
                $meGusta->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
                $meGusta->fechaRegistro = Date("Y-m-d h:i:s");
                if (!$meGusta->save()) {
                    $result = false;
                    $contenido = Contenido::find()->where(['idContenido' => $meGusta->idContenido])->one();

                    if (empty($contenido)) {
                        $items = [
                            'result' => 'error',
                            'response' => 'El contenido ya no existe'
                        ];
                    } else {
                        $items = [
                            'result' => 'error',
                            'response' => 'Error al guardar el comentario'
                        ];
                    }
                } else {
                    // enviar notificacion al emisario
//                    $contenido = Contenido::find()->where(['idContenido' => $meGusta->idContenido])->one();
//                    $notificacion = new Notificaciones();
//                    $notificacion->idUsuarioDirige= Yii::$app->user->identity->numeroDocumento;
//                    $notificacion->idUsuarioDirigido= $contenido->idUsuarioPublicacion;
//                    $notificacion->descripcion= Yii::$app->user->identity->alias." le ha dado me gusta a tu publicación";
//                    $notificacion->estadoNotificacion= "1";
//                    $notificacion->idTipoNotificacion= 1;
                }
            } else {
                MeGustaContenidos::deleteAll('idContenido = :idContenido AND numeroDocumento = :numeroDocumento', [':idContenido' => $post['idContenido'], ':numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
            }

            if ($result) {

                $numeroMeGusta = count(MeGustaContenidos::find()->where(['idContenido' => $post['idContenido']])->all());
                $items = [
                    'result' => 'ok',
                    'response' => ($numeroMeGusta > 0) ? $numeroMeGusta . " Me gusta" : ""
                ];
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $items;
        }
    }

    public function actionGuardarComentario() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            $comentario = new ContenidosComentarios();

            $comentario->idContenido = $post['idContenido'];
            $comentario->contenido = $post['comentario'];
            $comentario->idUsuarioComentario = Yii::$app->user->identity->numeroDocumento;
            $comentario->fechaComentario = Date("Y-m-d h:i:s");
            $comentario->fechaActualizacion = $comentario->fechaComentario;
            $comentario->estado = 1;

            if ($comentario->save()) {

//                $contenido = Contenido::find()->where(['idContenido' => $comentario->idContenido])->one();
//                $notificacion = new Notificaciones();
//                $notificacion->idUsuarioDirige= Yii::$app->user->identity->numeroDocumento;
//                $notificacion->idUsuarioDirigido= $contenido->idUsuarioPublicacion;
//                $notificacion->descripcion= Yii::$app->user->identity->alias." ha comentado tu publicación";
//                $notificacion->estadoNotificacion= "1";
//                $notificacion->idTipoNotificacion= 2;

                $noticia = Contenido::traerNoticiaEspecifica($comentario->idContenido);
                $linea = LineaTiempo::find()->where(['idLineaTiempo' => $noticia->idLineaTiempo])->one();

                $items = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('_contenido', ['noticia' => $noticia, 'linea' => $linea])
                ];
            } else {

                $contenido = Contenido::find()->where(['idContenido' => $comentario->idContenido])->one();

                if (empty($contenido)) {
                    $items = [
                        'result' => 'error',
                        'response' => 'El contenido ya no existe'
                    ];
                } else {
                    $items = [
                        'result' => 'error',
                        'response' => 'Error al guardar el comentario'
                    ];
                }
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $items;
        }
    }

    /*
      accion para renderizar el formulario para publicar un contenido en una linea de tiempo
     */

    public function actionFormNoticia($lineaTiempo) {
        $contenidoModel = new Contenido();
        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();
        echo $this->renderAjax('formNoticia', [
            'contenidoModel' => $contenidoModel,
            'linea' => $linea,
        ]);
    }

    /*
      accion para renderizar la vista calendario
     */

    public function actionCalendario() {
        return $this->render('calendario', []);
    }

    /*
      accion para renderizar la vista publicaciones
     */

    public function actionPublicaciones() {
        return $this->render('publicaciones', []);
    }

    /*
      accion para renderizar la vista organigrama
     */

    public function actionOrganigrama() {
        return $this->render('organigrama', []);
    }


    /*
    * accion para obtener el contenido del modal
    * @param none
    * @return html contenido modal
    */
    public function actionPopupContenido()
    {

      $db = Yii::$app->db;
      $userCiudad = Yii::$app->user->identity->getCodigoCiudad();
      $userGrupos = Yii::$app->user->identity->getGruposCodigos();
      $userNumeroDocumento = Yii::$app->user->identity->numeroDocumento;

      $query = $db->createCommand('select c.idContenidoEmergente, c.contenido from  m_contenidoemergente as c, t_contenidoemergentedestino as cd
	                           where (c.fechaInicio<=:fecha AND c.fechaFin >=:fecha AND c.estado=:estado AND c.idContenidoEmergente = cd.idContenidoEmergente and cd.idGrupoInteres IN(:userGrupos) and cd.codigoCiudad =:userCiudad)
                                  NOT IN( select idContenidoEmergente from t_contenidoemergentevisto where numeroDocumento ='.$userNumeroDocumento.' )  order by rand()')
                                  ->bindValue(':userCiudad', $userCiudad )
                                  //->bindValue(':userNumeroDocumeto', $userNumeroDocumento )
                                  ->bindValue(':userGrupos', implode(',',$userGrupos) )
                                  ->bindValue(':fecha', date('Y-m-d H:i:s') )
                                  ->bindValue(':estado', 1 )
                                  ->queryOne();

      //echo var_dump($query);

      $items = [
       'result' => 'ok',
       'response' => $this->renderAjax('popup',['query'=>$query]),
      ];
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $items;
    }

}
