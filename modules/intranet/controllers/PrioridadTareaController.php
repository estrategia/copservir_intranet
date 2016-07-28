<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\PrioridadTarea;
use app\modules\intranet\models\PrioridadTareaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PrioridadTareaController implements the CRUD actions for PrioridadTarea model.
 */
class PrioridadTareaController extends Controller
{

     public function behaviors() {
         return [
             [
                 'class' => \app\components\AccessFilter::className(),
             ],
             [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                     'admin', 'detalle', 'crear', 'actualizar', 'eliminar'
                 ],
                 'authsActions' => [
                     'detalle' => 'intranet_prioridad-tarea_admin',
                     'crear' => 'intranet_prioridad-tarea_admin',
                     'actualizar' => 'intranet_prioridad-tarea_admin',
                     'eliminar' => 'intranet_prioridad-tarea_admin',
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
     * Lista todos los modelos PrioridadTarea.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new PrioridadTareaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un solo modelo PrioridadTarea.
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
     * Crea un nuevo modelo PrioridadTarea.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new PrioridadTarea();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idPrioridadTarea]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo PrioridadTarea exitente.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idPrioridadTarea]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Inactiva un modelo PrioridadTarea existentes.
     * @param integer $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $model = $this->findModel($id);
        $model->estado = PrioridadTarea::ESTADO_INACTIVO;

        if ($model->save()) {
            return $this->redirect(['admin']);
        }
    }

    /**
     * Encuentra un modelo PrioridadTarea basado en el valor de su llave primaria.
     * @param integer $id
     * @return PrioridadTarea the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PrioridadTarea::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
