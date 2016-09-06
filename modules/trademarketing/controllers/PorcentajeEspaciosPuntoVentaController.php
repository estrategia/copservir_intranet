<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\Espacio;
use app\modules\trademarketing\models\PorcentajeEspaciosPuntoVenta;
use app\modules\trademarketing\models\PorcentajeEspaciosPuntoVentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PorcentajeEspaciosPuntoVentaController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            /*
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                   'admin', 'index'
                 ],
                 'authsActions' => [
                     //colocar los permisos
                      'admin' => 'intranet_categoria-documento_admin',
                      'index' => 'intranet_usuario'
                 ]
             ],
             */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Selecciona un punto de venta para asignar los porcentajes
     * @return mixed
     */
    public function actionSeleccionPuntoVenta()
    {
      $model = new PorcentajeEspaciosPuntoVenta;

      if ($model->load(Yii::$app->request->post())) {
        return $this->redirect(['asignar', 'puntoVenta' => $model->idComercial]);
      }
      return $this->render('seleccion-punto-venta', [
          'model' => $model,
      ]);
    }
    /**
     * Crea o Actualiza los modelos PorcentajeEspaciosPuntoVenta por cada punto de venta.
     * @param string $puntoVenta
     * @return mixed
     */
    public function actionAsignar($puntoVenta)
    {
        $modelosEspacio = Espacio::getIdNameEspacios();
        $modelosPorcentaje = $this->getModelosPorcentaje($puntoVenta);

        if (Yii::$app->request->post()) {
          $dataEspacios = Yii::$app->request->post('PorcentajeEspaciosPuntoVenta') ;

          if (!$this->validarSumaPorcentajes($dataEspacios)) {
              Yii::$app->session->setFlash('error', 'La suma de los valores debe ser igual a 100');
          }else{

              $transaction = PorcentajeEspaciosPuntoVenta::getDb()->beginTransaction();

              try {
                foreach ($modelosPorcentaje as $index =>$porcentaje) {
                    $porcentaje->idComercial = $puntoVenta;
                    $porcentaje->idEspacio = $dataEspacios[$index]['idEspacio'];
                    $porcentaje->valor = $dataEspacios[$index]['valor'];

                    if (!$porcentaje->save()) {
                        throw new \Exception("Error al guardar un valor: ".json_encode($porcentaje->getErrors()), 101);
                    };
                }

                $transaction->commit();

              } catch (\Exception $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
              }
          }
          Yii::$app->session->setFlash('success', 'Los porcentajes se asignaron correctamente');
        }

        return $this->render('asignar', [
                'modelosPorcentaje' => $modelosPorcentaje,
                'modelosEspacio' => $modelosEspacio,
            ]);
    }

    /**
    * Crea un array de modelos PorcentajeEspaciosPuntoVenta dependiendo de los espacios creados y los modelos
    * PorcentajeEspaciosPuntoVenta que hayan po ese punto de venta
    * @param string $puntoVenta
    * @return Boolean
    */
    protected function getModelosPorcentaje($puntoVenta)
    {
        $modelosPorcentaje = array();
        $cantidadEspacios =  Espacio::countEspacios();
        $porcentajes = PorcentajeEspaciosPuntoVenta::getPorcentajeByPuntoVenta($puntoVenta);
        $cantidadPorcentajes =  PorcentajeEspaciosPuntoVenta::countPorcentajesByPuntoVenta($puntoVenta);

        foreach ($porcentajes as $modelo) {
          array_push($modelosPorcentaje, $modelo);
        }
        for ($i=$cantidadPorcentajes; $i < $cantidadEspacios ; $i++) {
          array_push($modelosPorcentaje, new PorcentajeEspaciosPuntoVenta());
        }

        return $modelosPorcentaje;
    }

    /**
    * Verifica que la suma de los porcentajes de cada uno de los espacios sea igual al 100%
    * @param array $dataEspacios
    * @return Boolean
    */
    public function validarSumaPorcentajes($dataEspacios)
    {
      $suma = 0;
      foreach ($dataEspacios as $key => $value) {
        $suma += $value['valor'];
      }

      if ($suma === 100) {
        return true;
      }else{
        return false;
      }
    }

    /**
     * Encuentra un modelo PorcentajeEspaciosPuntoVenta basado en el valor de su llave primaria.
     * @param string $id
     * @return modelo PorcentajeEspaciosPuntoVenta cargado
     * @throws NotFoundHttpException si no encuentra el modelo.
     */
    protected function encontrarModeloPorcentajeEspacio($id)
    {
        if (($model = PorcentajeEspaciosPuntoVenta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('El recurso no existe.');
        }
    }
}
