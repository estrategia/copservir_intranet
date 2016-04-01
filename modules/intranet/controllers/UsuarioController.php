<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
//use yii\web\Response;
use yii\widgets\ActiveForm;
//use vova07\imperavi\Widget;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\intranet\models\LoginForm;
use app\modules\intranet\models\DatosForm;
use app\modules\intranet\models\Usuario;
use app\modules\intranet\models\ConexionesUsuarios;
use app\modules\intranet\models\RecuperacionClave;
use app\modules\intranet\models\FotoForm;
use app\modules\intranet\models\OfertasLaborales;
use app\modules\intranet\models\Contenido;
use app\modules\intranet\models\LineaTiempo;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;
use app\modules\intranet\models\UsuarioWidgetInactivo;
use yii\db\Query;

class UsuarioController extends \yii\web\Controller {
    /*
      comportamientos del controlador
     */

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['salir'],
                'rules' => [
                    [
                        'actions' => ['salir'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
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
        $this->redirect('autenticar', ['model' => $model]);
    }

    /*
      accion para actualizar la clave del usuario tanto en el perfil como en el reestablecer
     */

    public function actionCambiarClave() {

        $model = new LoginForm();
        $model->scenario = 'cambiarClave';
        if ($model->load(Yii::$app->request->post())) {
            // actualizar la clave, llamando al webservice de siicop

            $model = new LoginForm();
            $model->scenario = 'cambiarClave';
        }
        return $this->render('cambiarClave', [
                    'model' => $model,
        ]);
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
                // Guardar y enviar correo de recuperación
                // se genera el codigo de recuperacion
                $fecha = new \DateTime();
                $fecha->modify('+ 1 day');
                //$fecha
                $codigoRecuperacion = md5($usuario->numeroDocumento . '~' . $fecha->format('YmdHis'));

                //se guarda el codigo y la fecha de recuperacion
                $objRecuperacionClave = new RecuperacionClave();

                $objRecuperacionClave->numeroDocumento = $usuario->numeroDocumento;
                $objRecuperacionClave->recuperacionCodigo = $codigoRecuperacion;
                $objRecuperacionClave->recuperacionFecha = $fecha->format('Y-m-d H:i:s');
                $objRecuperacionClave->save();

                //enlace para reestablecer la contraseña
                $enlace = yii::$app->urlManager->createAbsoluteUrl(['usurario/reestablecer-clave', 'codigo' => $codigoRecuperacion]);
                //contenido del email
                $contenido_mail = "Ingresa a la siguiente direccion para reestalecer tu contraseña.\n" . $enlace;
                // sacar el correo del usuario del web service para enviar el email
                // envia correo
                $value = yii::$app->mailer->compose()->setFrom('donberna-93@hotmail.com')->setTo('miguel.bernal@eiso.com.co')->setSubject('prueba')->setHtmlBody($contenido_mail)->send();
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
            // actualizar la clave, llamando al webservice de siicop
            $fecha = new \DateTime();
            $fecha = $fecha->format('YmdHis');


            $objRecuperacionClave = RecuperacionClave::find()->where(['recuperacionCodigo' => $codigo])->orderBy('recuperacionFecha DESC')->one();
            $usuario = Usuario::find()->where(['numeroDocumento' => $objRecuperacionClave->numeroDocumento, 'estado' => 1])->one();
            ;
            if ($usuario === null) {
                throw new \yii\web\HttpException(404, 'usuario sin codigo');
            }
            //echo $usuario->numeroDocumento;
            $model->username = $usuario->numeroDocumento;
            if ($model->login()) {
                return $this->goBack();
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
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['autenticar']);
            exit();
        }
        $modelFoto = new FotoForm();

        if ($modelFoto->load(Yii::$app->request->post())) {
            // llamar al webservice y mandar los datos
            {

                $modelFoto->imagenPerfil = UploadedFile::getInstances($modelFoto, 'imagenPerfil');

                if ($modelFoto->imagenPerfil) {
                    foreach ($modelFoto->imagenPerfil as $file) {
                        $file->saveAs('img/fotosperfil/' . $file->baseName . '.' . $file->extension);
                        $msg = "<p><strong class='label label-info'>Enhorabuena, subida realizada con éxito</strong></p>";
                    }
                    $usuario = Usuario::findOne(['numeroDocumento' => \Yii::$app->user->identity->numeroDocumento, 'estado' => 1]);

                    $usuario->imagenPerfil = $file->baseName . '.' . $file->extension;

                    $usuario->save();
                    Yii::$app->user->identity->imagenPerfil = $file->baseName . '.' . $file->extension;
                }
            }
            $modelFoto = new FotoForm();
        }
        return $this->render('perfil', ['modelFoto' => $modelFoto]);
    }

    /*
      Accion para actualizar la informacion del usuario
     */

    public function actionActualizarDatos() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['autenticar']);
            exit();
        }
        $model = new DatosForm();
        if ($model->load(Yii::$app->request->post())) {
            // llamar al webservice y mandar los datos
        }
        return $this->render('actualizarDatos', [
                    'model' => $model,
        ]);
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
     * @return html contenido modal para enviar a un amigo
     */
     public function actionModalAmigos($idClasificado)
     {
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       $listaUsuarios = Usuario::find()->where([ 'estado' => 1])->all();
       $clasificado = Contenido::findOne(['idContenido' => $idClasificado]);

       $items = [
           'result' => 'ok',
           'response' => $this->renderAjax('_modalEnviarAmigo', [
               'listaUsuarios' => $listaUsuarios,
               'modelClasificado' => $clasificado
            ]
       )];

       return $items;
     }

    /**
     * Eviar a un amigo = accion para buscar los usuarios en el input
     * @param none
     * @return array con los usuarios
     */
    public function actionBuscarAmigos($search = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    }
}
