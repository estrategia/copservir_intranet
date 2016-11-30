<?php

namespace app\modules\proveedores\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\imagine\Image;
use yii\httpclient\Client;
use Imagine\Image\Box;
use Imagine\Image\Point;
use app\modules\proveedores\models\UsuarioProveedor;
use app\modules\proveedores\models\UsuarioProveedorSearch;
use app\modules\proveedores\models\LoginForm;
use app\modules\intranet\models\ConexionesUsuarios;
use app\modules\intranet\models\Funciones;
use app\modules\intranet\models\Ciudad;
use app\modules\intranet\models\FotoForm;
use app\modules\intranet\models\RecuperacionClave;
use app\models\SIICOP;
use app\models\Usuario;

/**
 * UsuarioController implements the CRUD actions for UsuarioProveedor model.
 */
class UsuarioController extends Controller
{
	public $defaultAction = "admin";
    /**
     * @inheritdoc
     */
	public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            	'only' => [
            		'admin', 'ver', 'crear', 'actualizar', 'cambiar-foto-perfil'
            	],
                'redirectUri' => ['/proveedores/usuario/autenticar']
            ],

            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'index', 'ver', 'crear', 'actualizar'
                ],
                'authsActions' => [
                    'admin' => 'proveedores_admin',
                    'ver' => 'proveedores_admin',
                    'crear' => 'proveedores_admin',
                    'actualizar' => 'proveedores_admin',
                    // 'admin' => 'proveedores_usuario_admin',
                    // 'ver' => 'proveedores_usuario_admin',
                    // 'crear' => 'proveedores_usuario_admin',
                    // 'actualizar' => 'proveedores_usuario_admin',
                    // 'exportar-usuarios' => 'visitaMedica_usuario_exportar-usuarios'
                ],
           ],
        
        ];
    }

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
            ],
        ];
    }

    /**
     * Lists all UsuarioProveedor models.
     * @return mixed
     */

    public function actionAutenticar() {

        $model = new LoginForm();
        // $model->scenario = 'login';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $objConexionesUsuario = new ConexionesUsuarios();
            $objConexionesUsuario->numeroDocumento = $model->username;
            $objConexionesUsuario->fechaConexion = date('YmdHis');
            $objConexionesUsuario->ip = $objConexionesUsuario->getRealIp(); //Yii::$app->getRequest()->getUserIP() ;
            $objConexionesUsuario->save();
          return $this->redirect(['/proveedores']);
        }

        return $this->render('/sitio/login', [
          'model' => $model,
        ]);
    }

    public function actionPruebaUnidades()
    {
        $unidadesNegocio = SIICOP::wsGetUnidadesNegocio();
        var_dump($unidadesNegocio);
        
    }

    public function actionSalir() {

        if (Yii::$app->user->isGuest) {
            return $this->redirect(['autenticar']);
            exit();
        }
        Yii::$app->user->logout();
        $model = new LoginForm();
        $this->redirect(['autenticar', ['model' => $model]]);
    }

    public function actionAdmin()
    {
        $searchModel = new UsuarioProveedorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, Yii::$app->user->identity->objUsuarioProveedor->nitLaboratorio, false, \Yii::$app->controller->module->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsuarioProveedor model.
     * @param string $id
     * @return mixed
     */
    public function actionVer($id)
    {   
        $model = $this->findModel(Yii::$app->request->get()['id']);
        if (Yii::$app->request->post()) {
            $permisosUsuario = Yii::$app->request->post();
            unset($permisosUsuario['_csrf']);
           
            $diff = $model->permisosFaltantes($model->getPermisosAsignacion(), $permisosUsuario);
            // VarDumper::dump($permisosUsuario,10,true);exit();
            if (!empty($permisosUsuario)) {
                $model->asignarPermisos($permisosUsuario);
            }
            $model->removerPermisos($diff);

        }
        return $this->render('view', [
            'model' => $model,
            'permisos' => $model->getPermisosAsignacion(),
            'permisosAsignados' => $model->getPermisosAsignados(),
        ]);
    }

    /**
     * Creates a new UsuarioProveedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear()
    {      
        $usuarioProveedor = new UsuarioProveedor();
        $ciudades = ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad');
        $terceros = $this->getTerceros();
        $unidadesNegocio = SIICOP::wsGetUnidadesNegocio(1);
        $tercerosSelect = ArrayHelper::map($terceros, 'NumeroDocumento', 'Nombre');
        $laboratorio = null;

        if ($usuarioProveedor->load(Yii::$app->request->post()) && $usuarioProveedor->validate()) {
            $usuarioProveedor->modulo = \Yii::$app->controller->module->id;
            $documento = Yii::$app->request->post()['UsuarioProveedor']['numeroDocumento'];
            $documentoLaboratorio = Yii::$app->user->identity->objUsuarioProveedor->nitLaboratorio;
            $idAgrupacion = Yii::$app->request->post()['UsuarioProveedor']['idAgrupacion'];
            foreach($terceros as $tercero) {
                if ($documentoLaboratorio == $tercero['NumeroDocumento']) {
                    $laboratorio = $tercero;
                    break;
                }
            }
            $usuarioProveedor->idTercero = $laboratorio['IdTercero'];
            $usuarioProveedor->idFabricante = $laboratorio['IdFabricante'];
            $usuarioProveedor->nombreLaboratorio = $laboratorio['Nombre'];
            $usuarioProveedor->nitLaboratorio = $laboratorio['NumeroDocumento'];
            $usuarioProveedor->idAgrupacion = $idAgrupacion;
            if(array_key_exists($idAgrupacion, $unidadesNegocio)) {
                $usuarioProveedor->nombreUnidadNegocio = $unidadesNegocio[$idAgrupacion];
            }

            $usuarioIntranet = new \app\models\Usuario();
            $usuarioIntranet->numeroDocumento = $documento;
            $contrasena = Funciones::generatePass(8);
            $usuarioIntranet->contrasena = md5($contrasena);
            // $usuarioIntranet->codigoPerfil = (int) Yii::$app->params['PerfilesUsuario']['visitaMedica'];
            $usuarioIntranet->nombrePortal = Yii::$app->controller->module->id;
            $usuarioIntranet->estado = true;

            // var_dump($usuarioProveedor);

            if ($usuarioIntranet->save() && $usuarioProveedor->save()) {
                try {
                    $connection->createCommand()
                    ->insert('auth_assignment', [
                        'user_id' => $documento,
                        'item_name' => 'proveedores_usuario',
                    ])->execute();  
                    $transaction->commit();

                } catch (Exception $e) {

                    $transaction->rollBack();
                    throw $e;
                }
                $infoUsuario = [
                    'usuario' => $usuarioIntranet->numeroDocumento,
                    'password' => $contrasena,
                ];
                $contenidoCorreo = $this->renderPartial('_notificacionRegistro',['infoUsuario' => $infoUsuario, 'laboratorio' => $laboratorio['Nombre'], 'nombreUsuario' => $usuarioProveedor->nombre]);
                $correoEnviar = $this->renderPartial('/common/correo', ['contenido' => $contenidoCorreo]);
                $correoEnviado = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                                        ->setTo($usuarioProveedor->email)->setSubject('Acceso Portal Colaborativo Copservir')
                                        ->setHtmlBody($correoEnviar)->send();

                return $this->redirect(['ver', 'id' => $usuarioProveedor->numeroDocumento]);
            }

        } else {
            return $this->render('create', [
                'model' => $usuarioProveedor,
                'terceros' => $tercerosSelect,
                'unidadesNegocio' => $unidadesNegocio,
                'ciudades' => $ciudades,
            ]);
        }
    }

    /**
     * Updates an existing UsuarioProveedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $usuarioProveedor = $this->findModel($id);
        $terceros = $this->getTerceros();
        $unidadesNegocio = SIICOP::wsGetUnidadesNegocio(1);
        $ciudades = ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad');
        // array_unshift($unidadesNegocio, '(no definido)');  // $unidadesNegocio
        $tercerosSelect = ArrayHelper::map($terceros, 'NumeroDocumento', 'Nombre');
        $laboratorio = null;

        if ($usuarioProveedor->load(Yii::$app->request->post())) {
            $documentoLaboratorio = Yii::$app->user->identity->objUsuarioProveedor->nitLaboratorio;;
            $idAgrupacion = Yii::$app->request->post()['UsuarioProveedor']['idAgrupacion'];
            foreach($terceros as $tercero) {
                if ($documentoLaboratorio == $tercero['NumeroDocumento']) {
                    $laboratorio = $tercero;
                    break;
                }
            }
            $usuarioProveedor->idTercero = $laboratorio['IdTercero'];
            $usuarioProveedor->idFabricante = $laboratorio['IdFabricante'];
            $usuarioProveedor->nombreLaboratorio = $laboratorio['Nombre'];
            $usuarioProveedor->nitLaboratorio = $laboratorio['NumeroDocumento'];
            $usuarioProveedor->idAgrupacion = $idAgrupacion;
            if(array_key_exists($idAgrupacion, $unidadesNegocio)) {
                $usuarioProveedor->nombreUnidadNegocio = $unidadesNegocio[$idAgrupacion];
            }

            if ($usuarioProveedor->save()) {
                return $this->redirect(['ver', 'id' => $usuarioProveedor->numeroDocumento]);
            }
        } else {
            return $this->render('update', [
                'model' => $usuarioProveedor,
                'terceros' => $tercerosSelect,
                'unidadesNegocio' => $unidadesNegocio,
                'ciudades' => $ciudades,
            ]);
        }
    }

    public function actionActualizarMiCuenta()
    {
        $documento =  Yii::$app->user->identity->numeroDocumento;
        // var_dump($documento);
        $usuarioVimed = UsuarioProveedor::findOne(['numeroDocumento' => $documento]);
        $ciudades = ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad');

        $client = new Client();
        $url = Yii::$app->params['webServices']['lrv'] . '/profesion';

        $response = $client->createRequest()
        ->setMethod('get')
        ->setUrl($url)
        ->setData([])
        ->setOptions([
            'timeout' => 5, // set timeout to 5 seconds for the case server is not responding
        ])
        ->send();
        $profesiones = ArrayHelper::map($response->data['response'], 'idProfesion', 'nombreProfesion');

        // var_dump(Yii::$app->user->identity->numeroDocumento);
        // var_dump($usuarioVimed);
        if ($usuarioVimed->load(Yii::$app->request->post())) {
            $idProfesion = Yii::$app->request->post()['UsuarioProveedor']['idProfesion'];
            $usuarioVimed->profesion = $profesiones[$idProfesion];
            $usuarioVimed->idProfesion = $idProfesion;
            if ($usuarioVimed->save()) {
                return $this->redirect('mi-cuenta');
            }
        } else {
            return $this->render('actualizarMiCuenta', [
                'model' => $usuarioVimed,
                'ciudades' => $ciudades,
                'profesiones' => $profesiones,
            ]);
        }
    }

    public function actionMiCuenta()
    {
        $intranetUser = \app\models\Usuario::findOne(Yii::$app->user->identity->idUsuario);
        $proveedoresUser = UsuarioProveedor::findOne(['numeroDocumento', $intranetUser->numeroDocumento]);
        return $this->render('miCuenta', ['model' => $proveedoresUser]);
    }

    public function actionCambiarFotoPerfil() {
        $modelFoto = FotoForm::find()->where(['numeroDocumento' => \Yii::$app->user->identity->numeroDocumento, 'estado' => 1])->one();
        $errorFotoPerfil = false;
        // $modelFoto = new FotoForm();
        if ($modelFoto->load(Yii::$app->request->post())) {
            // llamar al webservice y mandar los datos
            {

                $usuario = \app\models\Usuario::findOne(['numeroDocumento' => \Yii::$app->user->identity->numeroDocumento, 'estado' => 1]);
                $modelFoto->imagenPerfil =  UploadedFile::getInstances($modelFoto, 'imagenPerfil');
                try {
                    if ($modelFoto->imagenPerfil) {
                        foreach ($modelFoto->imagenPerfil as $file) {
                            if (isset(Json::decode($modelFoto->crop_info)[0])) {
                                $nombreImagen = Yii::$app->user->identity->numeroDocumento;
                                $rutaImagen = "$nombreImagen.$file->extension";
                                $rutaImagenAnterior = $usuario->imagenPerfil;
                                $file->saveAs(Yii::getAlias('@webroot') . '/img/fotosperfil/' . $rutaImagen);
                                $image = Image::getImagine()->open(Yii::getAlias('@webroot') . '/img/fotosperfil/' . $rutaImagen);

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
                                    unlink(Yii::getAlias('@webroot') . "/img/fotosperfil/" . $rutaImagenAnterior);
                                }
                            } else {
                                $errorFotoPerfil = true;
                            }
                        }
                    }
                } catch (\Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
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
      Accion para enviar un email con un enlace donde puede reestablecer su clave
     */

    public function actionRecordarClave() {

        $correoUsuario = '';
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['/proveedores']);
        }

        $model = new LoginForm();
        $model->scenario = 'recuperar';
        $fechaRecuperacion = new \DateTime();

        if ($model->load(Yii::$app->request->post())) {
            $infoUsuario = UsuarioProveedor::find()->where(['numeroDocumento' => $model->username])->one();
            // var_dump($infoUsuario);exit();
            if (!isset($infoUsuario)) {
                $model->addError('username', 'Usuario inactivo/no existe');
            } else {
                if (isset($infoUsuario->email)) {
                    $correoUsuario = trim($infoUsuario->email);
                }
                if (empty($correoUsuario)) {
                    $model->addError('username', 'Usuario no tiene correo registrado');
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
                        $enlace = yii::$app->urlManager->createAbsoluteUrl(['proveedores/usuario/reestablecer-clave', 'codigo' => $codigoRecuperacion]);
                        $contenido_mail = $this->renderPartial('_correoRecordar', ['enlace' => $enlace, 'infoUsuario' => $infoUsuario]);
                        $contenido_enviar = $this->renderPartial('/common/correo', ['contenido' => $contenido_mail]);

                        // envia correo
                        $value = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                                        ->setTo($correoUsuario)->setSubject('Recuperacion Contraseña Portal proveedores')
                                        ->setHtmlBody($contenido_enviar)->send();

                        if ($value) {
                            return $this->render('mensajeRecuperacion', ['correo' => $correoUsuario]);
                        } else {
                            $model->addError('username', 'Error al enviar el correo');
                        }
                    } else {
                        $model->addError('username', 'Ocurrio un error por favor vuelve a intentarlo');
                    }
                }
            }
        }

        return $this->render('recordarClave', [
                    'model' => $model,
        ]);
    }

    public function actionReestablecerClave($codigo) {

        // $this->layout = 'loginLayout';
        $model = new LoginForm();
        $model->scenario = 'cambiarClave';

        if ($model->load(Yii::$app->request->post())) {

            $fecha = new \DateTime;
            $fecha->modify('+' . \Yii::$app->params['usuario']['tiempoRecuperarClave'] . ' days');

            $objRecuperacionClave = RecuperacionClave::find()->where(['recuperacionCodigo' => $codigo])
                            ->andWhere(['<=', 'recuperacionFecha', $fecha->format('Y-m-d H:i:s')])
                            ->orderBy('recuperacionFecha DESC')->one();

            if ($objRecuperacionClave === null) {
                $model->addError('password2', 'Usuario sin codigo de recuperacion');
            } else {

                $infoUsuario = Usuario::find()->where(['numeroDocumento' => $objRecuperacionClave->numeroDocumento])->one();

                $infoUsuario->contrasena = md5($model->password);

                // $response = self::callWSCambiarClave($objRecuperacionClave->numeroDocumento, sha1($model->password));
                // if ($response) {
                if ($infoUsuario->save()) {
                    return $this->render('mensajeReestablecer');
                    /*
                      Yii::$app->session->setFlash('success', 'contraseña reestablecida con exito');
                      $model = new LoginForm();
                     */
                } else {
                    Yii::$app->session->setFlash('error', 'Ocurrio un error, No se pudo reestablecer la contraseña');
                }
            }
        }

        return $this->render('reestablecerClave', [
                    'model' => $model,
        ]);
    }

    public function actionCambiarClave() {

        $model = new LoginForm();
        $model->username = \Yii::$app->user->identity->numeroDocumento;
        $model->scenario = 'cambiarClave';

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // $response = self::callWSCambiarClave($model->username, sha1($model->password));
            $documento = Yii::$app->user->identity->numeroDocumento;
            $infoUsuario = Usuario::find()->where(['numeroDocumento' => $documento])->one();
            $infoUsuario->contrasena = md5($model->password);

            if ($infoUsuario->save()) {
                Yii::$app->session->setFlash('success', 'La contrase&ntilde;a se cambi&oacute; con &eacute;xito');
                return $this->redirect(['mi-cuenta']);
            } else {
                Yii::$app->session->setFlash('error', 'Error al cambiar la contrase&ntilde;a');
            }
        }

        return $this->render('cambiarClave', [
                    'model' => $model,
        ]);
    }


    /**
     * Deletes an existing UsuarioProveedor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    // public function actionDelete($id)
    // {
    //     $this->findModel($id)->delete();

    //     return $this->redirect(['index']);
    // }

    /**
     * Finds the UsuarioProveedor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return UsuarioProveedor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsuarioProveedor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function getTerceros() {

        ini_set("soap.wsdl_cache_enabled", 0);

        // $condiciones = array();
        //$condiciones['idSede']['valor'] = 2;
        //$condiciones['centroCosto']['valor'] = "003";
        //$condiciones['puntosVenta']['valor'] = "124";
        //$condiciones['puntosVenta']['condicional'] = 'OR';
        //$condiciones['nombreZona']['valor'] = 'cali';
        //$condiciones['nombreZona']['like'] = true;

        $client = new \SoapClient(Yii::$app->params['webServices']['productos']['terceros']);
        $arr = $client->getTerceros();

        if ($arr === null) {
            echo "NULL ERROR";
        } else {
            return $arr;
        }

        // CVarDumper::dump($arr, 100, true);
        // print_r($var);
        // foreach ($arr as $zona) {
        //     echo $zona['IDZona'] . " - " . $zona['NombreZona'] . " - " . $zona['IDSede'];
        //     echo "<br>";
        // }
        print_r($arr);
    }
}
