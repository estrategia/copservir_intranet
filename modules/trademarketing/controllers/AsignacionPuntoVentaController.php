<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\Categoria;
use app\modules\trademarketing\models\Espacio;
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

        if (Yii::$app->request->post()) {

          $dataCalificaciones = Yii::$app->request->post('CalificacionVariable');
          $finalizaAsignacion = Yii::$app->request->post('finalizar');

          $transaction = CalificacionVariable::getDb()->beginTransaction();

          try {

            foreach ($modelosCalificacion as $index => $calificacion) {
              $tempData = array('CalificacionVariable' => $dataCalificaciones[$index] );

              if ($calificacion->load($tempData)) {

                if (!$calificacion->save()) {

                    Yii::$app->session->setFlash('error', 'error al guardar la informacion'.json_encode($calificacion->getErrors()));

                };
              }
            }

            if( !is_null($finalizaAsignacion)) {
              $modeloAsignacion->setEstadoFinalizado();
            }else{
              $modeloAsignacion->setEstadoPendiente();
            }

            if (!$modeloAsignacion->save()) {
                Yii::$app->session->setFlash('error', 'error al guardar la informacion'.json_encode($modeloAsignacion->getErrors()));
            }else{

              if( !is_null($finalizaAsignacion)) {
                return $this->redirect(['asignaciones-calificadas']);
              }else{

                Yii::$app->session->setFlash('success', 'Progreso de la calificacion guardado con exito');
                return $this->refresh();
              }
            };

            $transaction->commit();

          } catch (Exception $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
          }
        }


        return $this->render('calificar', [
            'modeloAsignacion' => $modeloAsignacion,
            'modelosUnidadesNegocio' => $modelosUnidadesNegocio,
            'modelosCategoria' => $modelosCategoria,
            'modelosCalificacion' => $modelosCalificacion
        ]);

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

        return $this->render('reporte', [
            'modeloAsignacion' => $modeloAsignacion,
            'modelosUnidadesNegocio' => $modelosUnidadesNegocio,
            'modelosEspacios' => $modelosEspacios,
            'modelosRangoCalificaciones' => $modelosRangoCalificaciones,
            'porcentajesEspacios' => $porcentajesEspacios
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
