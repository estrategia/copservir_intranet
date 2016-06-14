<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use \app\modules\intranet\models\LineaTiempo;
use \app\modules\intranet\models\Contenido;
use \app\modules\intranet\models\MeGustaContenidos;
use \app\modules\intranet\models\ContenidosComentarios;
use \app\modules\intranet\models\DenunciosContenidos;
use app\modules\intranet\models\DenunciosContenidosComentarios;
use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\ContenidoRecomendacion;
use app\modules\intranet\models\Notificaciones;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

class ContenidoController extends Controller {

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'listado-me-gusta-contenido', 'listado-comentarios-contenido', 'denunciar-contenido', 'guardar-denuncio-contenido',
                    'eliminar-comentario', 'denunciar-comentario', 'guardar-denuncio-comentario', 'detalle-contenido', 'agregar-destino',
                    'noticias', 'mis-publicaciones', 'buscador-noticias', 'busqueda', 'enviar-amigo', 'listar-contenidos-pendientes',
                    'detalle-aprobacion', 'eliminar-contenido', 'listar-contenidos-denunciados', 'detalle-denuncio', 'eliminar-contenido-denunciado',
                    'listar-comentarios-denunciados', 'detalle-comentario-denuncio', 'eliminar-comentario-denunciado',
                ],
            ],
        ];
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
                    'maxSize' => Yii::$app->params['contenido']['imagen']['tamanho'] * 1024 * 1024,
                    'extensions' => Yii::$app->params['contenido']['imagen']['formatosValidos']
                ]
            ],
            'cargar-archivo' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::getAlias('@web') . '/contenidos/archivos/',
                'path' => '@app/web/contenidos/archivos/',
                'uploadOnlyImage' => false,
                'validatorOptions' => [
                    'maxSize' => Yii::$app->params['contenido']['archivo']['tamanho'] * 1024 * 1024,
                    'extensions' => Yii::$app->params['contenido']['archivo']['formatosValidos']
                ]
            ]
        ];
    }

    public function actionListadoMeGustaContenido() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idContenido = $request->post('idContenido');

            $usuariosMeGusta = MeGustaContenidos::find()->with('objUsuario')->where(['idContenido' => $idContenido])->all();

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderPartial('_modalMeGusta', ['usuariosMeGusta' => $usuariosMeGusta])
            ];
        } else {

        }
    }

    public function actionListadoComentariosContenido() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idContenido = $request->post('idContenido');

            $comentariosContenido = ContenidosComentarios::find()->with('objUsuarioPublicacionComentario', 'objDenuncioComentarioUsuario')->where(['idContenido' => $idContenido, 'estado' => ContenidosComentarios::ESTADO_ACTIVO])->all();

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderPartial('_modalComentarios', ['comentariosContenido' => $comentariosContenido])
            ];
        } else {

        }
    }

    public function actionDenunciarContenido() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        if ($render) {
            $idContenido = $request->post('idContenido');
            $idLinea = $request->post('idLineaTiempo');

            $modelDenuncio = new DenunciosContenidos();
            $modelDenuncio->idContenido = $idContenido;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderPartial('_modalDenuncio', ['modelDenuncio' => $modelDenuncio, 'idLineaTiempo' => $idLinea])
            ];
        }
    }

    public function actionGuardarDenuncioContenido() {

        $request = \Yii::$app->request;

        $idLineaTiempo = $request->post('idLineaTiempo');
        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $idLineaTiempo])->one();
        $noticias = Contenido::traerNoticias($idLineaTiempo);

        $modelDenuncio = new DenunciosContenidos();

        if ($modelDenuncio->load($request->post())) {
            $modelDenuncio->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
            $modelDenuncio->fechaRegistro = Date("Y-m-d H:i:s");
            $modelDenuncio->fechaActualizacion = Date("Y-m-d H:i:s");
            $modelDenuncio->estado = DenunciosContenidos::PENDIENTE_APROBACION;

            if ($modelDenuncio->save()) {
              $contenidoModel = new Contenido();
              \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
              return [
                  'result' => 'ok',
                  'response' => $this->renderAjax('/sitio/_lineaTiempo', [
                      'linea' => $linea,
                      'contenidoModel' => $contenidoModel,
                      'noticias' => $noticias
                          ]
                  )
              ];
            }else{
              $contenido = Contenido::find()->where(['idContenido' => $modelDenuncio->idContenido])->one();
              if (empty($contenido)) {
                  $respond = [
                      'result' => 'error',
                      'response' => $this->renderAjax('_modalDenuncio', ['modelDenuncio' => $modelDenuncio, 'idLineaTiempo' => $idLineaTiempo]),
                      'error' => 'El contenido ya no existe'
                  ];
              } else {
                  $respond = [
                      'result' => 'error',
                      'response' => $this->renderAjax('_modalDenuncio', ['modelDenuncio' => $modelDenuncio, 'idLineaTiempo' => $idLineaTiempo]),
                      //'error' => 'Error al guardar el comentario'//. json_encode($modelDenuncio->getErrors())
                  ];
              }

              \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
              return $respond;
            }
        }
    }

    public function actionEliminarComentario() {
        $request = \Yii::$app->request;
        $idComentario = $request->post('idComentario');
        $contenido = ContenidosComentarios::find()->where(['idContenidoComentario' => $idComentario])->one();
        $idContenido = $contenido->idContenido;
        $contenido->estado = ContenidosComentarios::ESTADO_ELIMINADO;
        if ($contenido->save()) {
            $comentariosContenido = ContenidosComentarios::find()->with('objUsuarioPublicacionComentario', 'objDenuncioComentarioUsuario')->where(['idContenido' => $idContenido, 'estado' => ContenidosComentarios::ESTADO_ACTIVO])->all();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'result' => 'ok',
                'response' => $this->renderPartial('_listadoComentarios', ['comentariosContenido' => $comentariosContenido]),
                'numeroComentarios' => Html::a(count($comentariosContenido) . " <span class='glyphicon glyphicon-comment' aria-hidden='true'></span>", '#', [
                    'id' => 'numeroComentarios',
                    'data-role' => 'listado-comentarios-contenido',
                    'data-contenido' => $idContenido,
                    'onclick' => 'return false',
                    'style' => 'color:white;'
                ]),
                'idContenido' => $idContenido,
            ];
        };
    }

    public function actionDenunciarComentario() {
        $request = \Yii::$app->request;

        $idComentario = $request->post('idComentario');

        $modelDenuncio = new DenunciosContenidosComentarios();
        $modelDenuncio->idContenidoComentario = $idComentario;
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'result' => 'ok',
            'response' => $this->renderPartial('_modalDenuncioComentario', ['modelDenuncio' => $modelDenuncio])
        ];
    }

    public function actionGuardarDenuncioComentario() {
        $request = \Yii::$app->request;
        $render = $request->post('render', false);

        $modelDenuncio = new DenunciosContenidosComentarios();
        $modelDenuncio->load($request->post());
        $modelDenuncio->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $modelDenuncio->fechaRegistro = Date("Y-m-d H:i:s");

        if ($modelDenuncio->save()) {

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            return [
                'result' => 'ok',
                'response' => ''
            ];
        } else {

            $contenido = ContenidosComentarios::find()->where(['idContenidoComentario' => $modelDenuncio->idContenidoComentario])->one();
            if (empty($contenido)) {
                $respond = [
                    'result' => 'error',
                    'response' => 'El contenido ya no existe'
                ];
            } else {
                $respond = [
                    'result' => 'error',
                    'response' => 'Error al guardar el denuncio'
                ];
            }

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $respond;
        }
    }

    public function actionDetalleContenido($idNoticia) {
        $objNoticia = Contenido::find()->joinWith(['objLineaTiempo'])->where("t_Contenido.idContenido=:noticia")->addParams([':noticia' => $idNoticia])->one();

        if ($objNoticia === null) {
            throw new HttpException(404, 'Contenido no existente');
        }

        //$objNoticia = Contenido::findOne(['idContenido' => $idNoticia])->joinWith('objLineaTiempo');
        return $this->render('detalle', ['noticia' => $objNoticia, 'linea' => $objNoticia->objLineaTiempo]);
    }

    public function actionAgregarDestino() {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return [
            'result' => 'ok',
            'response' => $this->renderAjax('_formDestinoContenido', ['objContenidoDestino' => new ContenidoDestino])
        ];
    }

    public function actionNoticias($lineaTiempo) {


        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();

        $dataProvider = new ActiveDataProvider([
            'query' => Contenido::traerTodasNoticiasCopservir($lineaTiempo),
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        $this->view->title = 'Noticias';
        return $this->render('publicaciones', ['listDataProvider' => $dataProvider,]);
    }

    public function actionMisPublicaciones() {
        $dataProvider = new ActiveDataProvider([
            'query' => Contenido::traerMisPublicaciones(),
            'pagination' => [
                'pageSize' => 4,
            ],
        ]);

        $this->view->title = 'Mis Publicaciones';
        return $this->render('publicaciones', ['listDataProvider' => $dataProvider]);
    }

    /**
     * buscardor de noticias
     * @param post-> busqueda  | lo que el usuario escribe en la barra de busqueda
     * @return mixed | redirige a la vista donde se hara la busuqeda pasando como parametros de la url:
     * busqueda = el patron de busqueda, a = año, m = mes, d = dia
     */
    public function actionBuscadorNoticias() {
        $busqueda = trim(Yii::$app->request->post('busqueda', ''));
        $this->redirect(['busqueda', 'busqueda' => $busqueda, 'a' => '', 'm' => '', 'd' => '']);
    }

    /**
     * buscardor de noticias
     * @param busqueda = el patron de busqueda, a = año, m = mes, d = dia
     * @return mixed | retorna la vista con las noticias encontradas
     */
    public function actionBusqueda($busqueda, $a, $m, $d) {

        $flag = '';  // indica si la url lleva año, mes y dia
        $url = ['url' => '', 'urlJson' => '']; // arreglo con la url para generar la imagen en google charts y url para devolver el json de la misma
        $resultados = ''; // noticias encontradas
        $valorGrafica = ''; // valores que tomara la grafica (etiuetas y cantidad de veces que se encuentra una noticia)

        if (empty($a) and empty($m) and empty($d)) {


            $resultados = Contenido::traerBusqueda($busqueda);
            $valorGrafica = Contenido::datosGraficaAnio($busqueda);
            $url = $this->makeUrlChart($valorGrafica, false);
            $valorGrafica = Json::encode($valorGrafica);
            $flag = 'a';
        }

        if (!empty($a) and empty($m) and empty($d)) {

            $resultados = Contenido::traerBusquedaAnio($busqueda, $a);
            $valorGrafica = Contenido::datosGraficaMes($busqueda, $a);
            $url = $this->makeUrlChart($valorGrafica, true);
            $valorGrafica = Json::encode($valorGrafica);
            $flag = 'am';
        }

        if (!empty($a) and ! empty($m) and empty($d)) {

            $resultados = Contenido::traerBusquedaMes($busqueda, $a, $m);
            $valorGrafica = Contenido::datosGraficaDia($busqueda, $a, $m);
            $url = $this->makeUrlChart($valorGrafica, false);
            $valorGrafica = Json::encode($valorGrafica);
            $flag = 'amd';
        }

        if (!empty($a) and ! empty($m) and ! empty($d)) {
            $resultados = Contenido::traerBusquedaDia($busqueda, $a, $m, $d);
        }

        return $this->render('busqueda', ['resultados' => $resultados, 'url' => $url, 'flag' => $flag, 'valorGrafica' => $valorGrafica, 'patron' => $busqueda]);
    }

    /**
     * funcion auxiliar para crear la url para generar la imagen y su json para mapearla
     * @param valorGrafica = valores que tomara la grafica, flag = bandera para poner el nombe de los meses
     * @return arreglo con las dos urls
     */
    public function makeUrlChart($valorGrafica, $flag) {
        /*
          > chof = - para mapear => json

          > cht = tipo de gafico

          > chs = tamaño del grafico

          > chxt = que solo se manejara el eje x

          > chm = forma que se le da al valor del dato

          > chd = serie de datos para el grafico

          > chds = limites minimos y maximos de cada serie

          > chxl = etiquetas
         */


        $url = 'https://chart.googleapis.com/chart?cht=s&amp;chs=908x70&amp;chxt=x&amp;chm=o,0aa699,0,0,20.0,0&amp;';
        $urlJson = '"https://chart.googleapis.com/chart?chof=json&cht=s&chs=908x70&chxt=x&chm=o,0aa699,0,0,20.0,0&';
        $chd = 'chd=t:';
        $chxl = 'chxl=0:||';

        // se pegan las posiciones de la grafica
        for ($i = 0; $i <= count($valorGrafica); $i++) {
            $chd .= $i . ',';
        }
        // se separa la serie
        $chd = substr($chd, 0, -1);
        $chd .= '|';


        // se pegan las posiciones en y
        for ($i = 0; $i <= count($valorGrafica); $i++) {
            $chd .= 20 . ',';
        }

        // se separa la serie
        $chd = substr($chd, 0, -1);
        $chd .= '|0,';

        $maximo = array();
        // se pegan las cantidades de veces que se repite la noticia y sus etiquetas
        foreach ($valorGrafica as $valor) {
            $chd .= $valor['cantidad'] . ',';
            if ($flag) {
                $chxl .= \Yii::$app->params['calendario']['meses'][$valor['etiqueta']] . '|';
            } else {
                $chxl .= $valor['etiqueta'] . '|';
            }

            array_push($maximo, $valor['cantidad']);
        }
        if (!empty($valorGrafica)) {
            $maximo = max($maximo);
        } else {
            $maximo = 0;
        }


        $chd = substr($chd, 0, -1);

        // se defienen los limites
        $chds = 'chds=0,' . (count($valorGrafica) + 1) . ',0,40,0,' . $maximo;

        // se crea toda la url
        $url .= $chd . '&amp;';
        $urlJson .= $chd . '&';
        $url .= $chxl . '&amp;';
        $urlJson .= $chxl . '&';
        $url .= $chds;
        $urlJson .= $chds;
        $urlJson .= '"';

        return ['url' => $url, 'urlJson' => $urlJson];
    }

    /**
     * accion donde el usuario envia una publicacion a un amigo
     * @param post = los usuarios que selecciono para enviar la publicación
     * @return respond = []
     *         respond.result = indica si todo se realizo bien o mal
     */
    public function actionEnviarAmigo() {
        $listaAmigos = Yii::$app->request->post('enviaAmigo', []);
        $clasificado = Yii::$app->request->post('clasificado', '');
        $respond = [];

        if ($listaAmigos != [] and $clasificado != '') {

            $transaction = ContenidoRecomendacion::getDb()->beginTransaction();
            try {
                foreach ($listaAmigos as $idUsuarioEnviado) {
                    $contenidoRecomendacion = new ContenidoRecomendacion();
                    $contenidoRecomendacion->idContenido = $clasificado;
                    $contenidoRecomendacion->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
                    $contenidoRecomendacion->numeroDocumentoDirigido = $idUsuarioEnviado;
                    $contenidoRecomendacion->fechaRegistro = Date("Y-m-d H:i:s");

                    if ($contenidoRecomendacion->save()) {
                        $transaction->commit();
                        $this->generarNotificacionClasificadoRecomendado($idUsuarioEnviado, $clasificado);
                        $respond = [
                            'result' => 'ok',
                        ];
                    };
                }
            } catch (\Exception $e) {

                $transaction->rollBack();
                $respond = [
                    'result' => 'error',
                ];
                throw $e;
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $respond;
        }
    }

    /**
     * @param idUsuarioEnviado, idClasificado
     */
    public function generarNotificacionClasificadoRecomendado($idUsuarioEnviado, $idClasificado) {
        $notificacion = new Notificaciones();
        $notificacion->idContenido = $idClasificado;
        $notificacion->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
        $notificacion->numeroDocumentoDirigido = $idUsuarioEnviado;
        $notificacion->descripcion = 'recomienda un clasificado';
        $notificacion->estadoNotificacion = Notificaciones::ESTADO_CREADA;
        $notificacion->fechaRegistro = Date("Y-m-d H:i:s");
        $notificacion->tipoNotificacion = Notificaciones::NOTIFICACION_RECOMENDACION;

        if (!$notificacion->save()) {
            throw new Exception("Error no se genero la notificacion:" . yii\helpers\Json::enconde($notificacion->getErrors()), 100);
        };
    }

    /**
     * Muestra los modelos Contenido que estan pendientes de aprobacion
     * @return mixed
     */
    public function actionListarContenidosPendientes() {
        $dataProvider = Contenido::getContenidosPendientesAprobacion();
        return $this->render('aprobarContenidos', ['dataProvider' => $dataProvider]);
    }

    /**
     * Muestra el detalle de un modelo Contenido que esta pendiente de aprobacion
     * y cambia el estado del modelo por aprobado
     * @param $id = identificador del contenido
     * @return mixed
     */
    public function actionDetalleAprobacion($id) {
        $model = Contenido::getContenidoDetalleAprobacion($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['listar-contenidos-pendientes']);
        }

        return $this->render('detalleAprobacion', ['model' => $model]);
    }

    /**
     * cambia el estado del modelo Contenido a eliminado
     * @param $id = identificador del contenido
     * @return mixed
     */
    public function actionEliminarContenido($id) {
        $model = Contenido::getContenidoDetalleAprobacion($id);
        $model->estado = Contenido::ELIMINADO;

        if ($model->save()) {
            return $this->redirect(['listar-contenidos-pendientes']);
        } else {
            //error
        }
    }

    /**
     * Muestra los modelos Contenido que han sido denunciados
     * @return mixed
     */
    public function actionListarContenidosDenunciados() {
        $dataProvider = Contenido::getContenidosDenunciados();
        return $this->render('contenidosDenunciados', ['dataProvider' => $dataProvider]);
    }

    /**
     * Muestra el detalle de un modelo Contenido que ha sido denunciado
     * y cambia el estado del modelo DenunciosContenidos por aprobado
     * @param $id = identificador del contenido
     * @return mixed
     */
    public function actionDetalleDenuncio($id) {
        $modelContenido = Contenido::getContenidoDetalleDenuncio($id);
        $modelDenunciosContenidos = DenunciosContenidos::findOne(['idDenuncioContenido' => $modelContenido->objDenunciosContenidos->idDenuncioContenido]);

        if ($modelDenunciosContenidos->load(Yii::$app->request->post()) && $modelDenunciosContenidos->save()) {
            return $this->redirect(['listar-contenidos-denunciados']);
        }

        return $this->render('detalleDenuncio', ['model' => $modelContenido]);
    }

    /**
     * cambia el estado de los modelos DenunciosContenidos y Contenido a eliminado
     * @param $id = identificador del DenunciosContenidos
     * @return mixed
     */
    public function actionEliminarContenidoDenunciado($id) {
        $modelDenunciosContenidos = DenunciosContenidos::findOne(['idDenuncioContenido' => $id]);
        $transaction = DenunciosContenidos::getDb()->beginTransaction();
        try {
            $modelDenunciosContenidos->estado = DenunciosContenidos::ELIMINADO;
            $modelDenunciosContenidos->fechaActualizacion = Date("Y-m-d H:i:s");

            if ($modelDenunciosContenidos->save()) {
                $modelContenido = Contenido::getContenidoDetalleDenuncio($modelDenunciosContenidos->idContenido);
                $modelContenido->saveEstadoEliminado();

                $transaction->commit();

                return $this->redirect(['listar-contenidos-denunciados']);
            }
        } catch (\Exception $e) {

            $transaction->rollBack();
            throw $e;
            return $this->render('detalleDenuncio', ['model' => $modelContenido]);
        }
    }

    /**
     * Muestra los modelos ContenidosComentarios que han sido denunciados
     * @return mixed
     */
    public function actionListarComentariosDenunciados() {
        $dataProvider = ContenidosComentarios::getComentariosDenunciadosPendientes();
        return $this->render('comentariosDenunciados', ['dataProvider' => $dataProvider]);
    }

    /**
     * Muestra el detalle de un modelo ContenidosComentarios que ha sido denunciado
     * con opcion para cambiar el estado del modelo por aprobado
     * @param $id = identificador del ContenidosComentarios
     * @return mixed
     */
    public function actionDetalleComentarioDenuncio($id) {
        $modelComentario = ContenidosComentarios::getComentarioDenunciadoDetalle($id);
        $modelDenuncioComentario = DenunciosContenidosComentarios::findOne(['idDenuncioComentario' => $modelComentario->objDenuncioComentario->idDenuncioComentario]);

        if ($modelDenuncioComentario->load(Yii::$app->request->post()) && $modelDenuncioComentario->save()) {
            return $this->redirect(['listar-comentarios-denunciados']);
        }

        return $this->render('detalleComentarioDenuncio', ['model' => $modelComentario]);
    }

    /**
     * cambia el estado de un modelo DenunciosContenidosComentarios a eliminado al igual que al modelo ContenidosComentarios
     * @param $id = identificador del DenunciosContenidosComentarios
     * @return mixed
     */
    public function actionEliminarComentarioDenunciado($id) {
        $modelDenuncioComentario = DenunciosContenidosComentarios::findOne(['idDenuncioComentario' => $id]);

        $transaction = DenunciosContenidosComentarios::getDb()->beginTransaction();
        try {
            $modelDenuncioComentario->estado = DenunciosContenidosComentarios::ELIMINADO;
            $modelDenuncioComentario->fechaActualizacion = Date("Y-m-d H:i:s");

            if ($modelDenuncioComentario->save()) {
                $modelComentario = ContenidosComentarios::getComentarioDenunciadoDetalle($modelDenuncioComentario->idContenidoComentario);
                $modelComentario->saveEstadoEliminado();

                $transaction->commit();

                return $this->redirect(['listar-comentarios-denunciados']);
            }
        } catch (\Exception $e) {

            $transaction->rollBack();
            throw $e;
            return $this->render('detalleComentarioDenuncio', ['model' => $modelComentario]);
        }
    }

}
