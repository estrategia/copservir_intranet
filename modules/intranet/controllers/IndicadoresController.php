<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\Indicadores;
use app\modules\intranet\models\IndicadoresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class IndicadoresController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista todos los modelos Indicadores.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new IndicadoresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un solo modelo Indicadores.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo Indicadores.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Indicadores();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idIndicador]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo Indicadores existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idIndicador]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Inactiva un modelo Indicadores existente.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
      $model = $this->findModel($id);
      $model->estado = Indicadores::ESTADO_INACTIVO;

      if ($model->save()) {
          return $this->redirect(['admin']);
      }
    }

    /**
     * Encuentra un modelo Indicadores basado en el valor de su llave primaria.
     * @param string $id
     * @return Indicadores el modelo cargado
     * @throws NotFoundHttpException si no encuentra el modelo
     */
    protected function findModel($id)
    {
        if (($model = Indicadores::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
