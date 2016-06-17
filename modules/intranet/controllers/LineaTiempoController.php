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
class LineaTiempoController extends Controller {
    public $defaultAction = "admin";

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar', 'eliminar'
                ],
            ],
            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar', 'eliminar'
                ],
                'authsActions' => [
                    'detalle' => 'intranet_linea-tiempo_admin',
                    'crear' => 'intranet_linea-tiempo_admin',
                    'actualizar' => 'intranet_linea-tiempo_admin',
                    'eliminar' => 'intranet_linea-tiempo_admin',
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

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lista todos los modelos LineaTiempo.
     * @return mixed
     */
    public function actionAdmin() {
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
    public function actionDetalle($id) {
        return $this->render('detalle', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo LineaTiempo.
     * @return mixed
     */
    public function actionCrear() {
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
    public function actionActualizar($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
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
    public function actionEliminar($id) {

      $model = $this->findModel($id);
      $model->estado = LineaTiempo::ESTADO_INACTIVO;

      if ($model->save()) {
          return $this->redirect(['admin']);
      }
    }

    /**
     * Encuentra un modelo LineaTiempo basado en su llave primaria.
     * @param string $id
     * @return LineaTiempo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = LineaTiempo::findOne(['idLineaTiempo' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
