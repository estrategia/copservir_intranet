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
                Yii::$app->session->setFlash('success', 'La contrase&ntilde;a se cambi&oacute; con &eacute;xito');
              return $this->redirect(['perfil']);
            }else{
              Yii::$app->session->setFlash('error', 'Error al cambiar la contrase&ntilde;a');
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
        $fechaRecuperacion = new \DateTime();

        if ($model->load(Yii::$app->request->post())) {

            $infoUsuario =  Usuario::callWSInfoPersona($model->username);

            if (empty($infoUsuario)) {
                $model->addError('username', 'El usuario no existe');
            } else {

                // se genera el codigo de recuperacion
                $fecha = new \DateTime();
                $fecha->modify('+ 1 day');
                $codigoRecuperacion = md5($model->username . '~' . $fecha->format('YmdHis'));

                //se guarda el codigo y la fecha de recuperacion
                $objRecuperacionClave = new RecuperacionClave();
                $objRecuperacionClave->numeroDocumento = $model->username;
                $objRecuperacionClave->recuperacionCodigo = $codigoRecuperacion;
                $objRecuperacionClave->recuperacionFecha = $fechaRecuperacion->format('Y-m-d H:i:s');

                if ($objRecuperacionClave->save()) {
                  //se crea el enlace para restablecer la contraseña y el contenido del email
                  $enlace = yii::$app->urlManager->createAbsoluteUrl(['intranet/usuario/reestablecer-clave', 'codigo' => $codigoRecuperacion]);
                  $contenido_mail = "Ingresa a la siguiente direccion para reestalecer tu contraseña.\n" . $enlace;

                  if (empty($infoUsuario['Email'])) {
                    $model->addError('username', 'El usuario no tiene un correo registrado');

                  }else{
                    $correoUsuario = $infoUsuario['Email'];

                    // envia correo
                    $value = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                      ->setTo($correoUsuario)->setSubject('Recuperacion Contraseña Intranet Copservir')
                      ->setHtmlBody($contenido_mail)->send();

                    if ($value) {
                      return $this->render('mensajeRecuperacion');
                    }else{
                      $model->addError('username', 'Error al enviar el correo');
                    }
                  }
                }else{
                  $model->addError('username', 'Ocurrio un error por favor vuelve a intentarlo');
                }
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

            $fecha = new \DateTime;
            $fecha->modify('+'.\Yii::$app->params['usuario']['tiempoRecuperarClave'].' days');

            $objRecuperacionClave = RecuperacionClave::find()->where(['recuperacionCodigo' => $codigo])
            ->andWhere(['<=', 'recuperacionFecha', $fecha->format('Y-m-d H:i:s' )])
            ->orderBy('recuperacionFecha DESC')->one();

            if ($objRecuperacionClave === null) {
                $model->addError('password2', 'Usuario sin codigo de recuperacion');
            }else{

              $infoUsuario =  Usuario::callWSInfoPersona($objRecuperacionClave->numeroDocumento);

              $response = self::callWSCambiarClave($objRecuperacionClave->numeroDocumento, sha1($model->password));
              if ($response){

                Yii::$app->session->setFlash('success', 'contraseña reestablecida con exito');
                $model = new LoginForm();

              }else{
                Yii::$app->session->setFlash('error', 'Ocurrio un error, No se pudo reestablecer la contraseña');
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
                                $nombreImagen = Yii::$app->user->identity->numeroDocumento;
                                $rutaImagen = "$nombreImagen.$file->extension";
                                $rutaImagenAnterior = $usuario->imagenPerfil;
                                $file->saveAs(Yii::getAlias('@webroot') . '/img/fotosperfil/' . $rutaImagen);
                                $image = Image::getImagine()->open(Yii::getAlias('@webroot') .'/img/fotosperfil/' . $rutaImagen);

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
                                $pathThumbImage = 'img/fotosperfil/' . $rutaImagen;

                                $image->resize($newSizeThumb)
                                        ->crop($cropPointThumb, $cropSizeThumb)
                                        ->save($pathThumbImage, ['quality' => 100]);

                                $usuario->imagenPerfil = $rutaImagen;
                                $usuario->save();
                                Yii::$app->user->identity->imagenPerfil = $rutaImagen;
                                Yii::$app->session->setFlash('success', "Imagen perfil se carg&oacute; con &eacute;xito");

                                if (!empty($rutaImagenAnterior) && $rutaImagen != $rutaImagenAnterior) {
                                    unlink(Yii::getAlias('@webroot') ."/img/fotosperfil/" . $rutaImagenAnterior);
                                }

                            } else {
                                $errorFotoPerfil = true;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
                }
                $modelFoto->imagenFondo = UploadedFile::getInstances($modelFoto, 'imagenFondo');

                if ($modelFoto->imagenFondo) {
                    //foreach ($modelFoto->imagenFondo as $file) {
                        $nombreImagen = Yii::$app->user->identity->numeroDocumento;
                        $rutaImagen = "$nombreImagen.$file->extension";
                        $rutaImagenAnterior = $usuario->imagenFondo;
                        $file->saveAs(Yii::getAlias('@webroot') . '/img/imagenesFondo/' . $rutaImagen);

                        $usuario->imagenFondo = $rutaImagen;
                        $usuario->save();
                        Yii::$app->user->identity->imagenFondo = $rutaImagen;
                        Yii::$app->session->setFlash('success', "Fondo perfil se carg&oacute; con &eacute;xito");

                        if (!empty($rutaImagenAnterior) && $rutaImagen != $rutaImagenAnterior) {
                            unlink(Yii::getAlias('@webroot') ."/img/imagenesFondo/" . $rutaImagenAnterior);
                        }
                    //}
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

    /*public function actionActualizarDatos() {
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
          //var_dump($model->getErrors());
        }

        return $this->render('actualizarDatos', [
                    'model' => $model,
        ]);
    }*/

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
