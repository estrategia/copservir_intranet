<?php

namespace app\modules\proveedores\modules\visitamedica\controllers;

use Yii;
use app\modules\proveedores\models\UsuarioProveedor;
use app\modules\proveedores\models\UsuarioProveedorSearch;
use app\modules\proveedores\modules\visitamedica\models\CorreoAdminForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use app\modules\intranet\models\Funciones;
use app\modules\intranet\models\Ciudad;
use app\models\Usuario;
use yii\helpers\VarDumper;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/proveedores/usuario/autenticar']
            ],

            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'admin', 'crear', 'actualizar', 'correo-admin', 'exportar-usuarios', 'mi-cuenta', 'actualizar-mi-cuenta',
                ],
                'authsActions' => [
                    // 'admin' => 'visitaMedica_usuario_admin',
                    // 'ver' => 'visitaMedica_usuario_ver',
                    // 'crear' => 'visitaMedica_usuario_crear',
                    // 'actualizar' => 'visitaMedica_usuario_admin',
                    'coreo-admin' => 'visitaMedica_usuario_correo-admin',
                    'exportar-usuarios' => 'visitaMedica_usuario_exportar-usuarios',
                    // 'cambiar-estado' => 'visitaMedica_usuario_admin',
                	'mi-cuenta' => 'visitaMedica_usuario_mi-cuenta',
                	'actualizar-mi-cuenta' => 'visitaMedica_usuario_actualizar-mi-cuenta'
                ],
           ],
        
        ];
    }
    
    /**
     * Lists all Usuario models.
     * @return mixed
     */
    // public function actionAdmin()
    // {
    //     $searchModel = new UsuarioProveedorSearch();
    //     $params = Yii::$app->request->queryParams;
    //     $laboratorio = null;
    //     // var_dump(Yii::$app->user->identity->objUsuarioProveedor);

    //     // var_dump(Yii::$app->user->identity);
    //     // Usuario::findOne(Yii::$app->user->identity->numeroDocumento)
    //     if (Yii::$app->user->identity->tienePermiso("proveedores_admin")) {
    //         $laboratorio = Yii::$app->user->identity->objUsuarioProveedor->nitLaboratorio;
    //     }
    //     $filtrosUsuario = \Yii::$app->session->set(\Yii::$app->params['visitamedica']['session']['filtrosUsuario'], $params);
    //     // var_dump($filtrosUsuario = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['filtrosUsuario']));
    //     $dataProvider = $searchModel->search($params, $laboratorio, true, \Yii::$app->controller->module->id);
    //     // var_dump($params);
    //     // var_dump($searchModel->attributes);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single Usuario model.
     * @param string $id
     * @return mixed
     */
    // public function actionVer($id)
    // {
    //     return $this->render('view', [
    //         'model' => $this->findModel($id),
    //     ]);
    // }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    // public function actionCrear()
    // {   
    //     $usuarioVimed = new UsuarioProveedor();
    //     $ciudades = ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad');
    //     $nitLaboratorio = Yii::$app->user->identity->objUsuarioProveedor->nitLaboratorio;
    //     $usuarioVimed->nitLaboratorio = $nitLaboratorio;
        
    //     if ($usuarioVimed->load(Yii::$app->request->post()) && $usuarioVimed->validate()) {
    //         $usuarioVimed->modulo = \Yii::$app->controller->module->id;
    //         // var_dump($usuarioVimed);
    //         $documento = Yii::$app->request->post()['UsuarioProveedor']['numeroDocumento'];
    //         $usuarioIntranet = new \app\models\Usuario();
    //         $usuarioIntranet->numeroDocumento = $documento;
    //         $contrasena = Funciones::generatePass(8);
    //         $usuarioIntranet->contrasena = md5($contrasena);
    //         // $usuarioIntranet->codigoPerfil = 0;
    //         $usuarioIntranet->nombrePortal = Yii::$app->controller->module->id;
    //         $usuarioIntranet->estado = true;            
    //         $nombreLaboratorio = Yii::$app->user->identity->objUsuarioProveedor->nombreLaboratorio;
    //         $usuarioVimed->nombreLaboratorio = $nombreLaboratorio;
    //         $usuarioVimed->idTercero = Yii::$app->user->identity->objUsuarioProveedor->idTercero;
    //         $usuarioVimed->idFabricante = Yii::$app->user->identity->objUsuarioProveedor->idFabricante;
    //         $item_name = "";

    //         if (Yii::$app->user->identity->tienePermiso("proveedores_admin")) {
    //             $item_name = 'visitaMedica_visitador';
    //         // } elseif (Yii::$app->user->identity->tienePermiso("visitaMedica_proveedor")) {
    //         //     $item_name = 'visitaMedica_visitador';
    //         }

    //         if ($usuarioIntranet->save() && $usuarioVimed->save()) {
    //             $connection = \Yii::$app->db;
    //             $transaction = $connection->beginTransaction();
    //             try {
    //                 $connection->createCommand()
    //                 ->insert('auth_assignment', [
    //                     'user_id' => $documento,
    //                     'item_name' => $item_name,
    //                 ])->execute();  
    //                 $transaction->commit();

    //             } catch (Exception $e) {

    //                 $transaction->rollBack();
    //                 throw $e;
    //             }
    //             $infoUsuario = [
    //                 'usuario' => $usuarioIntranet->numeroDocumento,
    //                 'password' => $contrasena,
    //             ];
    //             $contenidoCorreo = $this->renderPartial('_notificacionRegistro',['infoUsuario' => $infoUsuario]);
    //             $correoEnviar = $this->renderPartial('/common/correo', ['contenido' => $contenidoCorreo]);
    //             $correoEnviado = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
    //                                     ->setTo($usuarioVimed->email)->setSubject('Credenciales Acceso Visita-Medica Copservir')
    //                                     ->setHtmlBody($correoEnviar)->send();

    //             $correosAdmin = UsuarioProveedor::getCorreosAdmin();
    //             foreach ($correosAdmin as $correo) {
    //                 $correoEnviado = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
    //                                     ->setTo($usuarioVimed->email)->setSubject('Notificacion de registro en Visita-Medica Copservir')
    //                                     ->setHtmlBody($correoEnviar)->send();
    //             }

    //             return $this->redirect(['ver', 'id' => $usuarioVimed->numeroDocumento]);
    //         }

    //     }
        
    //     return $this->render('create', [
    //         'model' => $usuarioVimed,
    //         'ciudades' => $ciudades,
    //     ]);
    // }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    // public function actionActualizar($id)
    // {
    //     $model = $this->findModel($id);
    //     // $ciudades = ArrayHelper::map(Ciudad::find()->all(), 'codigoCiudad', 'nombreCiudad');

    //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
    //         return $this->redirect(['ver', 'id' => $model->numeroDocumento]);
    //     } else {
    //         return $this->render('update', [
    //             'model' => $model,
    //             // 'ciudades' => $ciudades,
    //         ]);
    //     }
    // }

    public function actionActualizarMiCuenta()
    {
        $documento =  Yii::$app->user->identity->numeroDocumento;
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
        // var_dump($response->data);
        $profesiones = ArrayHelper::map($response->data['response'], 'idProfesion', 'nombreProfesion');
        if ($usuarioVimed->load(Yii::$app->request->post())) {
            if (!empty(Yii::$app->request->post()['UsuarioProveedor']['idProfesion'])) {
                $idProfesion = Yii::$app->request->post()['UsuarioProveedor']['idProfesion'];
                $usuarioVimed->profesion = $profesiones[$idProfesion];
                $usuarioVimed->idProfesion = $idProfesion;
            }
            if ( $usuarioVimed->save()) {
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

    // public function actionCambiarEstado($id)
    // {
    //     $usuario = Usuario::findOne(['numeroDocumento' => $id]);
    //     // var_dump($usuario);
    //     if ($usuario->estado == 1) {
    //         $usuario->estado = 0;
    //     } else {
    //         $usuario->estado = 1;
    //     }
    //     if ($usuario->save()) {
    //         Yii::$app->session->setFlash('success', 'Se ha cambiado el estado del usuario');
    //     } else {
    //         Yii::$app->session->setFlash('error', 'No se ha cambiad el estado del usuario');
    //     }
          
    //     return $this->redirect(['admin']);
    // }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

    public function actionMiCuenta()
    {
        // var_dump(Yii::$app->user->identity->tienePermiso("proveedores_admin")); exit();
        $intranetUser = \app\models\Usuario::findOne(Yii::$app->user->identity->idUsuario);
        $vimedUser = UsuarioProveedor::findOne(['numeroDocumento', $intranetUser->numeroDocumento]);
        return $this->render('miCuenta', ['model' => $vimedUser]);
    }

    public function actionAyuda()
    {
        return $this->render('ayuda');
    }

    public function actionCorreoAdmin()
    {
        $model = new CorreoAdminForm;
        $usuarioIntranet = Yii::$app->user->identity;
        $usuarioVimed = $usuarioIntranet->objUsuarioProveedor;
        $correoVisitador = $usuarioVimed->email;
        $laboratorio = $usuarioVimed->nitLaboratorio;
        $proveedores = UsuarioProveedor::getProveedores($laboratorio);

        // foreach ($proveedores as $proveedor) {
        //     echo $proveedor['email'];
        // }
       
        if(Yii::$app->request->post()) {
            $contenido = Yii::$app->request->post()['CorreoAdminForm']['contenido'];

            $contenidoCorreo = $this->renderPartial('_correoAProveedor', ['visitador' => $usuarioVimed, 'mensaje' => $contenido]);
            $correoEnviar = $this->renderPartial('/common/correo', ['contenido' => $contenidoCorreo]);
            foreach ($proveedores as $proveedor) {
                $correoEnviado = yii::$app->mailer->compose()
                                ->setFrom($correoVisitador)
                                ->setTo($proveedor['email'])->setSubject('Mensaje de' . $usuarioVimed->nombre)
                                ->setHtmlBody($correoEnviar)->send();
            }
        }
        return $this->render('correoAdminForm', ['model' => $model]);

        // var_dump($usuarioVimed);
    }

    public function actionExportarUsuarios()
    {
    	
    	//VarDumper::dump(\Yii::$app->controller->module->id,10,true);exit();

        $searchModel = new UsuarioProveedorSearch();
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setTitle("Reporte Bonos");

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getSheet(0)->setTitle('Bonos');

        $objWorksheet = $objPHPExcel->getSheet(0);
        $objWorksheet->setTitle('Bonos');

        $col = 0;
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, '# Documento');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Nombre');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Primer Apellido');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Segundo Apellido');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Email');
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, 'Laboratorio');

        $params = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['filtrosUsuario']);
        $laboratorio = null;
        
        if (Yii::$app->user->identity->objUsuarioProveedor!==null) {
           $laboratorio = Yii::$app->user->identity->objUsuarioProveedor->nitLaboratorio;
        }

        $dataProvider = $searchModel->search($params, $laboratorio, false, \Yii::$app->controller->module->id);

        // var_dump($dataProvider);

        // var_dump($dataProvider->getModels());

        foreach ($dataProvider->getModels() as $indice => $usuario ) {
            $col = 0;
            $fila = $indice + 2;
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->numeroDocumento );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->nombre );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->primerApellido );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->segundoApellido );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->email );
            $objWorksheet->setCellValueByColumnAndRow($col++, $fila, $usuario->nitLaboratorio );
        }

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="usuarios_vimed_' . date('YmdHis') . '.xls"');
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
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Usuario the loaded model
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
}

