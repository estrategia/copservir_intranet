<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\MenuPortales;
use app\modules\intranet\models\MenuPortalesSearch;
use app\modules\intranet\models\ModuloContenidoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class MenuPortalesController extends Controller {
    public $defaultAction = 'admin';

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                     'admin', 'detalle', 'crear', 'actualizar', 'eliminar'
                 ],
                 'authsActions' => [
                   'admin' => 'intranet_menu-portales',
                   'detalle' => 'intranet_menu-portales',
                   'crear' => 'intranet_menu-portales',
                   'actualizar' => 'intranet_menu-portales',
                   'eliminar' => 'intranet_menu-portales',
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
     * Lista todos los modelos MenuPortales.
     * @return mixed
     */
    public function actionAdmin() {
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
    public function actionDetalle($id) {
        return $this->render('detalle', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo MenuPortales.
     * @return mixed
     */
    public function actionCrear() {
        $model = new MenuPortales();
        $searchModel = new ModuloContenidoSearch();
        $dataProviderModuloContenido = $searchModel->search(Yii::$app->request->queryParams);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idMenuPortales]);
        } else {
            return $this->render('crear', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProviderModuloContenido' => $dataProviderModuloContenido
            ]);
        }
    }

    /**
     * Actualiza un modelo MenuPortales existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $searchModel = new ModuloContenidoSearch();
        $dataProviderModuloContenido = $searchModel->search(Yii::$app->request->queryParams);


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idMenuPortales]);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
                        'searchModel' => $searchModel,
                        'dataProviderModuloContenido' => $dataProviderModuloContenido
            ]);
        }
    }

    /**
     * Elimina un modelo MenuPortales existente.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id) {

      $model = $this->findModel($id);
      $model->estado = MenuPortales::INACTIVO;

      if ($model->save()) {
          return $this->redirect(['admin']);
      }
    }

    /**
     * Ecuentra un modelo MenuPortales basado en su llave pimaria .
     * @param string $id
     * @return MenuPortales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MenuPortales::findOne(['idMenuPortales' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
