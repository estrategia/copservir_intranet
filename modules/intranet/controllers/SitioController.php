<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use app\modules\intranet\models\Contenido;
use app\modules\intranet\models\ContenidoAdjunto;
use app\modules\intranet\models\ContenidoSearch;
use app\modules\intranet\models\LineaTiempo;
use app\modules\intranet\models\UsuariosMenuInactivo;
use app\modules\intranet\models\MeGustaContenidos;
use app\modules\intranet\models\ContenidosComentarios;
use app\modules\intranet\models\Indicadores;
use app\modules\intranet\models\OfertasLaborales;
use app\modules\intranet\models\Notificaciones;
use app\modules\intranet\models\Tareas;
use app\modules\intranet\models\ContenidoDestino;
use app\modules\intranet\models\ContenidoEmergente;
use app\modules\intranet\models\ContenidoRecomendacion;
use app\modules\intranet\models\UsuarioWidgetInactivo;
use app\modules\intranet\models\LogContenidos;
use app\modules\intranet\models\PublicacionesCampanas;
use app\modules\intranet\models\CumpleanosLaboral;
use app\modules\intranet\models\CumpleanosPersona;
use app\modules\intranet\models\Menu;
use app\modules\intranet\models\OpcionesUsuario;
use app\modules\intranet\models\Opcion;
use app\modules\intranet\models\ContenidoPortal;
use app\models\Usuario;//use app\modules\intranet\models\Usuario;
use app\modules\intranet\models\AuthAssignment;
use yii\helpers\Html;
use yii\web\Response;
use yii\data\Pagination;
use yii\widgets\ActiveForm;

//Nuevos Modelos - By JPolanco
use app\modules\intranet\models\CalificacionCaritas;

use yii\web\UploadedFile;

class SitioController extends \app\controllers\CController {

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                     'publicar-portales', 'publicar-portales-crear', 'publicar-portales-actualizar', 'administrar-menu','guardar-contenido-portal',
                     'borrar-imagen', 'agregar-opcion-menu', 'render-crear-opcion-menu', 'render-editar-opcion-menu', 'crear-opcion-menu',
                     'actualizar-opcion-menu', 'eliminar-enlace-menu', 'render-agregar-enlace', 'render-editar-enlace', 'guardar-opcion-menu',
                     'guardar-edita-opcion',
                     'index', 'cambiar-linea-tiempo', 'guardar-contenido', 'menu', 'me-gusta-contenido', 'guardar-comentario', 'organigrama',
                     'quitar-elemento', 'todos-cumpleanos', 'todos-aniversarios', 'felicitar-aniversario', 'felicitar-cumpleanos', 'iconos'
                 ],
                 'authsActions' => [
                     'publicar-portales' => 'intranet_sitio_publicar-portales',
                     'publicar-portales-crear' => 'intranet_sitio_publicar-portales',
                     'publicar-portales-actualizar' => 'intranet_sitio_publicar-portales',
                     'guardar-contenido-portal' => 'intranet_sitio_publicar-portales',
                     'borrar-imagen' => 'intranet_sitio_publicar-portales',


                     'administrar-menu' => 'intranet_sitio_administrar-menu',
                     'agregar-opcion-menu' => 'intranet_usuario',
                     'render-crear-opcion-menu' => 'intranet_sitio_administrar-menu',
                     'render-editar-opcion-menu' => 'intranet_sitio_administrar-menu',
                     'crear-opcion-menu' => 'intranet_sitio_administrar-menu',
                     'actualizar-opcion-menu' => 'intranet_sitio_administrar-menu',
                     'eliminar-enlace-menu' => 'intranet_sitio_administrar-menu',
                     'render-agregar-enlace' => 'intranet_sitio_administrar-menu',
                     'render-editar-enlace' => 'intranet_sitio_administrar-menu',
                     'guardar-opcion-menu' => 'intranet_sitio_administrar-menu',
                     'guardar-edita-opcion' => 'intranet_sitio_administrar-menu',

                     'iconos' => 'intranet_sitio_iconos',

                     'index' => 'intranet_usuario',
                     'cambiar-linea-tiempo' => 'intranet_usuario',
                     'guardar-contenido' => 'intranet_usuario',
                     'menu' => 'intranet_usuario',
                     'me-gusta-contenido' => 'intranet_usuario',
                     'guardar-comentario' => 'intranet_usuario',
                     'organigrama' => 'intranet_usuario',
                     'quitar-elemento' => 'intranet_usuario',
                     'todos-cumpleanos' => 'intranet_usuario',
                     'todos-aniversarios' => 'intranet_usuario',
                     'felicitar-aniversario' => 'intranet_usuario',
                     'felicitar-cumpleanos' => 'intranet_usuario'
                 ]
             ],
        ];
    }

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
        $fecha = date("Y-m-d H:i:s");
        $contenidoModel = new Contenido();
        $lineasTiempo = LineaTiempo::find()->where(['estado' => 1])->andWhere("fechaInicio <= '$fecha' AND '$fecha' <= fechaFin")->orderBy('orden')->all();
        $indicadores = Indicadores::find()->where(['estado'=>1])->all();

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
		$bannerArribaTwo = array();
		$bannerArribaTwo[0] = array('idImagenCampana'=>'20', 'rutaImagen'=>'banner_capsulitas_20160816.png', 'urlEnlaceNoticia'=>'');
		$bannerArribaTwo[1] = array('idImagenCampana'=>'21', 'rutaImagen'=>'1470070086_16929837.jpg', 'urlEnlaceNoticia'=>'/intranet/sitio/contenido?modulo=108');

        //cumpleaños y aniversarios
        $cumpleanos = CumpleanosPersona::getCumpleanosIndex();
        $aniversarios = CumpleanosLaboral::getAniversariosIndex();
		
		//calificacion caritas
		//$calificacionCaritas = Yii::$app->db2->createCommand("SELECT * FROM t_calificacionDomicilios")->queryOne();
		//$calificacionCaritas = Yii::$app->db2->createCommand("SELECT count(*) AS cantidad FROM t_calificacionDomicilios WHERE TipoCompra=1 and ExperienciaCalificacion='excelente' and TipoCompra = 1 and HoraRegistro >= '2016-06-01 00:00:00' and HoraRegistro <= '2016-06-30 23:59:59'")->queryOne();
		
		//Obtner mes y ultimo dia del mes
		$m = date("m");
		$y = date("Y");
		$mes = mktime( 0, 0, 0, $m, 1, $y ); 
		$numeroDeDiasMes = intval(date("t",$mes));
			
		//calificacion la rebaja virtual
		$a2= CalificacionCaritas::operacionLrv("excelente",5,$m,$numeroDeDiasMes);
		$b2= CalificacionCaritas::operacionLrv("bueno",4.5,$m,$numeroDeDiasMes);
		$c2= CalificacionCaritas::operacionLrv("regular",3.9,$m,$numeroDeDiasMes);
		$d2= CalificacionCaritas::operacionLrv("malo",3,$m,$numeroDeDiasMes);

        return $this->render('index', [
                    'contenidoModel' => $contenidoModel,
                    'lineasTiempo' => $lineasTiempo,
                    'indicadores' => $indicadores,
                    'ofertasLaborales' => $dataProviderOfertas,
                    'tareasUsuario' => $tareasUsuario,
                    'bannerArriba' => $bannerArriba,
                    'bannerAbajo' => $bannerAbajo,
                    'bannerDerecha' => $bannerDerecha,
                    'cumpleanos' => $cumpleanos,
                    'aniversarios' => $aniversarios,
					'bannerArribaTwo' => $bannerArribaTwo,
					'a2' => $a2, 
					'b2' => $b2, 
					'c2' => $c2, 
					'd2' => $d2, 					
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
        } else if ($_FILES['file']["size"] > Yii::$app->params['contenido']['imagen']['tamanho'] * 1024 * 1024) {
            $result = [
                'error' => ' El ancho máximo debe ser ' . Yii::$app->params['contenido']['imagen']['tamanho'] . "MB"
            ];
        } else if (($_FILES['file']["type"] != "image/pjpeg") AND ( $_FILES['file']["type"] != "image/jpeg") AND ( $_FILES['file']["type"] != "image/png")) {

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
                    'error' => 'El ancho máximo debe ser ' . Yii::$app->params['contenido']['imagen']['ancho'] . "px"
                ];
            } else if ($tamanhos[1] > Yii::$app->params['contenido']['imagen']['largo']) {
                $result = [
                    'error' => 'El largo máximo debe ser ' . Yii::$app->params['contenido']['imagen']['largo'] . "px"
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
        $contenidoModel = new Contenido();
        $noticias = Contenido::traerNoticias($lineaTiempo);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('_lineaTiempo', [
                'linea' => $linea,
                'contenidoModel' => $contenidoModel,
                'noticias' => $noticias
                    ]
        )];
        return $respond;
    }

    public function actionCambiarCiudadVisualizacion()
    {
      $ciudad = Yii::$app->request->post('codigoCiudad');
      Yii::$app->user->identity->setCiudadVisualizacion($ciudad);

      $response = [
        'result' => Yii::$app->user->identity->getCiudadCodigo()
      ];

      return json_encode($response);
    }

    /*
      accion para guardar un contenido en alguna linea de tiempos
     */

    public function actionGuardarContenido() {
        $contenido = new Contenido();
        $respond = [];

        if ($contenido->load(Yii::$app->request->post())) {

            $lineaTiempo = LineaTiempo::findOne($contenido->idLineaTiempo);
            $contenidodestino = Yii::$app->request->post('ContenidoDestino');

            if ($lineaTiempo->solicitarGrupoObjetivo==1 && empty($contenidodestino['codigoCiudad']) && empty($contenidodestino['idGrupoInteres'])) {
                $respond = [
                    'result' => 'error',
                    'error' => 'Ciudad y grupos de interes no pueden estar vacios'
                ];
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $respond;
                exit();
              }

            $transaction = Contenido::getDb()->beginTransaction();

            try {
                $contenido->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
                $contenido->fechaPublicacion = $contenido->fechaActualizacion = date("Y-m-d H:i:s");
                if (!empty($_FILES['imagenes'])) {
                    $contenido->imagenes = $_FILES['imagenes'];
                }

                $contenido->setEstadoDependiendoAprobacion($lineaTiempo);

                if ($contenido->save()) {
                    $contenido->guardarImagenes();
                    $solicitarGrupo = Yii::$app->request->post('SolicitarGrupoObjetivo');

                    if ($solicitarGrupo == 1) {
                        $contenido->guardarContenidoDestino($contenidodestino);
                    } else {
                      $contenido->guardarContenidoDestinoTodos();
                    }

                    $transaction->commit();
                    $contenidoModel = new Contenido();
                    $respond = [
                        'result' => 'ok',
                        'response' => $this->renderAjax('_lineaTiempo', [
                            'contenidoModel' => $contenidoModel,
                            'linea' => $lineaTiempo,
                            'noticias' => Contenido::traerNoticias($contenido->idLineaTiempo)
                    ])];
                }else {

                    $respond = [
                        'result' => 'ok',
                        'response' => $this->renderAjax('_lineaTiempo', [
                            'contenidoModel' => $contenido,
                            'linea' => $lineaTiempo,
                            'noticias' => Contenido::traerNoticias($contenido->idLineaTiempo)
                    ])];
                }
            } catch (\Exception $e) {
                $transaction->rollBack();
                $respond = [
                    'result' => 'error',
                    'error' =>  $e->getMessage(),
                    ];

                throw $e;
            }
        } else {
            $respond = [
                'result' => 'error',
                'error' => 'Error al cargar el contenido'
            ];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    public function actionPublicarPortales()
    {
      $searchModel = new ContenidoSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('/contenido/publicar-portales', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider
      ]);
    }

    public function actionPublicarPortalesCrear() {

      if (!Yii::$app->user->identity->tienePermiso('intranet_sitio_publicar-portales')) {
        throw new \yii\web\ForbiddenHttpException('Acceso no permitdo.',403);
      }

      $esAdmin = true;
      /*if (Yii::$app->user->identity->tienePermiso('intranet_admin')) {
        $esAdmin = true;
      }*/

      $contenidoModel = new Contenido;
      $contenidoModel->scenario = Contenido::SCENARIO_PUBLICAR_PORTALES;
      $contenidodestino = Yii::$app->request->post('ContenidoDestino');

      if ($contenidoModel->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) {

          if (!empty($_FILES['imagenes'])) {
              $contenidoModel->imagenes = $_FILES['imagenes'];
          }

          if (!is_null($contenidoModel->idLineaTiempo)) {
              $contenidoModel->scenario = Contenido::SCENARIO_PUBLICAR_PORTALES_CON_LINEA_TIEMPO;
          }

          $transaction = Contenido::getDb()->beginTransaction();
          try {

              $contenidoModel->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
              $contenidoModel->fechaPublicacion = $contenidoModel->fechaActualizacion = date("Y-m-d H:i:s");
              $contenidoModel->aprobarPublicacion();
              $contenidoModel->numeroDocumentoAprobacion = Yii::$app->user->identity->numeroDocumento;

              if ($contenidoModel->save()) {
                  $contenidoModel->guardarImagenes();
                  $this->guardarContenidoPortal($contenidoModel);

                  if (!empty($contenidodestino['codigoCiudad']) && !empty($contenidodestino['idGrupoInteres']) && in_array("1", $contenidoModel->portales)) {
                    $contenidoModel->guardarContenidoDestino($contenidodestino);
                  }

                  $transaction->commit();
                  return $this->redirect(['publicar-portales']);
                  /*$respond = [
                      'result' => 'ok',
                      'response' => $this->renderAjax('/contenido/_formPublicarPortales', [
                        'contenidoModel' => $contenidoModel,
                        'esAdmin' => $esAdmin,
                  ])];
                  \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                  return $respond;*/
              }else{
                $respond = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('/contenido/_formPublicarPortales', [
                      'contenidoModel' => $contenidoModel,
                      'esAdmin' => $esAdmin,
                ])];
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return $respond;
              }
          } catch (\Exception $e) {

              $transaction->rollBack();
              throw $e;
          }
      }else{
        return $this->render('/contenido/publicar-portales-crear', [
                    'contenidoModel' => $contenidoModel,
                    'esAdmin' => $esAdmin,
        ]);
      }
    }

    public function actionPublicarPortalesActualizar($id)
    {

      if (!Yii::$app->user->identity->tienePermiso('intranet_sitio_publicar-portales')) {
        throw new \yii\web\ForbiddenHttpException('Acceso no permitdo.',403);
      }

      $esAdmin = false;
      if (Yii::$app->user->identity->tienePermiso('intranet_admin')) {
        $esAdmin = true;
      }

      $contenidoModel = $this->encontrarModeloContenido($id);
      //$contenidoModel->scenario = Contenido::SCENARIO_PUBLICAR_PORTALES;

      $contenidodestino = Yii::$app->request->post('ContenidoDestino');


      // se bucan los portales a los cuales esta asociado el contenido
      $contenidoModel->portales = array();
      $contenidoPortal = ContenidoPortal::find()->where(['idContenido' => $contenidoModel->idContenido])->all();

      foreach ($contenidoPortal as $portal ) {
        array_push($contenidoModel->portales,$portal->idPortal);
      }

      if ($contenidoModel->load(Yii::$app->request->post()) && Yii::$app->request->isAjax) { //

        if (!empty($_FILES['imagenes'])) {
            $contenidoModel->imagenes = $_FILES['imagenes'];
        }

        if ($contenidoModel->save()) {

          $contenidoModel->guardarImagenes();
          Yii::$app->session->setFlash('success', 'Noticia actualizada con exito');
          //return $this->redirect(['publicar-portales']);
          /*

          $this->guardarContenidoPortal($contenidoModel);

          if (!empty($contenidodestino['codigoCiudad']) && !empty($contenidodestino['idGrupoInteres']) && in_array("1", $contenidoModel->portales)) {
            $contenidoModel->guardarContenidoDestino($contenidodestino);
          }
          */
        }else{
          Yii::$app->session->setFlash('error', 'no se pudo actualizar la noticia');
        }
      }else{
        return $this->render('/contenido/publicar-portales-actualizar', [
                    'contenidoModel' => $contenidoModel,
                    'esAdmin' => $esAdmin,
        ]);
      }


    }

    public function guardarContenidoPortal($contenidoModel) {
        foreach ($contenidoModel->portales as $idPortal) {

            $modelContenidoPortal = new ContenidoPortal;
            $modelContenidoPortal->idContenido = $contenidoModel->idContenido;
            $modelContenidoPortal->idPortal = $idPortal;

            if (!$modelContenidoPortal->save()) {
                throw new Exception("Error al guardar el contenidoPortal:" . yii\helpers\Json::enconde($$modelContenidoPortal->getErrors()), 101);
            }
        }
    }


    public function actionBorrarImagen()
    {
      $idContenidoAdjunto = Yii::$app->request->post('key');
      $modelImagenAdjunto = ContenidoAdjunto::findOne(['idContenidoAdjunto' => $idContenidoAdjunto ]);
      if ($modelImagenAdjunto->delete()) {
          echo json_encode(['success' => 'imagen eliminada con exito']);
      }else{
        echo json_encode(['error' => 'la imagen no se ha podido eliminar', 'errorkeys' => [$idContenidoAdjunto]]);
      }
    }

    /**
     * encuentra un contenidoModel por su llave primaria
     * si el modelo no existe manda un 404
     * @param string $id
     * @return Contenido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function encontrarModeloContenido($id) {
      $model = Contenido::findOne($id);

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    //::::::::::::::::::::::
    // MENU
    //::::::::::::::::::::::

    public function actionMenu() {
        return $this->render('menu');
    }

    public function actionAgregarOpcionMenu() {
        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            if ($post['value'] == 0) {// crear la opcion
                $nuevodato = new UsuariosMenuInactivo();
                $nuevodato->numeroDocumento = Yii::$app->user->identity->numeroDocumento;
                $nuevodato->idMenu = $post['idMenu'];
                $nuevodato->save();
            } else {// eliminar la opcion
                UsuariosMenuInactivo::deleteAll('idMenu = :idMenu AND numeroDocumento = :idUsuario', [':idMenu' => $post['idMenu'], ':idUsuario' => Yii::$app->user->identity->numeroDocumento]);
            }
        }

        $menu = Menu::getMenuPadre();
        $opciones = new OpcionesUsuario(Yii::$app->user->identity->numeroDocumento);

        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('/layouts/_menuCorporativoUsuario', [
                'menu' => $menu,
                'opciones' => $opciones,

        ])];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Renderiza el template menuAdmin donde se pueden crear y editar las opciones del menu
     * @param
     * @return mixed
     */
    public function actionAdministrarMenu() {
        return $this->render('menuAdmin');
    }

    /**
     * Renderiza el modal donde se podra crear un elemento en el menu corporativo
     * @param none
     * @return mixed
     */
    public function actionRenderCrearOpcionMenu() {
        $model = new Menu();
        $idPadre = Yii::$app->request->post('idPadre', NULL);
        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalOpcionMenu', [
                'model' => $model,
                'idPadre' => $idPadre
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Renderiza el modal donde se podra editar una opcion del menu corporativo
     * @param none
     * @return mixed
     */
    public function actionRenderEditarOpcionMenu($id) {
        $model = Menu::findOne($id);
        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalOpcionMenu', [
                'model' => $model,
                'idPadre' => ''
            ])
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * crea un nuevo modelo Menu
     * @param none
     * @return mixed
     */
    public function actionCrearOpcionMenu() {
        $model = new Menu();
        $respond = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->setIdRaiz();

            if ($model->save()) {
                $respond = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('menuAdmin', [])
                ];
            } else {
                $respond = [
                    'result' => 'error',
                    'response' => $this->renderAjax('_modalOpcionMenu', [
                        'model' => $model,
                        'idPadre' => $model->idPadre
                    ])
                ];
            }
        } else {
            $respond = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalOpcionMenu', [
                    'model' => $model,
                    'idPadre' => $model->idPadre
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Actualiza un modelo Menu existente
     * @param id
     * @return mixed
     */
    public function actionActualizarOpcionMenu($id) {
        $model = Menu::findOne($id);
        $respond = [];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('menuAdmin', [])
            ];
        } else {
            $respond = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalOpcionMenu', [
                    'model' => $model,
                    'idPadre' => ''
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Elimina un modelo Opcion el cual es donde se guarda el enlace al ue redirige un item del Menu
     * Si la eliminacion es correcta renderiza de nuevo la pagina
     * @param string $idOpcion
     * @return el html con la vista menuAdmin
     */
    public function actionEliminarEnlaceMenu() {
        $idOpcion = Yii::$app->request->post('idOpcion', NULL);
        $opcion = Opcion::findOne($idOpcion);

        $respond = [];

        if ($opcion->delete()) {

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('menuAdmin', [])
            ];
        } else {

            $respond = [
                'result' => 'error',
                'response' => $this->renderAjax('menuAdmin', [])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Renderiza el modal con el formulario para crear un modelo Opcion que es donde se guarda el enlance del item del menu
     * @param string $idMenu
     * @return el html con la vista del modal _modalAgregarEnlaceMenu
     */
    public function actionRenderAgregarEnlace() {
        $idMenu = Yii::$app->request->post('idMenu', NULL);
        $model = new Opcion();

        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalAgregarEnlaceMenu', [
                'model' => $model,
                'idMenu' => $idMenu
            ])
        ];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Renderiza el modal con el formulario para actualizar un modelo Opcion que es donde se guarda el enlance del item del menu
     * @return el html con la vista del modal _modalAgregarEnlaceMenu
     */
    public function actionRenderEditarEnlace()
    {
      $idOpcion = Yii::$app->request->post('idOpcion', NULL);
      $model = Opcion::findOne(['idOpcion' => $idOpcion]);

      $respond = [
          'result' => 'ok',
          'response' => $this->renderAjax('_modalAgregarEnlaceMenu', [
              'model' => $model,
              'idMenu' => $model->idMenu
          ])
      ];

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $respond;
    }

    /**
     * Crea un modelo Opcion qe es donde se guarda el enlance del item del menu
     * @param none
     * @return el html con la vista menuAdmin
     */
    public function actionGuardarOpcionMenu() {
        $model = new Opcion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('menuAdmin', [])
            ];
        } else {
            $respond = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalAgregarEnlaceMenu', [
                    'model' => $model,
                    'idMenu' => $model->idMenu
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Actualiza un modelo Opcion qe es donde se guarda el enlance del item del menu
     * @param none
     * @return el html con la vista menuAdmin
     */
    public function actionGuardarEditaOpcion($id) {

        $model = Opcion::findOne(['idOpcion' => $id]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('menuAdmin', [])
            ];
        } else {
            $respond = [
                'result' => 'error',
                'response' => $this->renderAjax('_modalAgregarEnlaceMenu', [
                    'model' => $model,
                    'idMenu' => $model->idMenu
                ])
            ];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
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
                        $respond = [
                            'result' => 'error',
                            'response' => 'El contenido ya no existe'
                        ];
                    } else {
                        $respond = [
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
                            $respond = [
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
                $respond = [
                    'result' => 'ok',
                    'response' => ($numeroMeGusta > 0) ?
                            Html::a($numeroMeGusta . " <span class='glyphicon glyphicon-thumbs-up' aria-hidden='true'></span>", '#', [
                                //'id' => 'showFormPublications' . $linea->idLineaTiempo,
                                'data-role' => 'listado-me-gusta-contenido',
                                'data-contenido' => $post['idContenido'],
                                'onclick' => 'return false',
                                'style' => 'color:white;'
                            ])
                             : ''
                ];
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $respond;
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

                        $respond = [
                            'result' => 'error',
                            'response' => 'Error a notificar el comentario'
                        ];
                    }
                }

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

                        $respond = [
                            'result' => 'error',
                            'response' => 'Error a notificar el comentario'
                        ];
                    }
                }

                $noticia = Contenido::traerNoticiaEspecifica($comentario->idContenido);
                $linea = LineaTiempo::find()->where(['idLineaTiempo' => $noticia->idLineaTiempo])->one();

                $respond = [
                    'result' => 'ok',
                    'response' => $this->renderAjax('/contenido/_contenido', ['noticia' => $noticia, 'linea' => $linea])
                ];
            } else {

                $contenido = Contenido::find()->where(['idContenido' => $comentario->idContenido])->one();

                if (empty($contenido)) {
                    $respond = [
                        'result' => 'error',
                        'response' => 'El contenido ya no existe'
                    ];
                } else {
                    $respond = [
                        'result' => 'error',
                        'response' => 'Error al guardar el comentario'
                    ];
                }
            }
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $respond;
        }
    }

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
                $respond = [
                    'result' => 'ok'
                ];
            } else {
                $respond = [
                    'result' => 'error'
                ];
            }
        } else if ($opcion == 1) {

            UsuarioWidgetInactivo::deleteAll('widget = :widget AND widget = :widget', [':widget' => $elemento, ':numeroDocumento' => Yii::$app->user->identity->numeroDocumento]);
            $respond = [
                'result' => 'ok'
            ];
        }
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    //::::::::::::::::::::::
    // CUMPLEAÑOS
    //::::::::::::::::::::::

    /**
     * muestra todos los modelos cumpleaños que sean mayores a la fecha de hoy
     * @param
     * @return mixed
     */
    public function actionTodosCumpleanos() {
        $query = CumpleanosPersona::getCumpleanosVerTodos();
        $countQuery = clone $query;
        $paginas = new Pagination(['pageSize' => Yii::$app->params['cumpleanios']['porPagina'], 'totalCount'=>$countQuery->count()]);
        // $paginas = new Pagination(['totalCount'=>$countQuery->count()]);
        $models =  $query->offset($paginas->offset)->limit($paginas->limit)->all();
        return $this->render('/cumpleanos/todosCumpleanos', [
                    'models' => $models,
                    'paginas' => $paginas,
        ]);
    }

    /**
     * muestra todos los modelos aniversarios que sean mayores a la fecha de hoy
     * @param
     * @return mixed
     */
    public function actionTodosAniversarios() {
        $query = CumpleanosLaboral::getAniversariosVerTodos();
        $countQuery = clone $query;
        $paginas = new Pagination(['pageSize' => Yii::$app->params['aniversarios']['porPagina'], 'totalCount'=>$countQuery->count()]);
        // $paginas = new Pagination(['totalCount'=>$countQuery->count()]);
        $models =  $query->offset($paginas->offset)->limit($paginas->limit)->all();
        return $this->render('/cumpleanos/todosAniversarios', [
                    'models' => $models,
                    'paginas' => $paginas,
        ]);
    }

    /**
     * template para felicitar a un usuario por su cumpleaños
     * @return mixed
     */
    public function actionFelicitarAniversario($id) {
        $modelCumpleanosLaboral = CumpleanosLaboral::encontrarModelo($id);
        $modelContenido = new Contenido;

        if (Yii::$app->request->isAjax) {
            if ($modelContenido->load(Yii::$app->request->post())) {
            	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            	$transaction = \Yii::$app->db->beginTransaction();
                try {
                    $modelContenido->idLineaTiempo = \Yii::$app->params['lineasTiempo']['aniversario'];
                    $lineaTiempo = LineaTiempo::encontrarModelo($modelContenido->idLineaTiempo);

                    $modelContenido->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
                    if (!empty($_FILES['imagenes'])) {
                        $modelContenido->imagenes = $_FILES['imagenes'];
                    }
                    $modelContenido->fechaPublicacion = date("Y-m-d H:i:s");
                    $modelContenido->setEstadoDependiendoAprobacion($lineaTiempo);
                    $modelContenido->titulo = "Felicitaciones $modelCumpleanosLaboral->nombre";

                    if ($modelContenido->save()) {
                        $modelContenido->guardarImagenes();
                        $modelContenido->guardarContenidoDestino($modelCumpleanosLaboral->obtenerDestinos(true));
                        $this->generarNotificacionFelicitacion($modelContenido->idContenido, $modelCumpleanosLaboral->numeroDocumento);

                        $transaction->commit();
                        return [
                            'result' => 'ok',
                        	'response' => [['alert'=> 'success', 'text'=> 'Felicitaci&oacute;n de aniversario enviada']]
                        ];
                    }else{
                    	return [
                    		'result' => 'error',
                    		'response' => [['alert'=> 'error', 'text'=> 'Datos inv&aacute;lidos']],
                    		'validation' => \yii\bootstrap\ActiveForm::validate($modelContenido),
                    	];
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return [
                    	'result' => 'error',
                    	'response' => [['alert'=> 'error', 'text'=> $e->getMessage()]]
                    ];
                }
            }else{
            	return [
            		'result' => 'ok',
            		'response' => [['alert'=> 'error', 'text'=> 'Datos no ingresados']]
            	];
            }
        }

        return $this->render('/cumpleanos/felicitarAniversario', [
      		'modelCumpleanosLaboral' => $modelCumpleanosLaboral,
   			'modelContenido' => $modelContenido
        ]);
    }

    /**
     * template para felicitar a un usuario por su cumpleaños
     * @return mixed
     */
    public function actionFelicitarCumpleanos($id) {
        $modelCumpleanosPersona = CumpleanosPersona::encontrarModelo($id);
        $modelContenido = new Contenido;

        if (Yii::$app->request->isAjax) {
        	\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if ($modelContenido->load(Yii::$app->request->post())) {
            	$transaction = \Yii::$app->db->beginTransaction(); 
                try {
                    $modelContenido->idLineaTiempo = \Yii::$app->params['lineasTiempo']['cumpleanios'];
                    $lineaTiempo = LineaTiempo::encontrarModelo($modelContenido->idLineaTiempo);

                    $modelContenido->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
                    if (!empty($_FILES['imagenes'])) {
                        $modelContenido->imagenes = $_FILES['imagenes'];
                    }
                    $modelContenido->fechaPublicacion = date("Y-m-d H:i:s");
                    $modelContenido->setEstadoDependiendoAprobacion($lineaTiempo);
                    $modelContenido->titulo = "Felicitaciones $modelCumpleanosPersona->nombre";

                    if ($modelContenido->save()) {
                        $modelContenido->guardarImagenes();
                        $modelContenido->guardarContenidoDestino($modelCumpleanosPersona->obtenerDestinos(true));
                        $this->generarNotificacionFelicitacion($modelContenido->idContenido, $modelCumpleanosPersona->numeroDocumento);
                        
                        $transaction->commit();
                        return [
                            'result' => 'ok',
                        	'response' => [['alert'=> 'success', 'text'=> 'Felicitaci&oacute;n de cumplea&ntilde;os enviada']]
                        ];
                    }else{
                    	return [
                    		'result' => 'error',
                    		'response' => [['alert'=> 'error', 'text'=> 'Datos inv&aacute;lidos']],
                    		'validation' => \yii\bootstrap\ActiveForm::validate($modelContenido),
                    	];
                    }
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    return [
                    	'result' => 'error',
                    	'response' => [['alert'=> 'error', 'text'=> $e->getMessage()]]
                    ];
                }
            }else{
            	return [
            		'result' => 'ok',
            		'response' => [['alert'=> 'error', 'text'=> 'Datos no ingresados']]
            	];
            }
        }

        return $this->render('/cumpleanos/felicitarCumpleanos', [
     		'modelCumpleanosPersona' => $modelCumpleanosPersona,
			'modelContenido' => $modelContenido
        ]);
    }

    /**
     * @param idUsuarioEnviado, idClasificado
     */
    public function generarNotificacionFelicitacion($idContenido, $idUsuarioDirigido) {
        $notificacion = new Notificaciones();
        $notificacion->idContenido = $idContenido;
        $notificacion->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
        $notificacion->numeroDocumentoDirigido = $idUsuarioDirigido;
        $notificacion->descripcion = 'te han felicitado';
        $notificacion->estadoNotificacion = Notificaciones::ESTADO_CREADA;
        $notificacion->fechaRegistro = Date("Y-m-d H:i:s");
        $notificacion->tipoNotificacion = Notificaciones::NOTIFICACION_RECOMENDACION;

        if (!$notificacion->save()) {
            throw new Exception("Error no se genero la notificacion:" . yii\helpers\Json::enconde($notificacion->getErrors()), 100);
        }
    }

    public function actionIconos() {
        return $this->render('iconos', []);
    }

}
