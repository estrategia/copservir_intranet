<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion;
use app\modules\intranet\modules\formacioncomunicaciones\models\CargueRestriccionesRedencion;
use app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencionSearch;
use yii\web\Controller;
use yii\db\Query;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RestriccionesRedencionController implements the CRUD actions for RestriccionesRedencion model.
 */
class RestriccionesRedencionController extends Controller
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
                    'eliminar' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all RestriccionesRedencion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RestriccionesRedencionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $modeloCargue = new CargueRestriccionesRedencion();
        if (Yii::$app->request->isPost) {
            if ($modeloCargue->load(Yii::$app->request->post())) {
                $rutaAchivo = $modeloCargue->guardarArchivo();
                if ($rutaAchivo) {
                    if(RestriccionesRedencion::cargarExcel($rutaAchivo)) {
                        Yii::$app->session->setFlash('success', 'Se han registrado correctamente los datos');
                    } else {
                        Yii::$app->session->setFlash('error', 'No se han registrado los datos');
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Error al cargar el archivo');
                }
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modeloCargue' => $modeloCargue,
        ]);
    }

    /**
     * Creates a new RestriccionesRedencion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new RestriccionesRedencion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RestriccionesRedencion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionListAjax($q = null){
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = new Query();
            $query->select('numeroDocumento as id, nombres AS text')
                ->from('m_INTRA_Usuario')
                // ->where("codigoTipoPersona=:tipo AND estado=:estado", [":tipo"=>1, ":estado"=>1])
                ->andWhere(['like', 'nombres', $q])
                ->limit(20);
            $command = $query->createCommand();
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        return $out;
    }

    public function actionImportarExcel()
    {
        $rutaAchivo = Yii::getAlias('@app').'/uploads/formacioncomunicaciones/plantilla_cargue_restricciones_redencion.xlsx';

        $tipoArchivo = \PHPExcel_IOFactory::identify($rutaAchivo);
        $objectReader = \PHPExcel_IOFactory::createReader($tipoArchivo);
        $objectPHPExcel = $objectReader->load($rutaAchivo);
        $hoja = $objectPHPExcel->getActiveSheet();
        $numerosDocumento = [];
        $numeroDocumento = null;
        for ($indiceFila=2; true; $indiceFila++) { 
            $numeroDocumento = $hoja->getCell('A'.$indiceFila)->getValue();
            if (is_null($numeroDocumento)) {
                break;
            }
            $numerosDocumento[] = $numeroDocumento;
        }
        \yii\helpers\VarDumper::dump($numerosDocumento,10,true);
    }

    /**
     * Finds the RestriccionesRedencion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return RestriccionesRedencion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RestriccionesRedencion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
