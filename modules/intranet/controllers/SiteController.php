<?php

namespace app\modules\intranet\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use vova07\imperavi\Widget;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\modules\intranet\models\LoginForm;
use app\modules\intranet\models\DatosForm;
use app\modules\intranet\models\Usuario;
use app\modules\intranet\models\ConexionesUsuarios;
use app\modules\intranet\models\RecuperacionClave;
use app\modules\intranet\models\FotoForm;
use app\modules\intranet\models\FormUpload;
use app\modules\intranet\models\Contenido;
use app\modules\intranet\models\LineaTiempo;
use app\modules\intranet\models\UsuariosOpcionesFavoritos;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

class SiteController extends Controller {

    public $layout = 'main';

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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

    public function actionIndex() {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
            exit();
        }

        $contenidoModel = new Contenido();
        $lineasTiempo = LineaTiempo::find()->where(['estado' => 1])->all();
        return $this->render('index', [
                    'contenidoModel' => $contenidoModel,
                    'lineasTiempo' => $lineasTiempo
        ]);
    }

    public function actionLogin() {

        $this->layout = 'loginLayout';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }


        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {


            // se guarda el registro de la conexion
            $objConexionesUsuario = new ConexionesUsuarios();
            $objConexionesUsuario->idUsuario = $model->username;
            $objConexionesUsuario->fechaConexion = date('YmdHis');
            $objConexionesUsuario->ip = $objConexionesUsuario->getRealIp(); //Yii::$app->getRequest()->getUserIP() ;
            $objConexionesUsuario->save();

            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionRecordarClave() {

        $this->layout = 'loginLayout';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
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

                $objRecuperacionClave->idUsuario = $usuario->numeroDocumento;
                $objRecuperacionClave->recuperacionCodigo = $codigoRecuperacion;
                $objRecuperacionClave->recuperacionFecha = $fecha->format('Y-m-d H:i:s');
                $objRecuperacionClave->save();

                //enlace para reestablecer la contraseña
                $enlace = yii::$app->urlManager->createAbsoluteUrl(['/intranet/site/reestablecer-clave', 'codigo' => $codigoRecuperacion]);
                //contenido del email
                $contenido_mail = "Ingresa a la siguiente direccion para reestalecer tu contraseña.\n" . $enlace;
                // sacar el correo del usuario del web service para enviar el email
                // envia correo
                $value = yii::$app->mailer->compose()->setFrom('donberna-93@hotmail.com')->setTo('miguel.bernal@eiso.com.co')->setSubject('prueba')->setHtmlBody($contenido_mail)->send();
                return $this->render('mensajeRecuperacion');
                exit();
            }
            // enviar al correo electrónico el código de la recuperación.
        }
        return $this->render('recordarClave', [
                    'model' => $model,
        ]);
    }

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

    public function actionReestablecerClave($codigo) {
        $this->layout = 'loginLayout';
        $model = new LoginForm();
        $model->scenario = 'cambiarClave';
        if ($model->load(Yii::$app->request->post())) {
            // actualizar la clave, llamando al webservice de siicop
            $fecha = new \DateTime();
            $fecha = $fecha->format('YmdHis');


            $objRecuperacionClave = RecuperacionClave::find()->where(['recuperacionCodigo' => $codigo])->orderBy('recuperacionFecha DESC')->one();
            $usuario = Usuario::find()->where(['numeroDocumento' => $objRecuperacionClave->idUsuario, 'estado' => 1])->one();
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

    public function actionActualizarDatos() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
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

    public function actionLogout() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
            exit();
        }
        Yii::$app->user->logout();
        $model = new LoginForm();
        $this->redirect('login', ['model' => $model]);
    }

    public function actionPerfil() {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
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

    public function actionCambiarLineaTiempo($lineaTiempo) {
        //$contenidoModel = new Contenido();
        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();

        $noticias = Contenido::traerNoticias($lineaTiempo);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_lineaTiempo', [
                //'contenidoModel' => $contenidoModel,
                'linea' => $linea,
                'noticias' => $noticias
                    ]
        )];
        return $items;
    }

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

    public function actionFormNoticia($lineaTiempo) {
        $contenidoModel = new Contenido();
        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();

        echo $this->renderAjax('formNoticia', [
            'contenidoModel' => $contenidoModel,
            'linea' => $linea,
        ]);
    }

    public function actionTareas() {
        return $this->render('tareas', []);
    }

    public function actionCalendario() {
        return $this->render('calendario', []);
    }

    public function actionPublicaciones() {
        return $this->render('publicaciones', []);
    }

    public function actionOrganigrama() {
        return $this->render('organigrama', []);
    }

}
