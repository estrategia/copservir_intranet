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
use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\ContenidoEmergente;
use yii\data\Pagination;
use app\modules\intranet\models\UsuarioWidgetInactivo;
use app\modules\intranet\models\LogContenidos;
use yii\helpers\Html;

class SitioController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => 'http://192.168.0.35/copservir_intranet/imagenes/post/', //Yii::$app->realpath().'/imagenes', // Directory URL address, where files are stored.
                'path' => '@app/imagenes/post' // Or absolute path to directory where files are stored.
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
        $fecha = date("Y-m-d H:i:s");
        $contenidoModel = new Contenido();
        $lineasTiempo = LineaTiempo::find()->where(['estado' => 1])->all();
        $indicadores = Indicadores::find()->all();

        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $userCiudad = Yii::$app->user->identity->getCodigoCiudad();
        $userGrupos = Yii::$app->user->identity->getGruposCodigos();

        //tareas
        $tareasUsuario = Tareas::getTareasIndex($numeroDocumento);

        //ofertas laborales
        $dataProviderOfertas = OfertasLaborales::getOfertasLaboralesInteres($userCiudad, $userGrupos);

        //banners  Crear modelos y pasar las consultas al modelo
        $db = Yii::$app->db;
        $bannerArriba = $db->createCommand('select distinct pc.idImagenCampana, pc.rutaImagen, pc.urlEnlaceNoticia
                                                from t_CampanasDestino as pcc, t_Publicacionescampanas as pc
	                                                 where (pcc.idImagenCampana = pc.idImagenCampana and pc.estado=:estado and pc.posicion =:posicion
                                                    and (( pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:userCiudad) or ( pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:userCiudad)  )  )
                                                     order by rand()')
                ->bindValue(':userCiudad', $userCiudad)
                ->bindValue(':userGrupos', implode(',', $userGrupos))
                ->bindValue(':estado', 1)
                ->bindValue(':posicion', 0)
                ->bindValue('todosCiudad', \Yii::$app->params['ciudad']['*'])
                ->bindValue('todosGrupos', \Yii::$app->params['grupo']['*'])
                ->queryAll();

        $bannerAbajo = $db->createCommand('select distinct pc.idImagenCampana, pc.rutaImagen, pc.urlEnlaceNoticia
                                                from t_CampanasDestino as pcc, t_Publicacionescampanas as pc
                                                  where (pcc.idImagenCampana = pc.idImagenCampana and pc.estado=:estado and pc.posicion =:posicion
                                                    and (( pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:userCiudad) or ( pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:userCiudad) )  )
                                                     order by rand()')
                ->bindValue(':userCiudad', $userCiudad)
                ->bindValue(':userGrupos', implode(',', $userGrupos))
                ->bindValue(':estado', 1)
                ->bindValue(':posicion', 1)
                ->bindValue('todosCiudad', \Yii::$app->params['ciudad']['*'])
                ->bindValue('todosGrupos', \Yii::$app->params['grupo']['*'])
                ->queryAll();

        $bannerDerecha = $db->createCommand('select distinct pc.idImagenCampana, pc.rutaImagen, pc.urlEnlaceNoticia
                                                from t_CampanasDestino as pcc, t_Publicacionescampanas as pc
	                                                 where (pcc.idImagenCampana = pc.idImagenCampana and pc.estado=:estado and pc.posicion =:posicion
                                                    and (( pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:userCiudad) or ( pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres IN(:userGrupos) and pcc.codigoCiudad =:todosCiudad) or (pcc.idGrupoInteres =:todosGrupos and pcc.codigoCiudad =:userCiudad) )  )
                                                     order by rand()')
                ->bindValue(':userCiudad', $userCiudad)
                ->bindValue(':userGrupos', implode(',', $userGrupos))
                ->bindValue(':estado', 1)
                ->bindValue(':posicion', 2)
                ->bindValue('todosCiudad', \Yii::$app->params['ciudad']['*'])
                ->bindValue('todosGrupos', \Yii::$app->params['grupo']['*'])
                ->queryAll();

        return $this->render('index', [
                    'contenidoModel' => $contenidoModel,
                    'lineasTiempo' => $lineasTiempo,
                    'indicadores' => $indicadores,
                    'ofertasLaborales' => $dataProviderOfertas,
                    'tareasUsuario' => $tareasUsuario,
                    'bannerArriba' => $bannerArriba,
                    'bannerAbajo' => $bannerAbajo,
                    'bannerDerecha' => $bannerDerecha,
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
            $contenido->idUsuarioPublicacion = Yii::$app->user->identity->numeroDocumento;
            $contenido->fechaPublicacion = $contenido->fechaActualizacion = date("Y-m-d H:i:s");
            $error = false;
            $lineaTiempo = LineaTiempo::find()->where(['=', 'idLineaTiempo', $contenido->idLineaTiempo])->one();

            if ($lineaTiempo->autorizacionAutomatica == 1) {
                $contenido->estado = Contenido::APROBADO; // estado aprobado
                $contenido->fechaAprobacion = date("Y-m-d H:i:s");
                $contenido->fechaInicioPublicacion = date("Y-m-d H:i:s");
            } else {
                $contenido->estado = Contenido::PENDIENTE_APROBACION; // estado pendiente por aprobacion
            }

            if ($contenido->save()) {

                $solicitarGrupo = Yii::$app->request->post('SolicitarGrupoObjetivo');

                if ($solicitarGrupo == 1) {
                    $contenidodestino = Yii::$app->request->post('ContenidoDestino');
                    $ciudades = $contenidodestino['codigoCiudad'];
                    $gruposInteres = $contenidodestino['idGrupoInteres'];

                    for ($i = 0; $i < count($gruposInteres); $i++) {
                        $contenidodestino = new ContenidoDestino();
                        $contenidodestino->idGrupoInteres = $gruposInteres[$i];
                        $contenidodestino->codigoCiudad = $ciudades[$i];
                        $contenidodestino->idContenido = $contenido->idContenido;

                        if (!$contenidodestino->save()) {
                            $error = true;
                        }
                    }
                } else {
                    $contenidodestino = new ContenidoDestino();
                    $contenidodestino->idGrupoInteres = Yii::$app->params['grupo']['*'];
                    $contenidodestino->codigoCiudad = Yii::$app->params['ciudad']['*'];
                    $contenidodestino->idContenido = $contenido->idContenido;

                    if (!$contenidodestino->save()) {
                        $error = true;
                    }
                }

                if (!$error) {

                    $logContenido = new LogContenidos();
                    $logContenido->idContenido = $contenido->idContenido;
                    $logContenido->estado = $contenido->estado;
                    $logContenido->fechaRegistro = $contenido->fechaPublicacion;
                    $logContenido->idUsuarioRegistro = $contenido->idUsuarioPublicacion;

                    if (!$logContenido->save()) {
                        $error = true;
                    }
                }

                if (!$error) {
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
                } else {
                    return [
                        'result' => 'error',
                        'response' => 'Error al guardar el contenido'
                    ];
                }
            } else {
                return [
                    'result' => 'error',
                    'response' => 'Error al guardar el contenido'
                ];
            }
        } else {
            return [
                'result' => 'error',
                'response' => 'Error al guardar el contenido'
            ];
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
                $meGusta->fechaRegistro = date("Y-m-d H:i:s");
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
                    $contenido = Contenido::find()->where(['idContenido' => $meGusta->idContenido])->one();
                    if (Yii::$app->user->identity->numeroDocumento != $contenido->idUsuarioPublicacion) {
                        $notificacion = new Notificaciones();
                        $notificacion->idContenido = $meGusta->idContenido;
                        $notificacion->idUsuarioDirige = Yii::$app->user->identity->numeroDocumento;
                        $notificacion->idUsuarioDirigido = $contenido->idUsuarioPublicacion;
                        $notificacion->descripcion = "Dio me gusta a tu publicación";
                        $notificacion->estadoNotificacion = Notificaciones::ESTADO_CREADA;
                        $notificacion->tipoNotificacion = Notificaciones::NOTIFICACION_MEGUSTA;
                        $notificacion->fechaRegistro = date('Y-m-d H:i:s');

                        if (!$notificacion->save()) {
                            $result = false;
                            $items = [
                                'result' => 'error',
                                'response' => 'No se puede registrar notificación'
                            ];
                        }
                    }
                }
            } else {
                MeGustaContenidos::deleteAll('idContenido = :idContenido AND numeroDocumento = :numeroDocumento', [':idContenido' => $post['idContenido'], ':numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
            }

            if ($result) {

                $numeroMeGusta = count(MeGustaContenidos::find()->where(['idContenido' => $post['idContenido']])->all());
                $items = [
                    'result' => 'ok',
                    'response' => ($numeroMeGusta > 0) ?
                            Html::a($numeroMeGusta . " Me Gusta", '#', [
                                //'id' => 'showFormPublications' . $linea->idLineaTiempo,
                                'data-role' => 'listado-me-gusta-contenido',
                                'data-contenido' => $post['idContenido'],
                                'onclick' => 'return false'
                            ]) : ''
                ];
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $items;
        }
    }

    public function actionGuardarComentario() {
        date_default_timezone_set('America/Bogota');

        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();

            $comentario = new ContenidosComentarios();

            $comentario->idContenido = $post['idContenido'];
            $comentario->contenido = $post['comentario'];
            $comentario->idUsuarioComentario = Yii::$app->user->identity->numeroDocumento;
            $comentario->fechaComentario = date("Y-m-d H:i:s");
            $comentario->fechaActualizacion = $comentario->fechaComentario;
            $comentario->estado = 1;

            if ($comentario->save()) {
                $contenido = Contenido::find()->where(['idContenido' => $comentario->idContenido])->one();

                if (Yii::$app->user->identity->numeroDocumento != $contenido->idUsuarioPublicacion) {
                    $notificacion = new Notificaciones();
                    $notificacion->idContenido = $comentario->idContenido;
                    $notificacion->idUsuarioDirige = Yii::$app->user->identity->numeroDocumento;
                    $notificacion->idUsuarioDirigido = $contenido->idUsuarioPublicacion;
                    $notificacion->descripcion = "Comentó tu publicación";
                    $notificacion->estadoNotificacion = Notificaciones::ESTADO_CREADA;
                    $notificacion->tipoNotificacion = Notificaciones::NOTIFICACION_COMENTARIO;
                    $notificacion->fechaRegistro = date("Y-m-d H:i:s");


                    if (!$notificacion->save()) {

                        $items = [
                            'result' => 'error',
                            'response' => 'Error a notificar el comentario'
                        ];
                    }
                }

                // notificarle al resto de personas que comentaron.

                $otrosUsuarios = ContenidosComentarios::find()->select('idUsuarioComentario')->where(['and', ['!=', 'idUsuarioComentario', Yii::$app->user->identity->numeroDocumento], ['!=', 'idUsuarioComentario', $contenido->idUsuarioPublicacion]])
                                ->andWhere(['idContenido' => $comentario->idContenido])->distinct()->all();

                foreach ($otrosUsuarios as $otroUsuario) {
                    $notificacion = new Notificaciones();
                    $notificacion->idContenido = $comentario->idContenido;
                    $notificacion->idUsuarioDirige = Yii::$app->user->identity->numeroDocumento;
                    $notificacion->idUsuarioDirigido = $otroUsuario->idUsuarioComentario;
                    $notificacion->descripcion = "También comento una publicación";
                    $notificacion->estadoNotificacion = Notificaciones::ESTADO_CREADA;
                    $notificacion->tipoNotificacion = Notificaciones::NOTIFICACION_COMENTARIO;
                    $notificacion->fechaRegistro = date("Y-m-d H:i:s");


                    if (!$notificacion->save()) {

                        $items = [
                            'result' => 'error',
                            'response' => 'Error a notificar el comentario'
                        ];
                    }
                }

                $noticia = Contenido::traerNoticiaEspecifica($comentario->idContenido);
                $linea = LineaTiempo::find()->where(['idLineaTiempo' => $noticia->idLineaTiempo])->one();

                $items = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('/contenido/_contenido', ['noticia' => $noticia, 'linea' => $linea])
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
      accion para renderizar la vista organigrama
     */

    public function actionOrganigrama() {
        return $this->render('organigrama', []);
    }

    /**
     * accion para obtener el contenido del modal
     * @param none
     * @return html contenido modal
     */
    public function actionPopupContenido() {

        $db = Yii::$app->db;
        $userCiudad = Yii::$app->user->identity->getCodigoCiudad();
        $userGrupos = Yii::$app->user->identity->getGruposCodigos();
        $userNumeroDocumento = Yii::$app->user->identity->numeroDocumento;

        $query = $db->createCommand('select distinct c.idContenidoEmergente, c.contenido
                                      from  m_ContenidoEmergente as c
                                      inner join t_ContenidoEmergenteDestino as cd on c.idContenidoEmergente = cd.idContenidoEmergente
	                                    where (c.fechaInicio<=:fecha AND c.fechaFin >=:fecha AND c.estado =:estado and
                                      ((cd.idGrupoInteres IN(:userGrupos) and cd.codigoCiudad =:userCiudad) or (cd.idGrupoInteres =:todosGrupos and cd.codigoCiudad =:todosCiudad) or (cd.idGrupoInteres IN(:userGrupos) and cd.codigoCiudad =:todosCiudad) or (cd.idGrupoInteres =:todosGrupos and cd.codigoCiudad =:userCiudad)  )   )
                                      and c.idContenidoEmergente NOT IN( select idContenidoEmergente from t_Contenidoemergentevisto where numeroDocumento =' . $userNumeroDocumento . ' )  order by rand()')
                ->bindValue(':userCiudad', $userCiudad)
                ->bindValue(':userGrupos', implode(',', $userGrupos))
                ->bindValue(':fecha', date('Y-m-d H:i:s'))
                ->bindValue(':estado', 1)
                ->bindValue('todosCiudad', \Yii::$app->params['ciudad']['*'])
                ->bindValue('todosGrupos', \Yii::$app->params['grupo']['*'])
                ->queryOne();


        //echo var_dump($query);
        if ($query) {
            $items = [
                'result' => 'ok',
                'response' => $this->renderAjax('popup', ['query' => $query]),
            ];
        } else {
            $items = [
                'result' => 'ok',
                'response' => '',
            ];
        }



        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
    }

    public function actionInactivaPopup() {
        $idPopup = Yii::$app->request->post('idPopup');

        $modelContenido = ContenidoEmergente::findone(['idContenidoEmergente' => $idPopup]);
        $modelContenido->estado = 0;
        $items = [];
        if ($modelContenido->save()) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $items = [
                'result' => 'ok',
            ];
        }
        return $items;
    }

    public function actionQuitarElemento() {
        $elemento = Yii::$app->request->post('elemento');
        $opcion = Yii::$app->request->post('opcion');


        if ($opcion == 2) {
            $model = new UsuarioWidgetInactivo();
            $model->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
            $model->widget = $elemento;


            if ($model->save()) {
                $items = [
                    'result' => 'ok'
                ];
            } else {
                $items = [
                    'result' => 'error'
                ];
            }
        } else if ($opcion == 1) {

            UsuarioWidgetInactivo::deleteAll('widget = :widget AND widget = :widget', [':widget' => $elemento, ':numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
            $items = [
                'result' => 'ok'
            ];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
    }

}
