<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\PublicacionesCampanas;
use app\modules\intranet\models\PublicacionesCampanasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PublicacionesCampanasController.
 */
class PublicacionesCampanasController extends Controller
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
     * Lista todos lo modelos PublicacionesCampanas.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PublicacionesCampanasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un solo modelo PublicacionesCampanas.
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
     * Crea un nuevo modelo PublicacionesCampanas.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new PublicacionesCampanas();
        if ($model->load(Yii::$app->request->post())) {
            $model->guardarImagen();

            $transaction = PublicacionesCampanas::getDb()->beginTransaction();

            try {
              if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['detalle', 'id' => $model->idImagenCampana]);
              }
            } catch(\Exception $e) {

              $transaction->rollBack();
              Yii::$app->session->setFlash('error', $e->getMessage());
              throw $e;
            }
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo PublicacionesCampanas existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
          $model->guardarImagen();
          exit();
          $transaction = PublicacionesCampanas::getDb()->beginTransaction();

          try {
            if ($model->save()) {
              $transaction->commit();
              return $this->redirect(['detalle', 'id' => $model->idImagenCampana]);
            }
          } catch(\Exception $e) {

            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
            throw $e;
          }
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Elimina un modelo PublicacionesCampanas existente.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Encuentra un modelo PublicacionesCampanas basado en su llave primaria.
     * @param string $id
     * @return PublicacionesCampanas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PublicacionesCampanas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
