<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\Categoria;
use app\modules\trademarketing\models\Espacio;
use app\modules\trademarketing\models\Reporte;
use app\modules\trademarketing\models\Observaciones;
use app\modules\trademarketing\models\PorcentajeUnidad;
use app\modules\trademarketing\models\RangoCalificaciones;
use app\modules\trademarketing\models\CalificacionVariable;
use app\modules\trademarketing\models\AsignacionPuntoVenta;
use app\modules\trademarketing\models\AsignacionPuntoVentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class AsignacionPuntoVentaController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],

            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                   'asignaciones-pendientes', 'asignaciones-calificadas','detalle', 'calificar'
                 ],
                 'authsActions' => [
                     //colocar los permisos
                      'asignaciones-pendientes' => 'tradeMarketing_asignaciones_supervisor',
                      'asignaciones-calificadas' => 'tradeMarketing_asignaciones_supervisor',
                      'detalle' => 'tradeMarketing_asignaciones_supervisor',
                      'calificar' => 'tradeMarketing_asignaciones_supervisor'
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
     * Lista todos los modelos AsignacionPuntoVenta que estan pendientes
     * @return mixed
     */
    public function actionAsignacionesPendientes()
    {
        $searchModel = new AsignacionPuntoVentaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('asignaciones-pendientes', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lista todos los modelos AsignacionPuntoVenta que estan calificadas
     * @return mixed
     */
    public function actionAsignacionesCalificadas()
    {
        $searchModel = new AsignacionPuntoVentaSearch();
        $dataProvider = $searchModel->searchCalificadas(Yii::$app->request->queryParams);

        return $this->render('asignaciones-calificadas', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Visualiza un solo modelo AsignacionPuntoVenta que esta pendiente
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->encontrarModeloAsignacion($id),
        ]);
    }

    /**
    * verifica si la suma de los porcentajes de las unidades de negocio es igual a 100
    * @param array $dataPorcentajeUnidad
    * @return Boolean
    */
    protected function validarSumaPorcentajesUnidad($dataPorcentajeUnidad)
    {
        $suma = 0;
        foreach ($dataPorcentajeUnidad as $key => $value) {
          $suma += $value['porcentaje'];
        }

        if ($suma === 100) {
          return true;
        }else{
          return false;
        }
    }

    /**
     * Permite la calificacion de un punto de venta asignado
     * @param string $id: id de la asignacion
     * @return mixed
     */
    public function actionCalificar($id)
    {
        $informacionCalificacion = new Reporte();
        $informacionCalificacion->generarValoresCalificacion($id);
        $modeloAsignacion =  $informacionCalificacion->asignacion;
        $modelosPorcentajeUnidad = $informacionCalificacion->porcentajeUnidades;
        $modelosCalificacion = $informacionCalificacion->calificaciones;
        $modelosObservaciones = $informacionCalificacion->observaciones;
        $modelosUnidadesNegocio = $informacionCalificacion->unidadesNegocio;
        $modelosCategoria = $informacionCalificacion->categorias;
        $informacionReporte = $informacionCalificacion->generarDatos($id);
        // \yii\helpers\VarDumper::dump($informacionCalificacion, 10, true);
        // \yii\helpers\VarDumper::dump($informacionReporte, 10, true);exit();
        // \yii\helpers\VarDumper::dump($modelosCategoria, 10, exit);exit();

        if ($modeloAsignacion->estado === AsignacionPuntoVenta::ESTADO_CALIFICADO) {
            //throw new \Exception("El punto de venta ya ha sido calificado " , 100);
            throw new \yii\web\HttpException(404, 'El punto de venta ya ha sido calificado ');
        }

        if ($modeloAsignacion->estado === AsignacionPuntoVenta::ESTADO_INACTIVO) {
            throw new \yii\web\HttpException(404, 'La asignacion se encuentra inactiva');
        }

        if (Yii::$app->request->post()) {

          $dataCalificaciones = Yii::$app->request->post('CalificacionVariable');
          $dataObservaciones = Yii::$app->request->post('Observaciones');
          $dataPorcentajeUnidad = Yii::$app->request->post('PorcentajeUnidad');
          $finalizaAsignacion = Yii::$app->request->post('finalizar');

          if ($this->validarSumaPorcentajesUnidad($dataPorcentajeUnidad)) {

              try {
                $transaction = CalificacionVariable::getDb()->beginTransaction();
                //guarda las calificaciones
                foreach ($modelosCalificacion as $index => $calificacion) {
                  $tempData = array('CalificacionVariable' => $dataCalificaciones[$index] );

                  if ($calificacion->load($tempData)) {

                    if (!$calificacion->save()) {

                        //throw new \Exception("'error observacion:" .json_encode($observacion->getErrors()) , 100);
                        Yii::$app->session->setFlash('error calificacion', 'error al guardar la informacion'.json_encode($calificacion->getErrors()));

                    };
                  }
                }

                //guarda las observaciones

                foreach ($modelosObservaciones as $index => $observacion) {
                  $tempData = array('Observaciones' => $dataObservaciones[$index] );

                  if ($observacion->load($tempData)) {

                    if (!$observacion->save()) {
                        //throw new \Exception("'error observacion:" .json_encode($observacion->getErrors()) , 100);
                        Yii::$app->session->setFlash('error observacion', 'error al guardar la informacion'.json_encode($observacion->getErrors()));
                    };
                  }
                }

                //guarda los porcentajes de unidad
                foreach ($modelosPorcentajeUnidad as $index => $porcentaje) {
                    $tempData = array('PorcentajeUnidad' => $dataPorcentajeUnidad[$index] );

                    if ($porcentaje->load($tempData)) {

                      if (!$porcentaje->save()) {
                          //throw new \Exception("error porcentaje:" .json_encode($porcentaje->getErrors()) , 100);
                          Yii::$app->session->setFlash('error porcentaje', 'error al guardar la informacion'.json_encode($porcentaje->getErrors()));
                      };
                    }
                }

                // cambia el estado de la asignacion

                if( !is_null($finalizaAsignacion)) {
                  $modeloAsignacion->setEstadoFinalizado();
                  // $modeloAsignacion->setEstadoPendiente(); // Solo para pruebas
                }else{
                  $modeloAsignacion->setEstadoPendiente();
                }

                if (!$modeloAsignacion->save()) {
                    throw new \Exception("Error asignacion:" .json_encode($modeloAsignacion->getErrors()) , 100);
                    //Yii::$app->session->setFlash('error asignacion', 'error al guardar la informacion'.json_encode($modeloAsignacion->getErrors()));
                }else{
                  $informacionReporte = $informacionCalificacion->generarDatos($id);

                  if( !is_null($finalizaAsignacion)) {
                    $transaction->commit();
                    return $this->render('reporte', ['informacionReporte' => $informacionReporte]);
                  }else{

                    $transaction->commit();
                    Yii::$app->session->setFlash('success', 'Progreso de la calificacion guardado con exito');
                    return $this->refresh();
                  }
                };

              } catch (Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error catch', $e->getMessage());
              }

          }else{
            Yii::$app->session->setFlash('error', 'La suma de los porcentajes debe ser igual a 100');
          }
        }

        return $this->render('calificar', [
            'modeloAsignacion' => $modeloAsignacion,
            'modelosUnidadesNegocio' => $modelosUnidadesNegocio,
            'modelosCategoria' => $modelosCategoria,
            'modelosCalificacion' => $modelosCalificacion,
            'modelosObservaciones' => $modelosObservaciones,
            'modelosPorcentajeUnidad' => $modelosPorcentajeUnidad,
            'informacionReporte' => $informacionReporte
        ]);

    }

    /**
     * Visualiza los reportes generados el punto de venta
     * @param string $id: id de la asignacion
     * @return mixed
     */
    public function actionReporte($id)
    {

        $modeloReportes = new Reporte();
        $informacionReporte = $modeloReportes->generarDatos($id);

        if ($informacionReporte['asignacion']['estado'] === AsignacionPuntoVenta::ESTADO_PENDIENTE) {
            throw new \Exception("El punto de venta  no ha sido calificado" , 100);
        }

        if ($informacionReporte['asignacion']['estado'] === AsignacionPuntoVenta::ESTADO_INACTIVO) {
            throw new \Exception("La asignacion se encuentra inactiva " , 100);
        }

        return $this->render('reporte', [
          'informacionReporte' => $informacionReporte,
          
        ]);
    }

    public function actionListarObservaciones()
    {
        $idAsignacion = $_POST['idAsignacion'];
        $idVariable = $_POST['idVariable'];
        // $idAsignacion = 1;
        // $idVariable = 1;
        $model = new Observaciones();
        $observaciones = $model->find()
            ->where(['idAsignacion' => $idAsignacion])
            ->andWhere(['idVariable' => $idVariable])
            ->all();
        \Yii::$app->response->format = 'json';
        return $observaciones;
    }

    /**
     * Encuentra un modelo AsignacionPuntoVenta basado en el valor de su llave primaria
     * @param string $id
     * @return modelo AsignacionPuntoVenta cargado
     * @throws NotFoundHttpException si no encuentra el modelo
     */
    protected function encontrarModeloAsignacion($id)
    {
        if (($model = AsignacionPuntoVenta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('El recurso no existe.');
        }
    }

}