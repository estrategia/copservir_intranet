<?php

namespace app\modules\intranet\controllers;

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
use app\models\SIICOP;
use app\modules\intranet\models\Ciudad;
use app\modules\intranet\models\FotoForm;
/**
 * UsuarioController implements the CRUD actions for UsuarioProveedor model.
 */
class UsuarioProveedorController extends Controller
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
                    // 'admin' => 'proveedores_admin',
                    // 'ver' => 'proveedores_admin',
                    // 'crear' => 'proveedores_admin',
                    // 'actualizar' => 'proveedores_admin',
                    'admin' => 'intranet_usuario-proveedor_admin',
                    'ver' => 'intranet_usuario-proveedor_ver',
                    'crear' => 'intranet_usuario-proveedor_crear',
                    'actualizar' => 'intranet_usuario-proveedor_actualizar',
                    'cambiar-estado' => 'intranet_usuario-proveedor_admin',
                ],
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
          return $this->redirect(['/proveedores/visitamedica/productos/buscar']);
        }

        return $this->render('/sitio/login', [
          'model' => $model,
        ]);
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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '', false, '');
        $params = Yii::$app->request->queryParams;
        $filtrosUsuario = \Yii::$app->session->set(\Yii::$app->params['visitamedica']['session']['filtrosUsuario'], $params);
    //     // var_dump($filtrosUsuario = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['filtrosUsuario']));
    //     $dataProvider = $searchModel->search($params, $laboratorio, true, \Yii::$app->controller->module->id);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionExportarUsuarios()
    {
        
        //VarDumper::dump(\Yii::$app->controller->module->id,10,true);exit();

        $searchModel = new UsuarioProveedorSearch();
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setTitle("Usuarios Portal Proveedores");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getSheet(0)->setTitle('Usuarios');

        $objWorksheet = $objPHPExcel->getSheet(0);
        $objWorksheet->setTitle('Usuarios');

        $col = 0;
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, '# Documento');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Nombre');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Primer Apellido');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Segundo Apellido');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Fecha de Nacimiento');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Profesion');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Email');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Laboratorio');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Roles');

        $params = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['filtrosUsuario']);
        $laboratorio = null;
        
        if (Yii::$app->user->identity->objUsuarioProveedor!==null) {
           $laboratorio = Yii::$app->user->identity->objUsuarioProveedor->nitLaboratorio;
        }

        $dataProvider = $searchModel->search($params, $laboratorio, true, \Yii::$app->controller->module->id);

        // var_dump($dataProvider);

        // var_dump($dataProvider->getModels());

        foreach ($dataProvider->getModels() as $indice => $usuario ) {
            $col = 0;
            $fila = $indice + 2;
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->numeroDocumento );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->nombre );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->primerApellido );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->segundoApellido );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->fechaNacimiento);
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->profesion);
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->email );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->nombreLaboratorio);
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->getNombresRoles());
        }

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="usuarios_prov_' . date('YmdHis') . '.xls"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');
        // If you're serving to IE over SSL, then the following may be needed
        //header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }

    /**
     * Displays a single UsuarioProveedor model.
     * @param string $id
     * @return mixed
     */
    public function actionVer($id)
    {   
        $model = $this->findModel(Yii::$app->request->get()['id']);
        // if (Yii::$app->request->post()) {
        //     $permisosUsuario = Yii::$app->request->post();
        //     unset($permisosUsuario['_csrf']);
           
        //     $diff = $model->permisosFaltantes($model->getPermisosAsignacion(), $permisosUsuario);
        //     // VarDumper::dump($diff,10,true);

        //     $model->asignarPermisos($permisosUsuario);
        //     $model->removerPermisos($diff);

        // }
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
        $tercerosSelect = ArrayHelper::map($terceros, 'NumeroDocumento', 'RazonSocial');

        // VarDumper::dump($terceros, 10, true); echo "<br>";
        // VarDumper::dump($tercerosSelect, 10, true);
        // exit();
        $laboratorio = null;

        if ($usuarioProveedor->load(Yii::$app->request->post()) && $usuarioProveedor->validate()) {
            $usuarioProveedor->modulo = \Yii::$app->controller->module->id;
            $documento = Yii::$app->request->post()['UsuarioProveedor']['numeroDocumento'];
            $documentoLaboratorio = Yii::$app->request->post()['UsuarioProveedor']['nitLaboratorio'];
            // $idAgrupacion = Yii::$app->request->post()['UsuarioProveedor']['idAgrupacion'];
            foreach($terceros as $tercero) {
                if ($documentoLaboratorio == $tercero['NumeroDocumento']) {
                    $laboratorio = $tercero;
                    break;
                }
            }
            $usuarioProveedor->idTercero = $laboratorio['IdTercero'];
            $usuarioProveedor->idFabricante = $laboratorio['IdFabricante'];
            $usuarioProveedor->nombreLaboratorio = $laboratorio['RazonSocial'];
            $usuarioProveedor->nitLaboratorio = $laboratorio['NumeroDocumento'];
            // $usuarioProveedor->idAgrupacion = $idAgrupacion;
            // if(array_key_exists($idAgrupacion, $unidadesNegocio)) {
            //     $usuarioProveedor->nombreUnidadNegocio = $unidadesNegocio[$idAgrupacion];
            // }

            $usuarioIntranet = new \app\models\Usuario();
            $usuarioIntranet->numeroDocumento = $documento;
            $contrasena = Funciones::generatePass(8);
            $usuarioIntranet->contrasena = md5($contrasena);
            // $usuarioIntranet->codigoPerfil = (int) Yii::$app->params['PerfilesUsuario']['visitaMedica'];
            $usuarioIntranet->nombrePortal = 'proveedores';
            $usuarioIntranet->estado = true;

            // var_dump($usuarioProveedor);

            if ($usuarioIntranet->save() && $usuarioProveedor->save()) {
                $connection = \Yii::$app->db;
                $transaction = $connection->beginTransaction();
                try {
                    $connection->createCommand()
                    ->insert('auth_assignment', [
                        'user_id' => $documento,
                        'item_name' => 'proveedores_admin',
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
                $contenidoCorreo = $this->renderPartial('_notificacionRegistro',['infoUsuario' => $infoUsuario, 'laboratorio' => $laboratorio['RazonSocial'], 'usuarioProveedor' => $usuarioProveedor]);
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
        $ciudades = ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad');
        // array_unshift($unidadesNegocio, '(no definido)');  // $unidadesNegocio
        $tercerosSelect = ArrayHelper::map($terceros, 'NumeroDocumento', 'RazonSocial');
        $laboratorio = null;

        // VarDumper::dump($terceros,10,true); echo "<br>";
        if ($usuarioProveedor->load(Yii::$app->request->post())) {
            $documentoLaboratorio = Yii::$app->request->post()['UsuarioProveedor']['nitLaboratorio'];
            // $idAgrupacion = Yii::$app->request->post()['UsuarioProveedor']['idAgrupacion'];
            foreach($terceros as $tercero) {
                if ($documentoLaboratorio == $tercero['NumeroDocumento']) {
                    $laboratorio = $tercero;
                    break;
                }
            }
            // VarDumper::dump($laboratorio,10,true); echo "<br>";
            $usuarioProveedor->idTercero = $laboratorio['IdTercero'];
            $usuarioProveedor->idFabricante = $laboratorio['IdFabricante'];
            $usuarioProveedor->nombreLaboratorio = $laboratorio['RazonSocial'];
            $usuarioProveedor->nitLaboratorio = $laboratorio['NumeroDocumento'];
            // $usuarioProveedor->idAgrupacion = $idAgrupacion;
            // if(array_key_exists($idAgrupacion, $unidadesNegocio)) {
            //     $usuarioProveedor->nombreUnidadNegocio = $unidadesNegocio[$idAgrupacion];
            // }

            if ($usuarioProveedor->save()) {
                return $this->redirect(['ver', 'id' => $usuarioProveedor->numeroDocumento]);
            }
        } else {
            return $this->render('update', [
                'model' => $usuarioProveedor,
                'terceros' => $tercerosSelect,
                'ciudades' => $ciudades,
            ]);
        }
    }

    public function actionCambiarEstado($id)
    {
        $usuario = \app\models\Usuario::findOne(['numeroDocumento' => $id]);
        // var_dump($usuario);exit();
        if ($usuario->estado == 1) {
            $usuario->estado = 0;
        } else {
            $usuario->estado = 1;
        }
        if ($usuario->save()) {
            Yii::$app->session->setFlash('success', 'Se ha cambiado el estado del usuario');
        } else {
            Yii::$app->session->setFlash('error', 'No se ha cambiad el estado del usuario');
        }
          
        return $this->redirect(['admin']);
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
    }
}
