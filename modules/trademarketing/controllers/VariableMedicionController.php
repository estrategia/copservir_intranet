<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\VariableMedicion;
use app\modules\trademarketing\models\VariableMedicionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class VariableMedicionController extends Controller
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
     * Lista todos los modelos VariableMedicion.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new VariableMedicionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Visualiza un solo modelo VariableMedicion.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->encontrarModeloVariable($id),
        ]);
    }

    /**
     * Crea un nuevo modelo VariableMedicion.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new VariableMedicion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idVariable]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo VariableMedicion existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->encontrarModeloVariable($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idVariable]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Inactiva un modelo VariableMedicion existente.
     * @param string $id
     * @return mixed
     */
    public function actionInactivar($id)
    {
        $model = $this->encontrarModeloVariable($id);
        $model->estado = VariableMedicion::ESTADO_INACTIVO;

        if (!$model->save()) {
            Yii::$app->session->setFlash('error', json_encode($model->getErrors()));
        }

        return $this->redirect(['admin']);
    }

    /**
     * Encuentra un modelo VariableMedicion basado en el valor de su llave primaria.
     * @param string $id
     * @return modelo VariableMedicion cargado
     * @throws NotFoundHttpException si no encuentra el modelo.
     */
    protected function encontrarModeloVariable($id)
    {
        if (($model = VariableMedicion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('El recurso no existe.');
        }
    }
}
