<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\Categoria;
use app\modules\trademarketing\models\CategoriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class CategoriaController extends Controller
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
     * Lista todos los modelos Categoria.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new CategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Visualiza un solo modelo Categoria.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->encontrarModeloCategoria($id),
        ]);
    }

    /**
     * Crea un nuevo modelo Categoria.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Categoria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idCategoria]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo Categoria existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->encontrarModeloCategoria($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idCategoria]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Inactiva un modelo Categoria existente.
     * @param string $id
     * @return mixed
     */
    public function actionInactivar($id)
    {
        $model = $this->encontrarModeloCategoria($id);
        $model->estado = Categoria::ESTADO_INACTIVO;

        if (!$model->save()) {
            Yii::$app->session->setFlash('error', json_encode($model->getErrors()));
        }

        return $this->redirect(['admin']);
    }

    /**
     * Encuentra un modelo Categoria basado en el valor de su llave primaria.
     * @param string $id
     * @return modelo Categoria cargado
     * @throws NotFoundHttpException si no encuentra el modelo.
     */
    protected function encontrarModeloCategoria($id)
    {
        if (($model = Categoria::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('El recurso no existe.');
        }
    }
}
