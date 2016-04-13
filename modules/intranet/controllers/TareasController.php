<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\Tareas;
use app\modules\intranet\models\LogTareas;
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
        $tareasUsuario = Tareas::find()->with(['objPrioridadTareas'])->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', 0])->all();
         return $this->render('listarTareas', ['tareasUsuario' => $tareasUsuario]);
     }

    /**
     * muestra el detalle de la tarea
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        /*$model = Tareas::find()->andWhere(['idTarea'=>$id]);
        //var_dump ($model);
        //exit();
        return $this->render('detalle', [
            'model' => $model,
        ]);*/
    }

    /**
     * crea una nueva tarea
     * Si una tarea se crea con exito redirige a el detalle de la tarea
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Tareas();
        $modelLogTareas = new LogTareas();
        $db = Yii::$app->db;

        if ($model->load(Yii::$app->request->post())) {

            $transaction = Tareas::getDb()->beginTransaction();

            try {


                $model->save();

                $innerTransaction = LogTareas::getDb()->beginTransaction();

                try {

                    $modelLogTareas->idTarea = $model->idTarea;
                    $modelLogTareas->estadoTarea = $model->estadoTarea;
                    $modelLogTareas->fechaRegistro = $model->fechaRegistro;
                    $modelLogTareas->progreso = 0;
                    $modelLogTareas->prioridad = $model->idPrioridad;

                    $modelLogTareas->save();
                    $innerTransaction->commit();

                } catch (Exception $e) {
                    $innerTransaction->rollBack();

                    throw $e;
                 }


                //ejecuta la transaccion
                $transaction->commit();

                //return $this->redirect(['detalle', 'id' => $model->idTarea]);
                $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
                $tareasUsuario = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', 0])->all();
                return $this->render('listarTareas', ['tareasUsuario' => $tareasUsuario]);

            } catch(\Exception $e) {

                //devuelve los cambios
                $transaction->rollBack();

                throw $e;
            }

        }else{
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
        $modelLogTareas = new LogTareas();

        if ($model->load(Yii::$app->request->post())) {

          $transaction = Tareas::getDb()->beginTransaction();

          try {


              $model->save();

              $innerTransaction = LogTareas::getDb()->beginTransaction();

              try {

                  $modelLogTareas->idTarea = $model->idTarea;
                  $modelLogTareas->estadoTarea = $model->estadoTarea;
                  $modelLogTareas->fechaRegistro = $model->fechaRegistro;
                  $modelLogTareas->progreso = $model->progreso;
                  $modelLogTareas->prioridad = $model->idPrioridad;

                  $modelLogTareas->save();
                  $innerTransaction->commit();

              } catch (Exception $e) {
                  $innerTransaction->rollBack();

                  throw $e;
               }


              //ejecuta la transaccion
              $transaction->commit();

              return $this->redirect(['detalle', 'id' => $model->idTarea]);

          } catch(\Exception $e) {

              //devuelve los cambios
              $transaction->rollBack();

              throw $e;
          }

        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * cambia el estado de una tarea existente a inactivo
     * si elimina correctamente redirige a listar tareas
     * @param POST => idtarea, location
     * @return mixed
     */
    public function actionEliminar()
    {
        $idTarea = Yii::$app->request->post('idTarea');
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $tarea = Tareas::findOne(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea]);
        $logTarea = new LogTareas();
        $location = Yii::$app->request->post('location');
        $view = '';

        $items = [];

        $transaction = Tareas::getDb()->beginTransaction();
        try {
            if ($location == 1) {
                $tarea->estadoTarea = 3;
            }else{
                $tarea->estadoTarea = 0;
            }

            if ($tarea->save()) {

              if ($location == 1) {
                  $view = '_tareasHome';
                  $tareasUsuario  = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', 0])->andWhere(['!=', 'estadoTarea', 3])->all();
              }else{
                  $view = '_listaTareas';
                  $tareasUsuario = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', 0])->all();
              }


              $items = [
                  'result' => 'ok',
                  'location' => $location,
                  'response' => $this->renderAjax($view, [
                      'tareasUsuario' => $tareasUsuario,
                  ])

                ];

            }

            $innerTransaction = LogTareas::getDb()->beginTransaction();
            try {
                $logTarea->idTarea = $tarea->idTarea;
                $logTarea->estadoTarea = $tarea->estadoTarea;
                $logTarea->fechaRegistro =  Date("Y-m-d H:i:s");
                $logTarea->prioridad = $tarea->idPrioridad;
                $logTarea->progreso = $tarea->progreso;
                $logTarea->save();
                $innerTransaction->commit();
            }
            catch (Exception $e) {
                $innerTransaction->rollBack();

                throw $e;
             }
             $transaction->commit();
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
             return $items;


        }
        catch(\Exception $e) {

            //devuelve los cambios
            $transaction->rollBack();

            throw $e;
        }

        //$modelTareas = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->all();
        //return $this->render('listarTareas', ['modelTareas' => $modelTareas]);
    }

    /**
     * actualizar el progreso de una tarea cuando mueven el slider
     *
     * @param POST => idtarea
     * @return mixed
     */
    public function actionActualizarProgreso()
    {
      $idTarea = Yii::$app->request->post('idTarea');
      $numeroDocumento = Yii::$app->user->identity->numeroDocumento;

      $tarea = Tareas::findOne(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea]);
      $logTarea = new LogTareas();

      $items = [];

      $transaction = Tareas::getDb()->beginTransaction();
      try {
          $tarea->progreso = Yii::$app->request->post('progresoTarea');
          if (Yii::$app->request->post('progresoTarea') == 100) {
              $tarea->estadoTarea = 1;
          }else{
              $tarea->estadoTarea = 2;
          }
          if ($tarea->save()) {
            $tareasUsuario = Tareas::find(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea])->all();
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $items = [
                'result' => 'ok',
                'response' => $this->renderAjax('_tareasHome', [
                    'tareasUsuario' => $tareasUsuario,
                        ]
            )];
          }

          $innerTransaction = LogTareas::getDb()->beginTransaction();
          try {
              $logTarea->idTarea = $tarea->idTarea;
              $logTarea->estadoTarea = $tarea->estadoTarea;
              $logTarea->fechaRegistro =  Date("Y-m-d H:i:s");
              $logTarea->prioridad = $tarea->idPrioridad;
              $logTarea->progreso = $tarea->progreso;
              $logTarea->save();
              $innerTransaction->commit();
          }
          catch (Exception $e) {
              $innerTransaction->rollBack();

              throw $e;
           }
           $transaction->commit();
           Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           return $items;


      }
      catch(\Exception $e) {

          //devuelve los cambios
          $transaction->rollBack();

          throw $e;
      }


    }


    /**
     * devuelve la tarea a su ultimo estado segun el log
     * @param POST => idtarea
     * @return mixed
     * @throws
     */
    public function actionUncheckHome()
    {
      $idTarea = Yii::$app->request->post('idTarea');
      $numeroDocumento = Yii::$app->user->identity->numeroDocumento;

      //\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      //return $LogTarea;
      //exit();
      $transaction = Tareas::getDb()->beginTransaction();
      try {
          $LogTarea = LogTareas::ultimosDosLogs($idTarea, $numeroDocumento);//find(['numeroDocumento' => $numeroDocumento])->andWhere(['idTarea' => $idTarea])->orderby('fechaRegistro ASC')->limit(2)->all();
          $tarea = Tareas::findOne(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea]);
          $tarea->estadoTarea = $LogTarea[0]->estadoTarea;
          $tarea->fechaRegistro = $LogTarea[0]->fechaRegistro;
          $tarea->idPrioridad = $LogTarea[0]->prioridad;
          $tarea->progreso = $LogTarea[0]->progreso;

          $tarea->save();

          $innerTransaction = LogTareas::getDb()->beginTransaction();
          try {
            $tarea = Tareas::findOne(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea]);
            $newLog = new LogTareas();
            $newLog->idTarea = $tarea->idTarea;
            $newLog->estadoTarea = $tarea->estadoTarea;
            $newLog->fechaRegistro =  Date("Y-m-d H:i:s");
            $newLog->prioridad = $tarea->idPrioridad;
            $newLog->progreso = $tarea->progreso;
            $newLog->save();
            $innerTransaction->commit();


          }  catch (Exception $e) {
              $innerTransaction->rollBack();

              throw $e;
           }
        $transaction->commit();

        $tareasUsuario = Tareas::getTareasIndex($numeroDocumento);
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $items = [
            'result' => 'ok',
            'response' => $this->renderAjax('_tareasHome', [
                'tareasUsuario' => $tareasUsuario,
                    ]
        )];

        return $items;

      }catch(\Exception $e) {

          //devuelve los cambios
          $transaction->rollBack();

          throw $e;
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
