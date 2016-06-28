<?php

namespace app\modules\intranet\controllers;

use Yii;
//use vova07\imperavi\Widget;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\intranet\models\LoginForm;
use app\modules\intranet\models\PersonaForm;
use app\models\Usuario;//use app\modules\intranet\models\Usuario;
use app\modules\intranet\models\ConexionesUsuarios;
use app\modules\intranet\models\RecuperacionClave;
use app\modules\intranet\models\FotoForm;
use app\modules\intranet\models\Contenido;
use yii\web\UploadedFile;
use app\modules\intranet\models\UsuarioWidgetInactivo;
use app\modules\intranet\models\MeGustaContenidos;
use app\modules\intranet\models\GrupoInteres;
use yii\imagine\Image;
use yii\helpers\Json;
use Imagine\Image\Box;
use Imagine\Image\Point;

class UsuarioController extends \yii\web\Controller {
    /*
      comportamientos del controlador
     */

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => ['autenticar', 'cambiar-clave', 'perfil', 'cambiar-foto-perfil', 'actualizar-datos','pantalla-inicio','modal-amigos'],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'salir' => ['post'],
                ],
            ],
        ];
    }

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'image-upload' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => 'http://localhost/copservir_intranet/imagenes/post/', //Yii::$app->realpath().'/imagenes', // Directory URL address, where files are stored.
                'path' => '@app/imagenes/post' // Or absolute path to directory where files are stored.
            ],
        ];
    }

    /*
      Accion para ingresar a la app
     */

    public function actionAutenticar() {

        $this->layout = 'loginLayout';

        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['sitio/index']);
        }

        $model = new LoginForm();
        $model->scenario = 'login';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

          // se guarda el registro de la conexion
          $objConexionesUsuario = new ConexionesUsuarios();
          $objConexionesUsuario->numeroDocumento = $model->username;
          $objConexionesUsuario->fechaConexion = date('YmdHis');
          $objConexionesUsuario->ip = $objConexionesUsuario->getRealIp(); //Yii::$app->getRequest()->getUserIP() ;
          $objConexionesUsuario->save();

          return $this->redirect(['sitio/index']);
        }
        return $this->render('autenticar', [
                    'model' => $model,
        ]);
    }

    /*
      Accion para salir de la app
     */
    public function actionSalir() {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['autenticar']);
            exit();
        }
        Yii::$app->user->logout();
        $model = new LoginForm();
        $this->redirect(['autenticar', ['model' => $model]]);
    }

    /*
      accion para actualizar la clave del usuario tanto en el perfil como en el reestablecer
     */

    public function actionCambiarClave() {

        $model = new LoginForm();
        $model->username = \Yii::$app->user->identity->numeroDocumento;
        $model->scenario = 'cambiarClave';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $response = self::callWSCambiarClave($model->username, sha1($model->password));

            if ($response){
              return $this->redirect(['perfil']);
            }else{
              Yii::$app->session->setFlash('error', 'Error al cambiar la contraseña');
            }
        }

        return $this->render('cambiarClave', [
          'model' => $model,
        ]);
    }

    /**
    * Funcion para consumir el web services para cambiar la contraseña de acceso
    * @param string $username, string password
    * @return boolean,
    */
      public static function callWSCambiarClave($username, $password)
      {
        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {

            $result = $client->cambiarClave($username, $password);
            return $result;

        } catch (SoapFault $ex) {
          Yii::error($ex->getMessage());
        } catch (Exception $ex) {
          Yii::error($ex->getMessage());
        }
      }

    /*
      Accion para enviar un email con un enlace donde puede reestablecer su clave
     */

    public function actionRecordarClave() {

        $this->layout = 'loginLayout';

        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['sitio/index']);
        }

        $model = new LoginForm();
        $model->scenario = 'recuperar';
        if ($model->load(Yii::$app->request->post())) {
            $usuario = Usuario::findOne(['numeroDocumento' => $model->username, 'estado' => 1]);

            if (!$usuario) {

                $model->addError('username', 'Usuario no existe');
            } else {
                // se genera el codigo de recuperacion
                $fecha = new \DateTime();
                $fecha->modify('+ 1 day');
                $codigoRecuperacion = md5($usuario->numeroDocumento . '~' . $fecha->format('YmdHis'));

                //se guarda el codigo y la fecha de recuperacion
                $objRecuperacionClave = new RecuperacionClave();
                $objRecuperacionClave->numeroDocumento = $usuario->numeroDocumento;
                $objRecuperacionClave->recuperacionCodigo = $codigoRecuperacion;
                $objRecuperacionClave->recuperacionFecha = $fecha->format('Y-m-d H:i:s');
                $objRecuperacionClave->save();

                //se crea el enlace para restablecer la contraseña y el contenido del email
                $enlace = yii::$app->urlManager->createAbsoluteUrl(['intranet/usuario/reestablecer-clave', 'codigo' => $codigoRecuperacion]);
                $contenido_mail = "Ingresa a la siguiente direccion para reestalecer tu contraseña.\n" . $enlace;

                $correoUsuario = \Yii::$app->user->identity->getEmail();


                // envia correo
                $value = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                  ->setTo($correoUsuario)->setSubject('Recuperacion Contraseña Intranet Copservir')
                  ->setHtmlBody($contenido_mail)->send();

                return $this->render('mensajeRecuperacion');
                exit();
            }
        }
        return $this->render('recordarClave', [
                    'model' => $model,
        ]);
    }

    /*
      accion para reestablecer la clave de un usuario cuando este olvida su clave y ya ha generado el email
      con el codigo de recuperacion.
     */

    public function actionReestablecerClave($codigo) {
        $this->layout = 'loginLayout';
        $model = new LoginForm();
        $model->scenario = 'cambiarClave';
        if ($model->load(Yii::$app->request->post())) {

            $objRecuperacionClave = RecuperacionClave::find()->where(['recuperacionCodigo' => $codigo])
            ->orderBy('recuperacionFecha DESC')->one();

            $usuario = Usuario::find()->where(['numeroDocumento' => $objRecuperacionClave->numeroDocumento, 'estado' => 1])
            ->one();

            if ($usuario === null) {
                throw new \yii\web\HttpException(404, 'usuario sin codigo recuperacion');
            }else{

              $model->username = $usuario->numeroDocumento;

              $response = self::callWSCambiarClave($model->username, sha1($model->password));

              if ($response  &&  $model->login() ){

                return $this->redirect(['sitio/index']);

              }else{

                $model->addError($model->password, 'Error al reestablecer la clave');
              }

            }
        }

        return $this->render('reestablecerClave', [
                    'model' => $model,
        ]);
    }

    /*
      Accion para ver la informacion del usuario
     */
    public function actionPerfil() {
        $meGustan = MeGustaContenidos::find()->where(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento])->count();
        $contenidos = Contenido::find()->where(['numeroDocumentoPublicacion' => Yii::$app->user->identity->numeroDocumento])->count();
        $gruposReferencia = GrupoInteres::find()->where('idGrupoInteres IN (' . implode(",", Yii::$app->user->identity->getGruposCodigos()) . ')')->all();
        return $this->render('perfil', ['contenidos' => $contenidos, 'meGustan' => $meGustan, 'gruposReferencia' => $gruposReferencia]);
    }

    public function actionCambiarFotoPerfil() {
        $modelFoto = FotoForm::find()->where(['numeroDocumento' => \Yii::$app->user->identity->numeroDocumento, 'estado' => 1])->one();
        $errorFotoPerfil = false;
        // $modelFoto = new FotoForm();
        if ($modelFoto->load(Yii::$app->request->post())) {
            // llamar al webservice y mandar los datos
            {

                $usuario = Usuario::findOne(['numeroDocumento' => \Yii::$app->user->identity->numeroDocumento, 'estado' => 1]);
                $modelFoto->imagenPerfil = UploadedFile::getInstances($modelFoto, 'imagenPerfil');
                try {
                    if ($modelFoto->imagenPerfil) {
                        foreach ($modelFoto->imagenPerfil as $file) {
                            if (isset(Json::decode($modelFoto->crop_info)[0])) {
                                $file->saveAs('img/fotosperfil/' . $file->baseName . '.' . $file->extension);
                                $rutaImagen = $file->baseName . '.' . $file->extension;
                                $image = Image::getImagine()->open('img/fotosperfil/' . $file->baseName . '.' . $file->extension);

                                // rendering information about crop of ONE option
                                $cropInfo = Json::decode($modelFoto->crop_info)[0];
                                $cropInfo['dWidth'] = (int) $cropInfo['dWidth']; //new width image
                                $cropInfo['dHeight'] = (int) $cropInfo['dHeight']; //new height image
                                $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
                                $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y
                                $cropInfo['width'] = (int) $cropInfo['width']; //width of cropped image
                                $cropInfo['height'] = (int) $cropInfo['height']; //height of cropped image
                                //saving thumbnail
                                $newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
                                $cropSizeThumb = new Box($cropInfo['width'], $cropInfo['height']); //frame size of crop
                                $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
                                $pathThumbImage = 'img/fotosperfil/' .
                                        $rutaImagen;

                                $image->resize($newSizeThumb)
                                        ->crop($cropPointThumb, $cropSizeThumb)
                                        ->save($pathThumbImage, ['quality' => 100]);

                                $usuario->imagenPerfil = $rutaImagen;
                                $usuario->save();
                                Yii::$app->user->identity->imagenPerfil = $file->baseName . '.' . $file->extension;
                                $msg = "<p><strong class='label label-info'>Enhorabuena, subida realizada con éxito</strong></p>";
                            } else {
                                $errorFotoPerfil = true;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    echo "<pre>";
                    print_r($e->getMessage());
                    echo "</pre>";
                }
                $modelFoto->imagenFondo = UploadedFile::getInstances($modelFoto, 'imagenFondo');

                if ($modelFoto->imagenFondo) {
                    foreach ($modelFoto->imagenFondo as $file) {
                        $file->saveAs('img/imagenesFondo/' . $file->baseName . '.' . $file->extension);
                        $msg = "<p><strong class='label label-info'>Enhorabuena, subida realizada con éxito</strong></p>";
                    }

                    $usuario->imagenFondo = $file->baseName . '.' . $file->extension;

                    $usuario->save();
                    Yii::$app->user->identity->imagenFondo = $file->baseName . '.' . $file->extension;
                }
            }
            $modelFoto = new FotoForm();

            if ($errorFotoPerfil) {
                $modelFoto->addError('imagenPerfil', 'Debe recortar la imagen');
            }
        }

        return $this->render('formFotoPerfil', ['modelFoto' => $modelFoto,]);
    }

    /*
      Accion para actualizar la informacion del usuario
     */

    public function actionActualizarDatos() {
        $model = new PersonaForm();
        $model->setValuesUserGuest();

        if ($model->load(Yii::$app->request->post()) && $model->validate() ) {


            $response = self::callWSActualizarPersona($model->attributes);
            if ($response){
              \Yii::$app->user->identity->generarDatos(true);
              return $this->redirect(['perfil']);
            }else{
              Yii::$app->session->setFlash('error', 'Error al actualizar la información');
            }

        }else{
          var_dump($model->getErrors());
        }

        return $this->render('actualizarDatos', [
                    'model' => $model,
        ]);
    }

    /**
    * Funcion para actualizar la informacion de un usuario a traves de un web services
    * @param string $request
    * @return array['result'],
    */
      public static function callWSActualizarPersona($data)
      {
        $client = new \SoapClient(\Yii::$app->params['webServices']['persona'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {

            $result = $client->actualizarPersona($data);
            return $result;

        } catch (SoapFault $ex) {
          Yii::error($ex->getMessage());
        } catch (Exception $ex) {
          Yii::error($ex->getMessage());
        }
      }

    public function actionPantallaInicio() {
        // obtener opciones desactivadas
        $opcionesDesactivadas = UsuarioWidgetInactivo::find()->where(['numeroDocumento' => Yii::$app->user->identity->numeroDocumento])->all();
        $arrayOpciones = [];

        foreach ($opcionesDesactivadas as $opc) {
            $arrayOpciones[] = $opc->widget;
        }

        return $this->render('_administrarElementos', ['opciones' => $arrayOpciones]);
    }

    /**
     * accion para renderizar el modal de enviar a un amigo
     * @param none
     * @return respond = []
     *         respond.result = indica si todo se realizo bien o mal
     *         respond.response = html para renderizar el modal tiene como parametros: listaUsuarios = usuarios a seleccionar, modelClasificado = modelo del contenido que desea compartir
     */
    public function actionModalAmigos($idClasificado) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $listaUsuarios = Usuario::listaUsuariosEnviarAmigo($idClasificado);
        $clasificado = Contenido::traerNoticiaEspecifica($idClasificado);

        $respond = [
            'result' => 'ok',
            'response' => $this->renderAjax('_modalEnviarAmigo', [
                'listaUsuarios' => $listaUsuarios,
                'modelClasificado' => $clasificado
                    ]
        )];

        return $respond;
    }

}
