<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\Categoria;
use app\modules\trademarketing\models\Espacio;
use app\modules\trademarketing\models\Observaciones;
use app\modules\trademarketing\models\PorcentajeUnidad;
use app\modules\trademarketing\models\RangoCalificaciones;
use app\modules\trademarketing\models\CalificacionVariable;
use app\modules\trademarketing\models\AsignacionPuntoVenta;
use app\modules\trademarketing\models\AsignacionPuntoVentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;


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
     * Crea calificaciones para una asignacion
     * @param string $id
     * @return mixed
     */
    public function actionCalificar($id)
    {

        $modeloAsignacion = $this->encontrarModeloAsignacion($id);
        $modelosUnidadesNegocio = $this->callWSGetUnidadesNegocio();
        $modelosCategoria = Categoria::getCategorias();
        $modelosCalificacion = $this->getModelosCalificacion($id, $modelosCategoria, $modelosUnidadesNegocio);
        $modelosObservaciones = $this->getObservaciones($id, $modelosCategoria);
        $modelosPorcentajeUnidad = $this->getPorcentajesUnidad($id, $modelosUnidadesNegocio);

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
                        Yii::$app->session->setFlash('error calificacion', 'error al guardar la informacion'.json_encode($calificacion->getErrors()));

                    };
                  }
                }

                //guarda las observaciones

                foreach ($modelosObservaciones as $index => $observacion) {
                  $tempData = array('Observaciones' => $dataObservaciones[$index] );

                  if ($observacion->load($tempData)) {

                    if (!$observacion->save()) {
                        throw new \Exception("'error observacion:" .son_encode($observacion->getErrors()) , 100);
                        ///Yii::$app->session->setFlash('error observacion', 'error al guardar la informacion'.json_encode($observacion->getErrors()));
                    };
                  }
                }

                //guarda los porcentajes de unidad
                foreach ($modelosPorcentajeUnidad as $index => $porcentaje) {
                    $tempData = array('PorcentajeUnidad' => $dataPorcentajeUnidad[$index] );

                    if ($porcentaje->load($tempData)) {

                      if (!$porcentaje->save()) {
                          throw new \Exception("error porcentaje:" .json_encode($porcentaje->getErrors()) , 100);
                          ///Yii::$app->session->setFlash('error porcentaje', 'error al guardar la informacion'.json_encode($porcentaje->getErrors()));
                      };
                    }
                }

                // cambia el estado de la asignacion

                if( !is_null($finalizaAsignacion)) {
                  $modeloAsignacion->setEstadoFinalizado();
                }else{
                  $modeloAsignacion->setEstadoPendiente();
                }

                if (!$modeloAsignacion->save()) {
                    throw new \Exception("Error asignacion:" .json_encode($modeloAsignacion->getErrors()) , 100);
                    //Yii::$app->session->setFlash('error asignacion', 'error al guardar la informacion'.json_encode($modeloAsignacion->getErrors()));
                }else{

                  if( !is_null($finalizaAsignacion)) {
                    $transaction->commit();
                    return $this->redirect(['asignaciones-calificadas']);
                  }else{

                    Yii::$app->session->setFlash('success', 'Progreso de la calificacion guardado con exito');
                    $transaction->commit();
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
            'modelosPorcentajeUnidad' => $modelosPorcentajeUnidad
        ]);

    }


    /**
    * Crea un array de modelos PorcentajeUnidad dependiendo de las unidades de negocio
    * @param int $idAsignacion, array<unidadNegocio> $modelosUnidadesNegocio
    * @return array<PorcentajeUnidad>
    */
    protected function getPorcentajesUnidad($idAsignacion, $modelosUnidadesNegocio)
    {
        $modelosPorcentajeUnidad = array();

        foreach ($modelosUnidadesNegocio as $unidad) {
          $modelo = PorcentajeUnidad::find()->where([ 'idAsignacion' => $idAsignacion, 'idAgrupacion' => $unidad['IdAgrupacion'] ])->one();

          if ($modelo !== null) {
            array_push($modelosPorcentajeUnidad, $modelo);
          }else{
            array_push($modelosPorcentajeUnidad, new PorcentajeUnidad());
          }
        }

        return $modelosPorcentajeUnidad;
    }

    /**
    * Crea un array de modelos Observaciones dependiendo de las variables
    * @param int $idAsignacion, array<Categoria> $modelosCategoria
    * @return array<Observaciones>
    */
    protected function getObservaciones($idAsignacion, $modelosCategoria)
    {
        $modelosObservacion = array();

        foreach ($modelosCategoria as $categoria) {

          foreach ($categoria->variablesMedicion as $variable){
              $modelo = Observaciones::find()->where(['idAsignacion' => $idAsignacion, 'idVariable' => $variable->idVariable])->one();
              if ($modelo !== null) {
                array_push($modelosObservacion, $modelo);
              }else{
                array_push($modelosObservacion, new Observaciones);
              }
          }
        }

        return $modelosObservacion;
    }

    /**
    * Crea un array de modelos CalificacionVariable dependiendo de las variables y unidades de negocio
    * @param int $idAsignacion, array<Categoria> $modelosCategoria, array $unidadesNegocio
    * @return array<CalificacionVariable>
    */
    protected function getModelosCalificacion($idAsignacion, $modelosCategoria, $unidadesNegocio)
    {
      $modelosCalificacion = array();

      foreach ($modelosCategoria as $categoria) {

        foreach ($categoria->variablesMedicion as $variable){

          if ($variable->calificaUnidadNegocio === 1) {

            foreach ($unidadesNegocio as $unidad) {

              $modelo = CalificacionVariable::find()->where(['idAsignacion' => $idAsignacion, 'idVariable' => $variable->idVariable, 'IdAgrupacion' => $unidad['IdAgrupacion']])->one();

              if ($modelo !== null) {
                array_push($modelosCalificacion, $modelo);
              }else{
                array_push($modelosCalificacion, new CalificacionVariable());
              }
            }

          }else{

            $modelo = CalificacionVariable::find()->where(['idAsignacion' => $idAsignacion, 'idVariable' => $variable->idVariable])->one();

            if ($modelo !== null) {
              array_push($modelosCalificacion, $modelo);
            }else{
              array_push($modelosCalificacion, new CalificacionVariable());
            }
          }
        }
      }

      return $modelosCalificacion;
    }

    /**
     * Peticion mediante un webService soap a siicop de las unidades de negocio
     * @param string $id
     * @return mixed
     */
    protected function callWSGetUnidadesNegocio()
    {
        $client = new \SoapClient(\Yii::$app->params['webServices']['tradeMarketing']['unidades'], array(
            "trace" => 1,
            "exceptions" => 0,
            'connection_timeout' => 5,
            //'cache_wsdl' => WSDL_CACHE_NONE
        ));

        try {
            $result = $client->getUnidades();
            return $result;
        } catch (SoapFault $ex) {
            Yii::error($ex->getMessage());
        } catch (Exception $ex) {
            Yii::error($ex->getMessage());
        }
    }


    public function actionReporte($id)
    {
        $modeloAsignacion = $this->encontrarModeloAsignacion($id);
        $modelosUnidadesNegocio = $this->callWSGetUnidadesNegocio();
        $modelosEspacios = Espacio::find()->all();
        $modelosRangoCalificaciones = RangoCalificaciones::find()->orderBy('valor')->all();
        $porcentajesEspacios = $this->getPorcentajesEspacio($modelosEspacios, $modeloAsignacion->idComercial);
        $porcentajesUnidades = $this->getPorcentajesUnidades($modelosUnidadesNegocio, $modeloAsignacion->idAsignacion);

        return $this->render('reporte', [
            'modeloAsignacion' => $modeloAsignacion,
            'modelosUnidadesNegocio' => $modelosUnidadesNegocio,
            'modelosEspacios' => $modelosEspacios,
            'modelosRangoCalificaciones' => $modelosRangoCalificaciones,
            'porcentajesEspacios' => $porcentajesEspacios,
            'porcentajesUnidades' => $porcentajesUnidades,
        ]);
    }

    protected function getPorcentajesEspacio($modelosEspacios, $idComercial)
    {
      $porcentajeEspacios = array();

      foreach ($modelosEspacios as $espacio) {

        $porcentaje = $espacio->getPorcentajeEspacio($idComercial, $espacio->idEspacio);
        if ($porcentaje != null) {
          $porcentajeEspacios[$espacio->nombre] = $porcentaje->valor;
        }else{
          $porcentajeEspacios[$espacio->nombre] = 0;
          Yii::$app->session->setFlash('error', "Faltan porcentajes para los espacios, los calculos se haran con ceros");
        }
      }

      return $porcentajeEspacios;

    }


    protected function getPorcentajesUnidades($modelosUnidadesNegocio, $idAsignacion)
    {
      $porcentajeUnidades = array();

      foreach ($modelosUnidadesNegocio as $unidad) {

        $modelo = PorcentajeUnidad::find()->where(['idAsignacion' => $idAsignacion, 'idAgrupacion' => $unidad['IdAgrupacion']])->one();

        if ($modelo != null) {
          $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = $modelo->porcentaje;
        }else{
          $porcentajeUnidades[$unidad['NombreUnidadNegocio']] = 0;
          Yii::$app->session->setFlash('error', "No se encontraron porcentajes para las unidades, los calculos se haran con ceros");
        }
      }

      return $porcentajeUnidades;

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
