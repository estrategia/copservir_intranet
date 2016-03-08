<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\DatosForm;
use app\models\Usuario;
use app\models\FotoForm;
use app\models\FormUpload;
use app\models\Contenido;
use app\models\LineaTiempo;
use yii\web\UploadedFile;
use yii\db\ActiveRecord;

class SiteController extends Controller {

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
            return $this->goBack();
        }
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionRecordarClave() {

      $this->layout = 'loginLayout' ;

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
                $codigoRecuperacion = md5($usuario->numeroDocumento.'~'.$fecha->format('YmdHis'));

                //se guarda el codigo y la fecha de recuperacion
                $usuario->codigoRecuperacion = $codigoRecuperacion;
                $usuario->fechaRecuperacion = $fecha->format('Y-m-d H:i:s');
                $usuario->save();

                //enlace para reestablecer la contraseña
                $enlace = yii::$app->urlManager->createAbsoluteUrl(['/site/reestablecer-clave','codigo'=>$codigoRecuperacion]);
                //contenido del email
                $contenido_mail = "Ingresa a la siguiente direccion para reestalecer tu contraseña.\n".$enlace;
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

    public function actionReestablecerClave($codigo)
    {
        $this->layout = 'loginLayout';
        $model = new LoginForm();
        $model->scenario = 'cambiarClave';
        if ($model->load(Yii::$app->request->post())) {
            // actualizar la clave, llamando al webservice de siicop
            $fecha = new \DateTime();
            $fecha = $fecha->format('YmdHis');

            $usuario = Usuario::find()->where(["codigoRecuperacion"=> $codigo, 'estado'=> 1])->andWhere(['>=', 'fechaRecuperacion', $fecha])->one();;
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
        $contenidoModel = new Contenido();
        $linea = LineaTiempo::find()->where(['idLineaTiempo' => $lineaTiempo])->one();

        $noticias = Contenido::traerNoticias($lineaTiempo);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_lineaTiempo', [
                //'contenidoModel' => $contenidoModel,
                //'linea' => $linea,
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

}
