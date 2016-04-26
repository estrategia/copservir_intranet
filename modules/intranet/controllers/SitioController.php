<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
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
use app\modules\intranet\models\UsuarioWidgetInactivo;
use app\modules\intranet\models\LogContenidos;
use app\modules\intranet\models\PublicacionesCampanas;
use yii\helpers\Html;
use yii\web\Response;

class SitioController extends Controller {

    public function actionUrl() {
        echo Yii::getAlias('@app') . '@web/img/post';
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'cargar-imagen' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::getAlias('@web') . '/contenidos/imagenes/', //Yii::$app->realpath().'/imagenes', // Directory URL address, where files are stored.
                'path' => '@app/web/contenidos/imagenes/', // Or absolute path to directory where files are stored.
                'validatorOptions' => [
                    'maxWidth' => Yii::$app->params['contenido']['imagen']['ancho'],
                    'maxHeight' => Yii::$app->params['contenido']['imagen']['alto'],
                    'maxSize' => Yii::$app->params['contenido']['imagen']['tamanho']*1024*1024,
                    'extensions' => Yii::$app->params['contenido']['imagen']['formatosValidos']
                ]
            ],
            'cargar-archivo' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::getAlias('@web') . '/contenidos/archivos/',
                'path' => '@app/web/contenidos/archivos/',
                'uploadOnlyImage' => false,
                'validatorOptions' => [
                    'maxSize' => Yii::$app->params['contenido']['archivo']['tamanho']*1024*1024,
                    'extensions' => Yii::$app->params['contenido']['archivo']['formatosValidos']
                ]
            ]
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
        $lineasTiempo = LineaTiempo::find()->where(['estado' => 1])->andWhere("fechaInicio <= '$fecha' AND '$fecha' <= fechaFin")->orderBy('orden')->all();
        $indicadores = Indicadores::find()->all();

        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $userCiudad = Yii::$app->user->identity->getCiudadCodigo();
        $userGrupos = Yii::$app->user->identity->getGruposCodigos();

        //tareas
        $tareasUsuario = Tareas::getTareasIndex($numeroDocumento);

        //ofertas laborales
        $dataProviderOfertas = OfertasLaborales::getOfertasLaboralesInteres($userCiudad, $userGrupos);

        //banners
        $bannerArriba = PublicacionesCampanas::getCampana($userCiudad, $userGrupos, PublicacionesCampanas::POSICION_ARRIBA);
        $bannerAbajo = PublicacionesCampanas::getCampana($userCiudad, $userGrupos, PublicacionesCampanas::POSICION_ABAJO);
        $bannerDerecha = PublicacionesCampanas::getCampana($userCiudad, $userGrupos, PublicacionesCampanas::POSICION_DERECHA);

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

    public function actionImageUpload() {
        $message = "";


        $name = time() . "_" . $_FILES['file']['name'];
        // $url = Yii::getPathOfAlias('webroot') . Yii::app()->params->uploadContenidosUrl . $name;
        // http://192.168.0.35/copservir_intranet/imagenes/post/
        // 'path' => '@app/imagenes/post'
        $url = Yii::getAlias('@app') . '/web/img/post/' . $name;
        //extensive suitability check before doing anything with the file…
        if (($_FILES['file'] == "none") OR ( empty($_FILES['file']['name']))) {

            $result = [
                'error' => "No se ha cargado archivo."
            ];
        } else if ($_FILES['file']["size"] == 0) {

            $result = [
                'error' => "Archivo inválido: Tamaño no válido"
            ];
        }else if($_FILES['file']["size"] > Yii::$app->params['contenido']['imagen']['tamanho']*1024*1024) {
             $result = [
                'error' => ' El ancho máximo debe ser '.Yii::$app->params['contenido']['imagen']['tamanho']."MB"
            ];
        }
        else if (($_FILES['file']["type"] != "image/pjpeg") AND ( $_FILES['file']["type"] != "image/jpeg") AND ( $_FILES['file']["type"] != "image/png")) {

            $result = [
                'error' => "El formato de la imagen debe de ser JPG or PNG. Por favor cargar archivo JPG or PNG."
            ];
        } else if (!is_uploaded_file($_FILES['file']["tmp_name"])) {
            $result = [
                'error' => "Solicitud inválida."
            ];
            //$message = "You may be attempting to hack our server. We're on to you; expect a knock on the door sometime soon.";
        } else {
            $message = "";

            $tamanhos = getimagesize($_FILES['file']["tmp_name"]);

            if ($tamanhos[0] > Yii::$app->params['contenido']['imagen']['ancho']) {
                $result = [
                        'error' => 'El ancho máximo debe ser '.Yii::$app->params['contenido']['imagen']['ancho']."px"
                    ];
            } else if ($tamanhos[1] > Yii::$app->params['contenido']['imagen']['largo']) {
                $result = [
                        'error' => 'El largo máximo debe ser '.Yii::$app->params['contenido']['imagen']['largo']."px"
                    ];
            } else {

                $move = move_uploaded_file($_FILES['file']['tmp_name'], $url);
                if (!$move) {
                    $message = "Error al cargar el archivo."; //$message = "Error moving uploaded file. Check the script is granted Read/Write/Modify permissions.";
                    $result = [
                        'error' => $message
                    ];
                } else {
                    $url = Yii::$app->homeUrl . 'img/post/' . $name;
                    $result = ['filelink' => $url];
                }
            }
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        return $result;
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
            $contenido->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
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
                    $logContenido->numeroDocumento = $contenido->numeroDocumentoPublicacion;

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
                $nuevodato->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
                $nuevodato->idMenu = $post['idMenu'];
                $nuevodato->save();
            } else {// eliminar la opcion
                UsuariosOpcionesFavoritos::deleteAll('idMenu = :idMenu AND numeroDocumento = :idUsuario', [':idMenu' => $post['idMenu'], ':idUsuario' => Yii::$app->user->identity->numeroDocumento]);
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
                    if (Yii::$app->user->identity->numeroDocumento != $contenido->numeroDocumentoPublicacion) {
                        $notificacion = new Notificaciones();
                        $notificacion->idContenido = $meGusta->idContenido;
                        $notificacion->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
                        $notificacion->numeroDocumentoDirigido = $contenido->numeroDocumentoPublicacion;
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
            $comentario->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
            $comentario->fechaComentario = date("Y-m-d H:i:s");
            $comentario->fechaActualizacion = $comentario->fechaComentario;
            $comentario->estado = 1;

            if ($comentario->save()) {
                $contenido = Contenido::find()->where(['idContenido' => $comentario->idContenido])->one();

                if (Yii::$app->user->identity->numeroDocumento != $contenido->numeroDocumentoPublicacion) {
                    $notificacion = new Notificaciones();
                    $notificacion->idContenido = $comentario->idContenido;
                    $notificacion->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
                    $notificacion->numeroDocumentoDirigido = $contenido->numeroDocumentoPublicacion;
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

                $otrosUsuarios = ContenidosComentarios::find()->select('numeroDocumento')->where(['and', ['!=', 'numeroDocumento', Yii::$app->user->identity->numeroDocumento], ['!=', 'numeroDocumento', $contenido->numeroDocumentoPublicacion]])
                                ->andWhere(['idContenido' => $comentario->idContenido])->distinct()->all();

                foreach ($otrosUsuarios as $otroUsuario) {
                    $notificacion = new Notificaciones();
                    $notificacion->idContenido = $comentario->idContenido;
                    $notificacion->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
                    $notificacion->numeroDocumentoDirigido = $otroUsuario->numeroDocumento;
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
