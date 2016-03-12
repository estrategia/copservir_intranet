<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\Tareas;
use app\modules\intranet\models\LogTareas;
use app\modules\intranet\models\TareasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * TareasController implements the CRUD actions for Tareas model.
 */
class TareasController extends Controller
{
    public $layout = 'main';

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


     /*
     accion para renderizar la vista tareas
     */
     public function actionListarTareas()
     {
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $modelTareas = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->all();
         return $this->render('listarTareas', ['modelTareas' => $modelTareas]);
     }

    /**
     * muestra el detalle de la tarea
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->encontrarModelo($id),
        ]);
    }

    /**
     * crea una nueva tarea
     * Si una tarea se crea con exito redirige a el detalle de la tarea
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Tareas();

        //$modelLogTareas = new LogTareas();
        echo var_dump( Yii::$app->request->post());
        //echo Yii::$app->request->post('idPrioridad');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idTarea]);
        } else {

            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * actualiza una tarea existente
     * Si una tarea se crea con exito redirige a el detalle de la tarea
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->encontrarModelo($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idTarea]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * elimina una tarea existente
     * si elimina correctamente redirige a listar tareas
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->encontrarModelo($id)->delete();

        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $modelTareas = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->all();
        return $this->render('listarTareas', ['modelTareas' => $modelTareas]);
    }

    /**
     * actualizar el progreso de una tarea cuando mueven el slider
     *
     * @param
     * @return mixed
     */
    public function actionActualizarProgreso()
    {
      $idTarea = Yii::$app->request->post('idTarea');
      $tarea = Tareas::findOne($idTarea);

      $tarea->progreso = Yii::$app->request->post('progresoTarea');

      if ($tarea->save()) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = [
            'result' => 'ok',
        ];
        return $items;
      }
    }

    /**
     * encuentra una tarea por su llave primaria
     * si el modelo no existe manda un 404
     * @param string $id
     * @return Tareas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function encontrarModelo($id)
    {
        if (($model = Tareas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
