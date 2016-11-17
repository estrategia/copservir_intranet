<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\CriteriosEvaluacionVentas;
use app\modules\trademarketing\models\CriteriosEvaluacionVentasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class CriteriosEvaluacionVentasController extends Controller
{
	public $defaultAction = "admin";
	
    public function behaviors()
    {
        return [

            [
                'class' => \app\components\AccessFilter::className(),
            ],
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                   'admin', 'detalle', 'crear', 'actualizar', 'inactivar'
                 ],
                 'authsActions' => [
                     //colocar los permisos
                      'admin' => 'tradeMarketing_criterios-evaluacion_admin',
                      'detalle' => 'tradeMarketing_criterios-evaluacion_admin',
                      'crear' => 'tradeMarketing_criterios-evaluacion_admin',
                      'actualizar' => 'tradeMarketing_criterios-evaluacion_admin',
                      'inactivar' => 'tradeMarketing_criterios-evaluacion_admin'
                 ]
             ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista todos los modelos CriteriosEvaluacionVentas.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new CriteriosEvaluacionVentasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Visualiza un solo modelo CriteriosEvaluacionVentas.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->encontrarModeloCriterioEvaluacion($id),
        ]);
    }

    /**
     * Crea un nuevo modelo CriteriosEvaluacionVentas.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new CriteriosEvaluacionVentas();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idCriterio]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo CriteriosEvaluacionVentas existente.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->encontrarModeloCriterioEvaluacion($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idCriterio]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Inactiva un modelo CriteriosEvaluacionVentas existente.
     * @param integer $id
     * @return mixed
     */
    public function actionInactivar($id)
    {
        $model = $this->encontrarModeloCriterioEvaluacion($id);
        $model->estado = CriteriosEvaluacionVentas::ESTADO_INACTIVO;

        if (!$model->save()) {
            Yii::$app->session->setFlash('error', json_encode($model->getErrors()));
        }

        return $this->redirect(['admin']);
    }

    /**
     * Encuentra un modelo CriteriosEvaluacionVentas basado en el valor de su llave primaria.
     * @param integer $id
     * @return modelo CriteriosEvaluacionVentas cargado
     * @throws NotFoundHttpException si no encuentra el modelo.
     */
    protected function encontrarModeloCriterioEvaluacion($id)
    {
        if (($model = CriteriosEvaluacionVentas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('El recurso no existe.');
        }
    }
}
