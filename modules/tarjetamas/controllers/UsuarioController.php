<?php

namespace app\modules\tarjetamas\controllers;

use Yii;
use yii\web\Controller;
use app\modules\tarjetamas\models\formularios\LoginForm;
use app\modules\tarjetamas\models\formularios\RegistroForm;
use app\modules\tarjetamas\models\UsuarioTarjetaMas;
use app\modules\intranet\models\RecuperacionClave;
use app\models\Usuario;
use app\modules\intranet\models\AuthAssignment;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\modules\tarjetamas\models\formularios\ActivarForm;
use yii\helpers\Url;
use yii\helpers\Json;

class UsuarioController extends Controller {

    const USUARIO_TIENE_TARJETAS = 1;

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'index', 'cambiar-clave', 'actualizar-datos', 'suspender', 'ver', 'hacer-primaria', 'activar-tarjeta'
                ],
                'redirectUri' => ['/tarjetamas/sitio/index']
            ],
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'mis-tarjetas',
                ],
                'redirectUri' => ['/tarjetamas/usuario/autenticar']
            ],
            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'index', 'mis-tarjetas', 'confirmar-bloqueo', 'ver', 'suspender', 'activar-tarjeta', 'hacer-primaria', 'cambiar-clave', 'actualizar-datos'
                ],
                'authsActions' => [
                    'index' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'mis-tarjetas' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'confirmar-bloqueo' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'ver' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'suspender' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'activar-tarjeta' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'hacer-primaria' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'cambiar-clave' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                    'actualizar-datos' => Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'],
                ]
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
			$usuarioTarjeta = UsuarioTarjetaMas::findOne(['numeroDocumento' => $model->username]);
			
			if(!$usuarioTarjeta){
	            if ($response[0]['CODIGO'] == self::USUARIO_TIENE_TARJETAS) {
	                return $this->redirect(['datos-registro', 'numeroDocumento' => $model->username]);
	            } else {
	                $model->addError('username', $response[0]['MENSAJE']);
	            }
			}else{
				$model->addError('username', "Ya se encuentra registrado en el portal");
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

        if ($tarjetasUsuario[0]['CODIGO'] == 1) {
            $provider = new ArrayDataProvider([
                'allModels' => $tarjetasUsuario,
                'sort' => [
                    'attributes' => ['NUMEROTARJETA', 'ESTADOTARJETA', 'PORCENTAJE', 'FECHAACTIVACION', 'FECHAVENCIMIENTO', 'DESCUENTOSDISPONIBLES', 'PRINCIPAL'],
                ],
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);
        } else {
            $provider = null;
            Yii::$app->session->setFlash('ERROR', $tarjetasUsuario[0]['MENSAJE']);
        }
        return $this->render('tarjetas', [
                    'dataProvider' => $provider
        ]);
    }

    public function actionConfirmarBloqueo() {
        if ($_POST) {
            return $this->renderPartial('_modalBloqueo', ['dataTarjeta' => $_POST['dataTarjeta']]);
        }
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
            // $respuesta[0]['CODIGO'] = 1;
            if ($respuesta[0]['CODIGO'] == 1) {
                Yii::$app->session->setFlash('success', 'La tarjeta ha sido suspendida con éxito');
                // return $this->redirect('mis-tarjetas');
                echo JSON::encode([
                    'result' => 'ok',
                    'response' => Url::toRoute('mis-tarjetas')
                ]);
            } else {
                Yii::$app->session->setFlash('ERROR', $respuesta[0]['MENSAJE']);
                echo JSON::encode([
                    'result' => 'ok',
                    'response' => Url::toRoute('mis-tarjetas')
                ]);
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
                $cedula = \Yii::$app->user->identity->numeroDocumento;
                $tarjetasUsuario = UsuarioTarjetaMas::callWSConsultarTarjetasAbonado($cedula);
                $tarjetaArray = array();
                foreach ($tarjetasUsuario as $tarjeta) {
                    if ($tarjeta['NUMEROTARJETA'] == $numeroTarjeta) {
                        $tarjetaArray[] = $tarjeta;
                        break;
                    }
                }

                if ($tarjetaArray) {
                    $provider = new ArrayDataProvider([
                        'allModels' => $tarjetaArray,
                        'sort' => [
                            'attributes' => ['NUMEROTARJETA', 'ESTADOTARJETA', 'PORCENTAJE', 'FECHAACTIVACION', 'FECHAVENCIMIENTO', 'DESCUENTOSDISPONIBLES', 'PRINCIPAL'],
                        ],
                        'pagination' => [
                            'pageSize' => 10,
                        ],
                    ]);
                } else {
                    $provider = null;
                    Yii::$app->session->setFlash('danger', $respuesta[0]['MENSAJE']);
                }
                return $this->render('tarjetas', [
                            'dataProvider' => $provider
                ]);
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

    public function actionDatosRegistro($numeroDocumento = null) {
        $model = new UsuarioTarjetaMas();
        $model->scenario = 'usuarioExistente';
        
		 if ($model->load(Yii::$app->request->post())) {
			$model->numeroDocumento = $numeroDocumento;
            $transaction = UsuarioTarjetaMas::getDb()->beginTransaction();
            try {

                $modelUsuario = Usuario::findOne(['numeroDocumento' => $model->numeroDocumento]);
                $variableActivacion = null;
               
                if($modelUsuario == null){
                    $modelUsuario = new Usuario;
                    $modelUsuario->numeroDocumento = $model->numeroDocumento;
                    $modelUsuario->estado = Usuario::ESTADO_INACTIVO;
                    //$modelUsuario->codigoPerfil = \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['codigo'];
                    $modelUsuario->contrasena = md5($model->password);
                    $variableActivacion = $model->codigoActivacion = $modelUsuario->generarCodigoRecuperacion();
                    
                    if (!$modelUsuario->save()) {
                        throw new \Exception("Error realizar el registro:" . Json::encode($modelUsuario->getErrors()), 501);
                    } 
                    $model->scenario = 'registroDatos';
                }else{
                    $objAuthAssignment = AuthAssignment::find()
                        ->where("item_name=:rol AND user_id=:usuario", [':rol' => \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'], ':usuario' => $modelUsuario->numeroDocumento])
                        ->one();
                        
                    if ($objAuthAssignment == null) {
                        $objAuthAssignment = new AuthAssignment;
                        $objAuthAssignment->user_id = $modelUsuario->numeroDocumento;
                        $objAuthAssignment->item_name = \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'];
                        $objAuthAssignment->created_at = strtotime(date('Y-m-d H:i:s'));
                        if(!$objAuthAssignment->save()){
                            throw new \Exception("Error realizar el registro:" . Json::encode($objAuthAssignment->getErrors()), 504);
                        };
                    }
                }
                if(!$model->save()){
                    throw new \Exception("Error realizar el registro:" . Json::encode($model->getErrors()), 502);
                }
                 
                $value = $this->enviarCorreoActivacion($variableActivacion, $model->correo, $model);
                
                if(!$value){
                    throw new \Exception("Error al enviar correo electr&oacute;nico", 503);
                } 

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Revisa tu correo y sigue las instrucciones para activar tu cuenta');
                     

            } catch (Exception $e) {

                $transaction->rollBack();
                Yii::$app->session->setFlash('error', "[".$e->getCode()."] ".$e->getMessage());
                throw $e;
            }
           
        }else{
            $modelUsuario= Usuario::findOne(['numeroDocumento' => $numeroDocumento]);
           
            if($modelUsuario == null){
                 $model->scenario = 'registroDatos';
            }
        }
        $model->numeroDocumento = $numeroDocumento;

        return $this->render('datos-registro', [
                    'model' => $model,
        ]);
    }

    private function enviarCorreoActivacion($codigoRecuperacion, $correoUsuario, $model) {

        //se crea el enlace para restablecer la contraseña y el contenido del email
       if($codigoRecuperacion != null){
            $enlace = yii::$app->urlManager->createAbsoluteUrl(['tarjetamas/usuario/activar-cuenta', 'codigo' => $codigoRecuperacion]);
            $contenido_mail = "Ingresa a la siguiente direccion activar tu cuenta en el portal Tarjeta Mas.\n" . $enlace;
       }else{
            $contenido_mail = "Bienvenido al portal de Tarjeta Mas. Tus datos:<br/>
                               Usuario: $model->numeroDocumento<br/>
                               Contraseña: La contraseña asignada es la misma que usaste en el portal de proveedores.";
       } 
        // envia correo
        $value = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                        ->setTo($correoUsuario)->setSubject('Activacion Cuenta TarjetaMas')
                        ->setHtmlBody($contenido_mail)->send();

        return $value;
    }

    public function actionActivarCuenta($codigo) {
        $model = UsuarioTarjetaMas::find()->where(['codigoActivacion' => $codigo])->one();

        if ($model !== null) {
            $modelUsuario = Usuario::findOne(['numeroDocumento' => $model->numeroDocumento]);
            $modelUsuario->estado = Usuario::ESTADO_ACTIVO;
            if ($modelUsuario->save()) {
                $objAuthAssignment = AuthAssignment::find()
                        ->where("item_name=:rol AND user_id=:usuario", [':rol' => \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'], ':usuario' => $modelUsuario->numeroDocumento])
                        ->one();
                if ($objAuthAssignment == null) {
                    $objAuthAssignment = new AuthAssignment;
                    $objAuthAssignment->user_id = $modelUsuario->numeroDocumento;
                    $objAuthAssignment->item_name = \Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'];
                    $objAuthAssignment->created_at = strtotime(date('Y-m-d H:i:s'));
                    $objAuthAssignment->save();
                }

                Yii::$app->session->setFlash('success', 'Cuenta activada con éxito, Ya puedes iniciar sesión');
            } else {
                Yii::$app->session->setFlash('error', 'Error al activar la cuenta, este usuario no se ha registrado');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Error al activar la cuenta, este usuario no se ha registrado');
        }

        return $this->render('activar-cuenta', []);
    }

    public function actionAutenticar() {

        if (!\Yii::$app->user->isGuest && \Yii::$app->user->identity->tienePermiso(\Yii::$app->params['PerfilesUsuario']['tarjetaMas']['permiso'])) {
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
        $contenido_mail = "Ingresa a la siguiente direccion para reestablecer tu contraseña.\n" . $enlace;

        // envia correo
        $value = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                        ->setTo($correoUsuario)->setSubject('Recuperacion Contraseña TarjetaMas')
                        ->setHtmlBody($contenido_mail)->send();

        return $value;
    }

    public function actionReestablecerClave($codigo) {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['index']);
        }

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
