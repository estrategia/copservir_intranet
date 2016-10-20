<?php

namespace app\modules\proveedores\controllers;

use Yii;
use app\modules\proveedores\models\UsuarioProveedor;
use app\modules\proveedores\models\UsuarioProveedorSearch;
use app\modules\proveedores\models\LoginForm;
use app\modules\intranet\models\ConexionesUsuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\intranet\models\Funciones;
use yii\helpers\ArrayHelper;
use app\models\SIICOP;
use yii\helpers\VarDumper;
/**
 * UsuarioController implements the CRUD actions for UsuarioProveedor model.
 */
class UsuarioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
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

    public function actionIndex()
    {
        $searchModel = new UsuarioProveedorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, '', false, \Yii::$app->controller->module->id);

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
    public function actionView($id)
    {   
        $model = $this->findModel(Yii::$app->request->get()['id']);
        if (Yii::$app->request->post()) {
            $permisosUsuario = Yii::$app->request->post();
            unset($permisosUsuario['_csrf']);
           
            $diff = $model->permisosFaltantes($model->getPermisosAsignacion(), $permisosUsuario);
            VarDumper::dump($diff,10,true);

            $model->asignarPermisos($permisosUsuario);
            $model->removerPermisos($diff);

        }
        return $this->render('view', [
            'model' => $model,
            'permisos' => $model->getPermisosAsignacion(),
            'permisosAsignados' => $model->getPermisosAsignados(),
        ]);
    }

    public function actionPermisos()
    {   
        if (Yii::$app->request->post()) {
            var_dump(Yii::$app->request->post());
        }
        if (Yii::$app->request->get()) {
            $model = $this->findModel(Yii::$app->request->get()['id']);
            return $this->render('permisos', [
                'model' => $model,
                'permisos' => $model->getPermisosAsignacion(),
            ]);   
        }
    }

    /**
     * Creates a new UsuarioProveedor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {      
        $usuarioProveedor = new UsuarioProveedor();
        $terceros = $this->getTerceros();
        $unidadesNegocio = SIICOP::wsGetUnidadesNegocio(1);
        $tercerosSelect = ArrayHelper::map($terceros, 'NumeroDocumento', 'Nombre');
        $laboratorio = null;

        if ($usuarioProveedor->load(Yii::$app->request->post())) {
            $usuarioProveedor->modulo = \Yii::$app->controller->module->id;
            $documento = Yii::$app->request->post()['UsuarioProveedor']['numeroDocumento'];
            $documentoLaboratorio = Yii::$app->request->post()['UsuarioProveedor']['nitLaboratorio'];
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
            $usuarioProveedor->nombreUnidadNegocio = $unidadesNegocio[$idAgrupacion];

            // var_dump($usuarioProveedor);

            $usuarioIntranet = new \app\models\Usuario();
            $usuarioIntranet->numeroDocumento = $documento;
            $contrasena = Funciones::generatePass(8);
            $usuarioIntranet->contrasena = md5($contrasena);
            $usuarioIntranet->codigoPerfil = (int) Yii::$app->params['PerfilesUsuario']['visitaMedica'];
            $usuarioIntranet->estado = true;

            // var_dump($usuarioProveedor);

            if ($usuarioIntranet->save() && $usuarioProveedor->save()) {
                $infoUsuario = [
                    'usuario' => $usuarioIntranet->numeroDocumento,
                    'password' => $contrasena,
                ];
                // $contenidoCorreo = $this->renderPartial('_notificacionRegistro',['infoUsuario' => $infoUsuario]);
                // $correoEnviar = $this->renderPartial('/common/correo', ['contenido' => $contenidoCorreo]);
                // $correoEnviado = yii::$app->mailer->compose()->setFrom(\Yii::$app->params['adminEmail'])
                //                         ->setTo($usuarioProveedor->email)->setSubject('Credencales Acceso Proveedores Copservir')
                //                         ->setHtmlBody($correoEnviar)->send();

                return $this->redirect(['view', 'id' => $usuarioProveedor->numeroDocumento]);
            }

        } else {
            return $this->render('create', [
                'model' => $usuarioProveedor,
                'terceros' => $tercerosSelect,
                'unidadesNegocio' => $unidadesNegocio,
            ]);
        }
    }

    /**
     * Updates an existing UsuarioProveedor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $usuarioProveedor = $this->findModel($id);
        $terceros = $this->getTerceros();
        $unidadesNegocio = SIICOP::wsGetUnidadesNegocio(1);
        // array_unshift($unidadesNegocio, '(no definido)');  // $unidadesNegocio
        $tercerosSelect = ArrayHelper::map($terceros, 'NumeroDocumento', 'Nombre');
        $laboratorio = null;

        if ($usuarioProveedor->load(Yii::$app->request->post())) {
            $documentoLaboratorio = Yii::$app->request->post()['UsuarioProveedor']['nitLaboratorio'];
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
            $usuarioProveedor->nombreUnidadNegocio = $unidadesNegocio[$idAgrupacion];


            if ($usuarioProveedor->save()) {
                return $this->redirect(['view', 'id' => $usuarioProveedor->numeroDocumento]);
            }
        } else {
            return $this->render('update', [
                'model' => $usuarioProveedor,
                'terceros' => $tercerosSelect,
                'unidadesNegocio' => $unidadesNegocio,
            ]);
        }
    }

    /**
     * Deletes an existing UsuarioProveedor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

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

        $client = new \SoapClient('http://localhost/copservir/productos/sweb/terceros');
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
