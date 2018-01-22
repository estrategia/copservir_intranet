<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\modules\formacioncomunicaciones\models\Area;
use app\modules\intranet\modules\formacioncomunicaciones\models\Capitulo;
use app\modules\intranet\modules\formacioncomunicaciones\models\Contenido;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoCalificacion;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoLeidoUsuario;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoCalificacionSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\ContenidoSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\Modulo;
use app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

/**
 * ContenidoController implements the CRUD actions for Contenido model.
 */
class ContenidoController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/intranet/usuario/autenticar']
            ],

            

        ];
    }

    public function actions()
    {
        return [
            'cargar-imagen' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::getAlias('@web') . '/formacioncomunicaciones/contenidos/imagenes/', //Yii::$app->realpath().'/imagenes', // Directory URL address, where files are stored.
                'path' => '@app/web/formacioncomunicaciones/contenidos/imagenes/', // Or absolute path to directory where files are stored.
                'validatorOptions' => [
                    'extensions' => (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->tienePermiso("intranet_admin")) ? Yii::$app->params['contenido']['imagenAdmin']['formatosValidos'] : Yii::$app->params['contenido']['imagen']['formatosValidos'],
                    
                    'maxWidth' => (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->tienePermiso("intranet_admin")) ? Yii::$app->params['contenido']['imagenAdmin']['ancho'] : Yii::$app->params['contenido']['imagen']['ancho'],

                    'maxHeight' => (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->tienePermiso("intranet_admin")) ? Yii::$app->params['contenido']['imagenAdmin']['alto'] : Yii::$app->params['contenido']['imagen']['alto'],
                    
                    'maxSize' => (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->tienePermiso("intranet_admin")) ? Yii::$app->params['contenido']['imagenAdmin']['tamanho'] * 1024 * 1024 : Yii::$app->params['contenido']['imagen']['tamanho'] * 1024 * 1024
                ]
            ],
            'cargar-archivo' => [
                'class' => 'vova07\imperavi\actions\UploadAction',
                'url' => Yii::getAlias('@web') . '/formacioncomunicaciones/contenidos/archivos/',
                'path' => '@app/web/formacioncomunicaciones/contenidos/archivos/',
                'uploadOnlyImage' => false,
                'validatorOptions' => [
                    'extensions' => (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->tienePermiso("intranet_admin")) ? Yii::$app->params['contenido']['archivoAdmin']['formatosValidos'] : Yii::$app->params['contenido']['archivo']['formatosValidos'],
                    'maxSize' => (!Yii::$app->getUser()->isGuest && Yii::$app->user->identity->tienePermiso("intranet_admin")) ? Yii::$app->params['contenido']['archivoAdmin']['tamanho'] * 1024 * 1024 :  Yii::$app->params['contenido']['archivo']['tamanho'] * 1024 * 1024
                ]
            ]
        ];
    }

    /**
     * Lists all Contenido models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ContenidoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Contenido model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Contenido model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Contenido();
        $capitulos = ArrayHelper::Map(Capitulo::find()->where(['estadoCapitulo' => 1])->asArray()->all(),'idCapitulo', 'nombreCapitulo');
        if ($model->load(Yii::$app->request->post())) {
            return $this->redirect(['detalle', 'id' => $model->idContenido]);
        } else {
            return $this->render('crear', [
                'model' => $model,
                'capitulos' => $capitulos,
            ]);
        }
    }

    /**
     * Updates an existing Contenido model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);
        $terceros = $this->getTerceros();
        $terceros[] = ['IdTercero' => '-1', 'RazonSocial' => 'COPSERVIR'];
        $tercerosSelect = ArrayHelper::map($terceros, 'IdTercero', 'RazonSocial');
        // \yii\helpers\VarDumper::dump($tercerosSelect,2,true);
        $capitulos = ArrayHelper::Map(Capitulo::find()->where(['estadoCapitulo' => 1])->asArray()->all(),'idCapitulo', 'nombreCapitulo');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->idTercero == -1) {
                $model->nombreProveedor = 'COPSERVIR';
            } else {
                $model->nombreProveedor = $tercerosSelect[$model->idTercero];
            }
            if ($model->save()) {
                return $this->redirect(['detalle', 'id' => $model->idContenido]);
            }
        } else {
            return $this->render('actualizar', [
                'model' => $model,
                'capitulos' => $capitulos,
                'terceros' => $tercerosSelect
            ]);
        }
    }

    public function actionVisualizarContenido($id)
    {
        $model = $this->findModel($id);
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $calificacionModel = ContenidoCalificacion::find()->where(['numeroDocumento' => $numeroDocumento, 'idContenido' => $model->idContenido])->one();
        $datos = $model->resumenCalificaciones();
        if ($calificacionModel == null) {
            $calificacionModel = new ContenidoCalificacion;
        }
        $searchModelCalificacion = new ContenidoCalificacionSearch;
        $params = Yii::$app->request->queryParams;
        $params['contenido'] = $model->idContenido;
        $dataProviderCalificacion = $searchModelCalificacion->search($params);
        // if (Yii::$app->request->isPost) {
        //     if ($calificacionModel->load(Yii::$app->request->post())) {
        //         $calificacionModel->numeroDocumento = $numeroDocumento;
        //         $calificacionModel->idContenido = $model->idContenido;
        //         if ($calificacionModel->save()) {
        //             $model->capitulo->modulo->curso->calcularPromedioCalificacion();
        //             Yii::$app->session->setFlash('success', 'Se ha guardado su reseña.');
        //         } else {
        //             Yii::$app->session->setFlash('error', 'Ocurrio un error al guardar su reseña.');
        //         }
        //     }
        // }

        return $this->render('contenido', ['model' => $model, 'calificacionModel' => $calificacionModel, 'searchModelCalificacion' => $searchModelCalificacion, 'dataProviderCalificacion' => $dataProviderCalificacion, 'datos' => $model->resumenCalificaciones()]);
    }

    public function actionCrearResena()
    {
        $response = [];
        // var_dump(Yii::$app->request->post());
        // exit();
        if (Yii::$app->request->isPost) {
            $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
            $calificacionModel = ContenidoCalificacion::find()->where(['numeroDocumento' => $numeroDocumento, 'idContenido' => Yii::$app->request->post()['ContenidoCalificacion']['idContenido']])->one();
            if ($calificacionModel == null) {
            }
            $calificacionModel = new ContenidoCalificacion;
            if ($calificacionModel->load(Yii::$app->request->post())) {
                $calificacionModel->numeroDocumento = $numeroDocumento;
                // $calificacionModel->idContenido = $model->idContenido;
                if ($calificacionModel->save()) {
                    $searchModelCalificacion = new ContenidoCalificacionSearch;
                    $model = Contenido::find()->where(['idContenido' => $calificacionModel->idContenido])->one();
                    $params = Yii::$app->request->queryParams;
                    $params['contenido'] = $model->idContenido;
                    $dataProviderCalificacion = $searchModelCalificacion->search($params);
                    $model->capitulo->modulo->curso->calcularPromedioCalificacion();
                    $datos = $model->resumenCalificaciones();
                    $response = [
                        'result' => 'ok', 
                        'response' => [
                            'resumen' => $this->renderPartial('resumen-resenas', ['datos' => $datos]),
                            'resenas' => $this->renderAjax('comentarios-contenido', ['dataProviderCalificacion' => $dataProviderCalificacion]),
                            'promedio' => $this->renderAjax('crear-resena', ['datos' => $datos])

                        ]
                    ];
                } else {
                    $response = ['result' => 'error', 'response' => []];
                }
            }
        }
        return Json::encode($response);
    }

    public function actionCargarPaquete()
    {   
        $response = [];
        $modelId = $_POST['modelId'];
        $rutaArchivo = Yii::getAlias('@webroot') . Yii::$app->params['formacioncomunicaciones']['rutaContenidosPaquetes'] . "{$modelId}/";
        $nombreArchivo = $rutaArchivo . "{$modelId}.zip";
        $iframeSrc = Yii::getAlias('@web') . Yii::$app->params['formacioncomunicaciones']['rutaContenidosPaquetes'] . "{$modelId}/" . "index.html";

        if (!is_dir($rutaArchivo)) {
            // mkdir($rutaArchivo);
            FileHelper::createDirectory($rutaArchivo, 0777, true);
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $archivoMovido = move_uploaded_file(
            $_FILES['paqueteContenido']['tmp_name'],
            $nombreArchivo
        );

        if (!$archivoMovido) {
            $response = ['error', 'no se ha podido guardar el archivo'];
            return $response;
        }

        $zip = new \ZipArchive;
        $res = $zip->open($nombreArchivo);
        if ($res !== true) {
            $response = ['error', 'no se ha podido descomprimir el archivo'];
        }
        $zip->extractTo($rutaArchivo);
        $zip->close();

        $this->formatearPaquete($modelId);

        $response = ['result' => 'ok', 'response' => ['iframeSrc' => $iframeSrc]];
        return $response;
    }

    public function actionPendientesUsuario()
    {
        $searchModel = new ContenidoSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Contenido::consultarContenidosPendientesUsuario(),
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $this->render('misContenidos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionRecomendados()
    {
        $searchModel = new ContenidoSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Contenido::consultarContenidosPendientesUsuario(),
            'pagination' => [
                'pageSize' => 10
            ],
            'sort'=> [
                'defaultOrder'=>'cantidadPuntos',
            ],
        ]);

        return $this->render('misContenidos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPendientesRecientes()
    {
        $searchModel = new ContenidoSearch();
        $dataProvider = new ActiveDataProvider([
            'query' => Contenido::consultarContenidosPendientesUsuario(),
            'pagination' => [
                'pageSize' => 10
            ],
            'sort'=> [
                'defaultOrder'=>'fechaCreacion',
            ],
        ]);

        return $this->render('misContenidos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }



    /**
     * Finds the Contenido model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Contenido the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Contenido::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    private function formatearPaquete($modelId)
    {
        $rutaBase = Yii::getAlias('@webroot') . Yii::$app->params['formacioncomunicaciones']['rutaContenidosPaquetes'] . "{$modelId}/";
        $rutas = [];
        $nuevasRutas = [];
        foreach (new \DirectoryIterator($rutaBase) as $file) {
            if ($file->isFile()) {
                $rutaOriginal = $file->getFilename();
                $rutaFinal = FileHelper::normalizePath($rutaOriginal);
                $rutaFinal = $this->eliminarDirectorioRaiz($rutaFinal);
                if ($rutaFinal != '') {
                    $rutas[] = [$rutaOriginal, $rutaFinal];
                }
            }
        }

        foreach ($rutas as $ruta) {
            $origen = $rutaBase . $ruta[0];
            $destino = $rutaBase . $ruta[1];
            $carpeta = pathinfo($destino);
            if (!is_dir($carpeta['dirname'] && $carpeta['dirname'])) {
                FileHelper::createDirectory($carpeta['dirname'], 0777, true);
            }
            rename($origen, $destino);
        }
        // \yii\helpers\VarDumper::dump($nuevasRutas,10,true);
    }

    private function eliminarDirectorioRaiz($path)
    {
        $ruta = explode("/", $path); // Pull it apart
        if (sizeof($ruta > 1)) {
            array_shift($ruta); // Pop the first index off array
            $ruta = implode("/", $ruta); // Put it together again
            return $ruta;
        } else {
            return '';
        }
    }

    protected function getTerceros() {

        ini_set("soap.wsdl_cache_enabled", 0);

        $client = new \SoapClient(Yii::$app->params['webServices']['productos']['terceros']);
        $arr = $client->getTerceros();

        if ($arr === null) {
            return [];
        } else {
            return $arr;
        }
    }

}
