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
        $modelTareas = Tareas::find()->where(['numeroDocumento' => $numeroDocumento])->andWhere(['!=', 'estadoTarea', 0])->all();
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

                return $this->redirect(['detalle', 'id' => $model->idTarea]);

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
     * @param string $id
     * @return mixed
     */
    public function actionEliminar()
    {
        $idTarea = Yii::$app->request->post('idTarea');
        $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
        $tarea = Tareas::findOne(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea]);
        echo var_dump($tarea);
        $logTarea = new LogTareas();


        $items = [];

        $transaction = Tareas::getDb()->beginTransaction();
        try {
            if (Yii::$app->request->post('location') == 1) {
                $tarea->estadoTarea = 3;
            }else{
                $tarea->estadoTarea = 0;
            }

            if ($tarea->save()) {
              $items = [
                  'result' => 'ok',
              ];
            }

            $innerTransaction = LogTareas::getDb()->beginTransaction();
            try {
                $logTarea->idTarea = $tarea->idTarea;
                $logTarea->estadoTarea = $tarea->estadoTarea;
                $logTarea->fechaRegistro =  Date("Y-m-d h:i:s");
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
     * @param
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
            $items = [
                'result' => 'ok',
            ];
          }

          $innerTransaction = LogTareas::getDb()->beginTransaction();
          try {
              $logTarea->idTarea = $tarea->idTarea;
              $logTarea->estadoTarea = $tarea->estadoTarea;
              $logTarea->fechaRegistro =  Date("Y-m-d h:i:s");
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
     * @param string $id
     * @return Tareas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUncheckHome()
    {
      $idTarea = Yii::$app->request->post('idTarea');
      $numeroDocumento = Yii::$app->user->identity->numeroDocumento;

      $LogTarea = LogTareas::find(['numeroDocumento' => $numeroDocumento])->andWhere(['idTarea' => $idTarea])->orderby('fechaRegistro ASC')->limit(2)->all();
      $tarea = Tareas::findOne(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea]);
      //echo var_dump($LogTarea);

      $transaction = Tareas::getDb()->beginTransaction();
      try {
          $tarea->estadoTarea = $LogTarea[1]->estadoTarea;
          $tarea->fechaRegistro = $LogTarea[1]->fechaRegistro;
          $tarea->idPrioridad = $LogTarea[1]->prioridad;
          $tarea->progreso = $LogTarea[1]->progreso;

          $tarea->save();

          $innerTransaction = LogTareas::getDb()->beginTransaction();
          try {
            $newLog = new LogTareas();
            $newLog->idTarea = $tarea->idTarea;
            $newLog->estadoTarea = $tarea->estadoTarea;
            $newLog->fechaRegistro =  Date("Y-m-d h:i:s");
            $newLog->prioridad = $tarea->idPrioridad;
            $newLog->progreso = $tarea->progreso;
            $newLog->save();
            $innerTransaction->commit();


          }  catch (Exception $e) {
              $innerTransaction->rollBack();

              throw $e;
           }
        $transaction->commit();

      }catch(\Exception $e) {

          //devuelve los cambios
          $transaction->rollBack();

          throw $e;
      }

      echo $tarea->progreso;


      $tareasUsuario = Tareas::find(['numeroDocumento' => $numeroDocumento, 'idTarea' => $idTarea])->all();
      \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      $items = [
          'result' => 'ok',
          'response' => $this->renderAjax('_tareasHome', [
              'tareasUsuario' => $tareasUsuario,
                  ]
      )];
      return $items;





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
