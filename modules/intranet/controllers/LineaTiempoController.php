<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\LineaTiempo;
use app\modules\intranet\models\LineaTiempoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LineaTiempoController.
 */
class LineaTiempoController extends Controller
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
     * Lista todos los modelos LineaTiempo.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LineaTiempoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un solo modelo LineaTiempo.
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
     * Crea un nuevo modelo LineaTiempo.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new LineaTiempo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idLineaTiempo]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo LineaTiempo existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idLineaTiempo]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Elimina un modelo LineaTiempo existente.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Encuentra un modelo LineaTiempo basado en su llave primaria.
     * @param string $id
     * @return LineaTiempo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LineaTiempo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
