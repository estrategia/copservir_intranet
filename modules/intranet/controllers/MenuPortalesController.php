<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\MenuPortales;
use app\modules\intranet\models\MenuPortalesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class MenuPortalesController extends Controller
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
     * Lista todos los modelos MenuPortales.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new MenuPortalesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un solo modelo MenuPortales.
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
     * Crea un nuevo modelo MenuPortales.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new MenuPortales();
        $dataProviderModuloContenido = $model->getDataProviderModuloContenido();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idMenuPortales]);
        } else {
            return $this->render('crear', [
                'model' => $model,
                'dataProviderModuloContenido'=> $dataProviderModuloContenido
            ]);
        }
    }

    /**
     * Actualiza un modelo MenuPortales existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);
        $dataProviderModuloContenido = $model->getDataProviderModuloContenido();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idMenuPortales]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
                'dataProviderModuloContenido'=> $dataProviderModuloContenido
            ]);
        }
    }

    /**
     * Elimina un modelo MenuPortales existente.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * Ecuentra un modelo MenuPortales basado en su llave pimaria .
     * @param string $id
     * @return MenuPortales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MenuPortales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
