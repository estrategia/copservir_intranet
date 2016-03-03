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
use app\models\ContactForm;
use app\models\Usuario;
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
        return $this->render('index');
    }

    public function actionLogin() {
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
           
           if(!$usuario){
              
               $model->addError('username', 'Usuario no existe');
           }else{
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

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionPerfil() {
        return $this->render('perfil');
    }

}
