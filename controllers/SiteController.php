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
use yii\web\UploadedFile;

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
        return $this->render('index');
    }

    public function actionLogin() {

        $this->layout = 'loginLayout' ;

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
        $this->redirect('login',['model' => $model]);
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
                    $usuario = Usuario::findOne(['numeroDocumento' => \Yii::$app->user->identity->numeroDocumento, 'estado' => 1]) ;

                    $usuario->imagenPerfil =  $file->baseName . '.' . $file->extension;

                    $usuario->save();
                    Yii::$app->user->identity->imagenPerfil = $file->baseName . '.' . $file->extension;

                }
            }
            $modelFoto = new FotoForm();
        }
        return $this->render('perfil', ['modelFoto' => $modelFoto]);
    }

}
