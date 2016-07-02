<?php

namespace app\modules\tarjetamas\controllers;

use Yii;
use yii\web\Controller;
use app\modules\tarjetamas\models\formularios\LoginForm;
use app\modules\tarjetamas\models\formularios\RegistroForm;
use app\modules\tarjetamas\models\UsuarioTarjetaMas;
use app\modules\intranet\models\RecuperacionClave;
use app\models\Usuario;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\modules\tarjetamas\models\formularios\ActivarForm;

class UsuarioController extends Controller {

    const USUARIO_TIENE_TARJETAS = 1;

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'index', 'cambiar-clave', 'actualizar-datos', 'mis-tarjetas', 'suspender', 'ver', 'hacer-primaria'
                ],
                'redirectUri' => ['/tarjetamas/sitio/index']
            ],
            /*
              [
              'class' => \app\components\AuthItemFilter::className(),
              'only' => [
              'admin', 'detalle', 'crear', 'actualizar', 'eliminar'
              ],
              'authsActions' => [
              'detalle' => 'intranet_linea-tiempo_admin',
              'crear' => 'intranet_linea-tiempo_admin',
              'actualizar' => 'intranet_linea-tiempo_admin',
              'eliminar' => 'intranet_linea-tiempo_admin',
              ]
              ],
             */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index');
    }

    public function actionRegistro() {
        $model = new RegistroForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $response = UsuarioTarjetaMas::callWSConsultarTarjetasAbonado($model->username);

            if ($response[0]['CODIGO'] == self::USUARIO_TIENE_TARJETAS) {
                return $this->redirect(['datos-registro']);
            } else {
                $model->addError('username', $response[0]['MENSAJE']);
            }
        }

        return $this->render('verifica-registro', [
                    'model' => $model,
        ]);
    }

    /**
     * Funcion para ver las tarjetas de el usuario loguado
     * @param none
     * @return <tag> html,
     */
    public function actionMisTarjetas() {
        $cedula = \Yii::$app->user->identity->numeroDocumento;
        $tarjetasUsuario = UsuarioTarjetaMas::callWSConsultarTarjetasAbonado($cedula);

        $provider = new ArrayDataProvider([
            'allModels' => $tarjetasUsuario,
            'sort' => [
                'attributes' => ['NUMEROTARJETA', 'ESTADOTARJETA', 'PORCENTAJE', 'FECHAACTIVACION', 'FECHAVENCIMIENTO', 'DESCUENTOSDISPONIBLES', 'PRINCIPAL'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('tarjetas', [
                    'dataProvider' => $provider
        ]);
    }

    /**
     * Funcion para ver las tarjetas de el usuario loguado
     * @param none
     * @return <tag> html,
     */
    public function actionVer() {


        if ($_POST != null) {

            $numeroTarjeta = $_POST['numeroTarjeta'];
            $tarjetasUsuario = UsuarioTarjetaMas::callWSConsultarMovimientos($numeroTarjeta);

            $provider = new ArrayDataProvider([
                'allModels' => $tarjetasUsuario,
                'sort' => [
                    'attributes' => ['FECHA', 'TRANSACCION', 'VALORVENTA', 'VALORDESCUENTO', 'PDV', 'CAJA', 'FACTURA'],
                ],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
            return $this->render('movimientos', [
                        'dataProvider' => $provider
            ]);
        }
    }

    /**
     * Funcion para ver las tarjetas de el usuario loguado
     * @param none
     * @return <tag> html,
     */
    public function actionSuspender() {
        if ($_POST != null) {
            $cedula = \Yii::$app->user->identity->numeroDocumento;
            $numeroTarjeta = $_POST['numeroTarjeta'];
            $respuesta = UsuarioTarjetaMas::callWSSuspenderTarjetaWeb($cedula, $numeroTarjeta);
            if ($respuesta[0]['CODIGO'] == 1) {
                Yii::$app->session->setFlash('success', 'La tarjeta ha sido suspendida con éxito');
                return $this->redirect('mis-tarjetas');
            } else {
                Yii::$app->session->setFlash('ERROR', $respuesta[0]['MENSAJE']);
                return $this->redirect('mis-tarjetas');
            }
        }
    }

    public function actionActivarTarjeta() {

        $model = new ActivarForm();

        if ($model->load(Yii::$app->request->post())) {
            $cedula = \Yii::$app->user->identity->numeroDocumento;
            $numeroTarjeta = $model->numeroTarjeta;
            $respuesta = UsuarioTarjetaMas::callWSActivarTarjetaWeb($cedula, $numeroTarjeta);

            if ($respuesta[0]['CODIGO'] == 1) {
                Yii::$app->session->setFlash('success', $respuesta[0]['MENSAJE']);
                return $this->redirect('mis-tarjetas');
            } else {
                $model->addError('numeroTarjeta', $respuesta[0]['MENSAJE']);
            }
        }

        return $this->render('activar-tarjeta', ['model' => $model]);
    }

    /**
     * Funcion para ver las tarjetas de el usuario loguado
     * @param none
     * @return <tag> html,
     */
    public function actionHacerPrimaria() {
        if ($_POST != null) {
            $cedula = \Yii::$app->user->identity->numeroDocumento;
            $numeroTarjeta = $_POST['numeroTarjeta'];
            $tarjetasUsuario = UsuarioTarjetaMas::callWSConsultarTarjetasAbonado($cedula);

            $principal = "";
            foreach ($tarjetasUsuario as $tarjeta) {
                if ($tarjeta['PRINCIPAL'] == "SI") {
                    $principal = $tarjeta["NUMEROTARJETA"];
                }
            }
            $respuesta = UsuarioTarjetaMas::callWSCambiarTarjetaPrimaria($principal, $cedula, $numeroTarjeta);
            
            if ($respuesta[0]['CODIGO'] == 1) {
                Yii::$app->session->setFlash('success', "La tarjeta $numeroTarjeta ha sido marca como principal");
                return $this->redirect('mis-tarjetas');
            } else {
                Yii::$app->session->setFlash('error', $respuesta[0]['MENSAJE']);
                return $this->redirect('mis-tarjetas');
            }
        }


        $this->redirect('mis-tarjetas');
    }

    
    public function actionDatosRegistro() {
        $model = new UsuarioTarjetaMas();
        $model->scenario = 'registroDatos';

        if ($model->load(Yii::$app->request->post())) {
            $modelUsuario = new Usuario;
            $modelUsuario->numeroDocumento = $model->numeroDocumento;
            $modelUsuario->estado = Usuario::ESTADO_ACTIVO;
            $modelUsuario->codigoPerfil = \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['codigo'];
            $modelUsuario->contrasena = md5($model->password);

            if ($modelUsuario->save() && $model->save()) {

                $modelLogin = new LoginForm();
                $modelLogin->username = $model->numeroDocumento;
                $modelLogin->password = $model->password;

                if ($modelLogin->login()) {
                    return $this->redirect(['index']);
                } else {
                    return $this->redirect(['sitio/index']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Error al realizar el registro');
            }
        }
        return $this->render('datos-registro', [
                    'model' => $model,
        ]);
    }

    public function actionAutenticar() {

        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new LoginForm();
        $model->scenario = 'login';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->redirect(['index']);
        }

        return $this->render('autenticar', [
                    'model' => $model,
        ]);
    }

    public function actionCambiarClave() {
        $model = new LoginForm();
        $model->username = \Yii::$app->user->identity->numeroDocumento;
        $model->scenario = 'cambiarClave';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $usuario = $this->findModelUsuario($model->username);
            $usuario->contrasena = md5($model->password);
            if ($usuario->save()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('cambiar-clave', [
                    'model' => $model,
        ]);
    }

    public function actionRecordarClave() {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $usuario = Usuario::findOne(['numeroDocumento' => $model->username, 'estado' => 1]);

            if (!$usuario) {
                $model->addError('username', 'Usuario no existe');
            } else {

                $codigoRecuperacion = $usuario->generarCodigoRecuperacion();
                $fecha = new \DateTime();

                //se guarda el codigo y la fecha de recuperacion
                $objRecuperacionClave = new RecuperacionClave();
                $objRecuperacionClave->numeroDocumento = $usuario->numeroDocumento;
                $objRecuperacionClave->recuperacionCodigo = $codigoRecuperacion;
                $objRecuperacionClave->recuperacionFecha = $fecha->format('Y-m-d H:i:s');

                if ($objRecuperacionClave->save()) {

                    $value = $this->enviarCorreo($codigoRecuperacion, $usuario->objUsuarioTarjetaMas->correo);

                    if ($value) {
                        Yii::$app->session->setFlash('success', 'Revisa Tu correo');
                    } else {
                        Yii::$app->session->setFlash('error', 'Error al enviar el correo');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Error al enviar el correo');
                }
            }
        }

        return $this->render('recordar-clave', [
                    'model' => $model,
        ]);
    }

    private function enviarCorreo($codigoRecuperacion, $correoUsuario) {

        //se crea el enlace para restablecer la contraseña y el contenido del email
        $enlace = yii::$app->urlManager->createAbsoluteUrl(['tarjetamas/usuario/reestablecer-clave', 'codigo' => $codigoRecuperacion]);
        $contenido_mail = "Ingresa a la siguiente direccion para reestalecer tu contraseña.\n" . $enlace;

        // envia correo
        $value = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                        ->setTo($correoUsuario)->setSubject('Recuperacion Contraseña TarjetaMas')
                        ->setHtmlBody($contenido_mail)->send();

        return $value;
    }

    public function actionReestablecerClave($codigo) {

        $model = new LoginForm();
        $model->scenario = 'cambiarClave';

        if ($model->load(Yii::$app->request->post())) {

            $objRecuperacionClave = $this->findModelRecuperacionClave($codigo);
            $usuario = $this->findModelUsuario($objRecuperacionClave->numeroDocumento);
            $usuario->contrasena = md5($model->password);
            $model->username = $usuario->numeroDocumento;

            if ($usuario->save() && $model->login()) {

                return $this->redirect(['index']);
            } else {

                $model->addError($model->password, 'Error al reestablecer la clave');
            }
        }

        return $this->render('reestablecer-clave', [
                    'model' => $model,
        ]);
    }

    public function actionActualizarDatos() {

        $model = $this->findModelUsuarioTarjetaMas(Yii::$app->user->identity->numeroDocumento);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('actualizar-datos', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Ecuentra un modelo UsuarioTarjetaMas basado en su llave pimaria .
     * @param string $id
     * @return UsuarioTarjetaMas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelUsuarioTarjetaMas($id) {
        if (($model = UsuarioTarjetaMas::findOne(['numeroDocumento' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelUsuario($numeroDocumento) {
        if (($model = Usuario::findOne(['numeroDocumento' => $numeroDocumento, 'estado' => 1])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested does not exist.');
        }
    }

    protected function findModelRecuperacionClave($codigo) {

        $model = RecuperacionClave::find()->where(['recuperacionCodigo' => $codigo])->orderBy('recuperacionFecha DESC')->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested does not exist.');
        }
    }

    public function actionSalir() {
        Yii::$app->user->logout();
        $this->redirect(['/tarjetamas']);
    }

}

?>
