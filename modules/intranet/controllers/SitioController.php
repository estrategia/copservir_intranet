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
use app\modules\intranet\models\ContenidoRecomendacion;
use app\modules\intranet\models\UsuarioWidgetInactivo;
use app\modules\intranet\models\LogContenidos;
use app\modules\intranet\models\PublicacionesCampanas;
use app\modules\intranet\models\CumpleanosLaboral;
use app\modules\intranet\models\CumpleanosPersona;
use app\modules\intranet\models\Menu;
use app\modules\intranet\models\Opcion;
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

    // cumpleaños y aniversarios
    $cumpleanos = CumpleanosPersona::getCumpleanosIndex($userCiudad, $userGrupos);
    $aniversarios = CumpleanosLaboral::getAniversariosIndex($userCiudad, $userGrupos);

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
    $respond = [
      'result' => 'ok',
      'response' => $this->renderAjax('_lineaTiempo', [
        'linea' => $linea,
        'noticias' => $noticias
      ]
      )];
      return $respond;
    }

  /*
  accion para guardar un contenido en alguna linea de tiempos
  */

  public function actionGuardarContenido() {

    $contenido = new Contenido();
    $respond = [];

    if ($contenido->load(Yii::$app->request->post())) {
      //var_dump(Yii::$app->request->post());
      //exit();
      $transaction = Contenido::getDb()->beginTransaction();

      try {

        $contenido->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
        $contenido->fechaPublicacion = $contenido->fechaActualizacion = date("Y-m-d H:i:s");
        if (!empty($_FILES['imagenes'])) {
            $contenido->imagenes = $_FILES['imagenes'];
        }

        $lineaTiempo = LineaTiempo::findOne($contenido->idLineaTiempo);
        $contenido->setEstadoDependiendoAprovacion($lineaTiempo);

        if ($contenido->save()) {
          $contenido->guardarImagenes();
          $solicitarGrupo = Yii::$app->request->post('SolicitarGrupoObjetivo');

          if ($solicitarGrupo == 1) {
            $contenidodestino = Yii::$app->request->post('ContenidoDestino');
            $contenido->guardarContenidoDestino($contenidodestino);
          }else{
            $contenido->guardarContenidoDestinoTodos();
          }

          $transaction->commit();
          $contenidoModel = new Contenido();
          $noticias = Contenido::traerNoticias($contenido->idLineaTiempo);
          $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('_lineaTiempo', [
              'contenidoModel' => $contenidoModel,
              'linea' => $lineaTiempo,
              'noticias' => $noticias
              ])];
        }

      }catch(\Exception $e) {

        $transaction->rollBack();
        throw $e;
        $respond =  [
          'result' => 'error',
          'response' => 'Error al guardar el contenido'
        ];
      }
    } else {
      $respond =  [
        'result' => 'error',
        'response' => 'Error al cargar el contenido'
      ];
    }

    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $respond;
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

  /**
  * Renderiza el template menuAdmin donde se pueden crear y editar las opciones del menu
  * @param
  * @return mixed
  */
  public function actionAdministrarMenu()
  {
    return $this->render('menuAdmin');
  }

  /**
  * Renderiza el modal donde se podra crear un elemento en el menu corporativo
  * @param none
  * @return mixed
  */
  public function actionRenderCrearOpcionMenu()
  {
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
  public function actionRenderEditarOpcionMenu($id)
  {
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
  public function actionCrearOpcionMenu()
  {
    $model = new Menu();
    $respond = [];

    if ($model->load(Yii::$app->request->post()) && $model->save()) {

      // pasar a una funcion en el modelo
      $model->setIdRaiz();

      if ($model->save()) {
        $respond = [
          'result' => 'ok',
          'response' => $this->renderAjax('menuAdmin', [])
        ];
      }else{
        $respond = [
          'result' => 'error',
          'response' => $this->renderAjax('menuAdmin', [])
        ];
      }

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
  * Actualiza un modelo Menu existente
  * @param id
  * @return mixed
  */
  public function actionActualizarOpcionMenu($id)
  {
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
        'response' => $this->renderAjax('menuAdmin', [])
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
  public function actionEliminarEnlaceMenu()
  {
    $idOpcion = Yii::$app->request->post('idOpcion', NULL);
    $opcion = Opcion::findOne($idOpcion);

    $respond =[];

    if ($opcion->delete()) {

      $respond = [
        'result' => 'ok',
        'response' => $this->renderAjax('menuAdmin', [])
      ];
    }else{

      $respond = [
        'result' => 'error',
        'response' => $this->renderAjax('menuAdmin', [])
      ];
    }

    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $respond;
  }

  /**
  * Renderiza el modal con el formulario para crear un modelo Opcion qe es donde se guarda el enlance del item del menu
  * @param string $idMenu
  * @return el html con la vista del modal _modalAgregarEnlaceMenu
  */
  public function actionRenderAgregarEnlace()
  {
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
  * Crea un modelo Opcion qe es donde se guarda el enlance del item del menu
  * @param none
  * @return el html con la vista menuAdmin
  */
  public function actionGuardarOpcionMenu()
  {
    $model = new Opcion();

    if ($model->load(Yii::$app->request->post()) && $model->save() ) {

      $respond = [
        'result' => 'ok',
        'response' => $this->renderAjax('menuAdmin', [])
      ];
    }else{
      $respond = [
        'result' => 'error',
        'response' => $this->renderAjax('menuAdmin', [ ])
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
          Html::a($numeroMeGusta . " Me Gusta", '#', [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'data-role' => 'listado-me-gusta-contenido',
            'data-contenido' => $post['idContenido'],
            'onclick' => 'return false'
            ]) : ''
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
  public function actionTodosCumpleanos()
  {
    $models = CumpleanosPersona::getCumpleanosVerTodos();
    return $this->render('/cumpleanos/todosCumpleanos', [
      'models' => $models,
    ]);
  }

  /**
  * muestra todos los modelos aniversarios que sean mayores a la fecha de hoy
  * @param
  * @return mixed
  */
  public function actionTodosAniversarios()
  {
    $models = CumpleanosLaboral::getAniversariosVerTodos();
    return $this->render('/cumpleanos/todosAniversarios', [
      'models' => $models,
    ]);
  }

  /**
  * template para felicitar a un usuario por su cumpleaños
  * @return mixed
  */
  public function actionFelicitarAniversario($id)
  {
    $modelCumpleanosLaboral = CumpleanosLaboral::encontrarModelo($id);
    $modelContenido = new Contenido;
    if (Yii::$app->request->isAjax) {
      if ($modelContenido->load(Yii::$app->request->post())) {
        $transaction = Contenido::getDb()->beginTransaction();
        try {

          $lineaTiempo = LineaTiempo::encontrarModelo(LineaTiempo::MIS_PUBLICACIONES);

          $modelContenido->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
          if (!empty($_FILES['imagenes'])) {
              $contenido->imagenes = $_FILES['imagenes'];
          }
          $modelContenido->fechaPublicacion = Date("Y-m-d H:i:s");
          $modelContenido->idLineaTiempo = LineaTiempo::MIS_PUBLICACIONES;
          $modelContenido->setEstadoDependiendoAprovacion($lineaTiempo);

          if ($modelContenido->save()) {
            $modelContenido->guardarImagenes();

            $contenidoRecomendacion = new ContenidoRecomendacion();
            $contenidoRecomendacion->guardarContenidoRecomendacion($modelContenido->idContenido, $modelCumpleanosPersona->numeroDocumento);

            $this->generarNotificacionFelicitacion($modelContenido->idContenido, $modelCumpleanosPersona->numeroDocumento);

            $transaction->commit();
            $respond = [
              'result' => 'ok',
              /*'response' => $this->renderAjax('_lineaTiempo', [
                'contenidoModel' => $contenidoModel,
                'linea' => $lineaTiempo,
                'noticias' => $noticias
                ])*/
              ];

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $respond;
          }

        } catch(\Exception $e) {

          $transaction->rollBack();
          Yii::$app->session->setFlash('error', $e->getMessage());
          throw $e;
        }
      }
    }//

    return $this->render('/cumpleanos/felicitarAniversario', [
      'modelCumpleanosLaboral' => $modelCumpleanosLaboral,
      'modelContenido' => $modelContenido
    ]);
  }

  /**
  * template para felicitar a un usuario por su aniversario
  * @return mixed
  */
  public function actionFelicitarCumpleanos($id)
  {
    $modelCumpleanosPersona = CumpleanosPersona::encontrarModelo($id);
    $modelContenido = new Contenido;

    if (Yii::$app->request->isAjax) {

      if ($modelContenido->load(Yii::$app->request->post())) {
        $transaction = Contenido::getDb()->beginTransaction();
        try {

          $lineaTiempo = LineaTiempo::encontrarModelo(LineaTiempo::MIS_PUBLICACIONES);

          $modelContenido->numeroDocumentoPublicacion = Yii::$app->user->identity->numeroDocumento;
          if (!empty($_FILES['imagenes'])) {
              $contenido->imagenes = $_FILES['imagenes'];
          }
          $modelContenido->fechaPublicacion = Date("Y-m-d H:i:s");
          $modelContenido->idLineaTiempo = LineaTiempo::MIS_PUBLICACIONES;
          $modelContenido->setEstadoDependiendoAprovacion($lineaTiempo);

          if ($modelContenido->save()) {
            $modelContenido->guardarImagenes();

            $contenidoRecomendacion = new ContenidoRecomendacion();
            $contenidoRecomendacion->guardarContenidoRecomendacion($modelContenido->idContenido, $modelCumpleanosPersona->numeroDocumento);

            $this->generarNotificacionFelicitacion($modelContenido->idContenido, $modelCumpleanosPersona->numeroDocumento);

            $transaction->commit();
            $respond = [
              'result' => 'ok',
              /*'response' => $this->renderAjax('_lineaTiempo', [
                'contenidoModel' => $contenidoModel,
                'linea' => $lineaTiempo,
                'noticias' => $noticias
                ])*/
              ];

            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $respond;
          }

        } catch(\Exception $e) {

          $transaction->rollBack();
          Yii::$app->session->setFlash('error', $e->getMessage());
          throw $e;
        }
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
  public function generarNotificacionFelicitacion($idContenido, $idUsuarioDirigido)
  {
    $notificacion = new Notificaciones();
    $notificacion->idContenido = $idContenido;
    $notificacion->numeroDocumentoDirige = Yii::$app->user->identity->numeroDocumento;
    $notificacion->numeroDocumentoDirigido = $idUsuarioDirigido;
    $notificacion->descripcion = 'te han felicitado';
    $notificacion->estadoNotificacion = Notificaciones::ESTADO_CREADA;
    $notificacion->fechaRegistro = Date("Y-m-d H:i:s");
    $notificacion->tipoNotificacion = Notificaciones::NOTIFICACION_RECOMENDACION;

    if (!$notificacion->save()) {
      throw new Exception("Error no se genero la notificacion:".yii\helpers\Json::enconde($notificacion->getErrors()), 100);
    };
  }
}
