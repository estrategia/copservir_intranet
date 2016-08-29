<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\RangoCalificaciones;
use app\modules\trademarketing\models\RangoCalificacionesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class RangoCalificacionesController extends Controller
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
     * Lista todos los modelos RangoCalificaciones.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new RangoCalificacionesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Visualiza un solo modelo RangoCalificaciones.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->encontrarModeloRangoCalificaciones($id),
        ]);
    }

    /**
     * Crea un nuevo modelo RangoCalificaciones.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new RangoCalificaciones();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idRangoCalificacion]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiaz un modelo RangoCalificaciones existente.
     * @param integer $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->encontrarModeloRangoCalificaciones($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idRangoCalificacion]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Inactiva un modelo RangoCalificaciones existente.
     * @param integer $id
     * @return mixed
     */
    public function actionInactivar($id)
    {
        $model = $this->encontrarModeloRangoCalificaciones($id);
        $model->estado = Categoria::ESTADO_INACTIVO;

        if (!$model->save()) {
            Yii::$app->session->setFlash('error', json_encode($model->getErrors()));
        }

        return $this->redirect(['admin']);
    }

    /**
     * Encuentra un modelo RangoCalificaciones basado en el valor de su llave primaria.
     * @param integer $id
     * @return modelo RangoCalificaciones cargado
     * @throws NotFoundHttpException si no encuentra el modelo.
     */
    protected function encontrarModeloRangoCalificaciones($id)
    {
        if (($model = RangoCalificaciones::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('El recurso no existe.');
        }
    }
}
