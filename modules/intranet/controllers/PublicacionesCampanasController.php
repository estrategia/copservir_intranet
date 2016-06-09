<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\CampanasDestino;
use app\modules\intranet\models\PublicacionesCampanas;
use app\modules\intranet\models\PublicacionesCampanasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PublicacionesCampanasController.
 */
class PublicacionesCampanasController extends Controller {
    public $defaultAction = 'admin';

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar', 'eliminar',
                    'eliminar-campana-destino', 'agrega-destino-campana'
                ],
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
     * Lista todos lo modelos PublicacionesCampanas.
     * @return mixed
     */
    public function actionAdmin() {
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
    public function actionDetalle($id) {
        return $this->render('detalle', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo PublicacionesCampanas.
     * @return mixed
     */
    public function actionCrear() {
        $model = new PublicacionesCampanas();
        if ($model->load(Yii::$app->request->post())) {
            $model->guardarImagen();

            $transaction = PublicacionesCampanas::getDb()->beginTransaction();

            try {
                if ($model->save()) {
                    $transaction->commit();
                    return $this->redirect(['actualizar', 'id' => $model->idImagenCampana]);
                }
            } catch (\Exception $e) {

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
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $destinoCampanas = CampanasDestino::listaDestinos($model->idImagenCampana);
        $modelDestinoCampana = new CampanasDestino;


        if ($model->load(Yii::$app->request->post())) {
            $model->guardarImagen();
            $transaction = PublicacionesCampanas::getDb()->beginTransaction();

            try {
                if ($model->save()) {
                    $transaction->commit();
                    return $this->redirect(['detalle', 'id' => $model->idImagenCampana]);
                }
            } catch (\Exception $e) {

                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
                throw $e;
            }
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
                        'destinoCampanas' => $destinoCampanas,
                        'modelDestinoCampana' => $modelDestinoCampana
            ]);
        }
    }

    /**
     * Elimina un modelo PublicacionesCampanas existente.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * @return mixed
     */
    public function actionEliminarCampanaDestino() {

        $idCiudad = Yii::$app->request->post('idCiudad', '');
        $idGrupoInteres = Yii::$app->request->post('idGrupo', '');
        $idCampana = Yii::$app->request->post('idCampana', '');
        $respond = [
            'result' => 'error',
        ];

        $campanaDestino = $this->findModelCampanaDestino($idCampana, $idGrupoInteres, $idCiudad);

        if ($campanaDestino->delete()) {

            $model = $this->findModel($idCampana);
            $destinoCampanas = CampanasDestino::listaDestinos($model->idImagenCampana);
            $modelDestinoCampana = new CampanasDestino;

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('_destinoCampanas', [
                    'model' => $model,
                    'destinoCampanas' => $destinoCampanas,
                    'modelDestinoCampana' => $modelDestinoCampana
            ])];
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * @return respond = []
     *         respond.result = indica si todo se realizo bien o mal
     *         respond.response = html para renderizar los destinos de las ofertas
     */
    public function actionAgregaDestinoCampana() {
        $modelDestinoCampana = new CampanasDestino;

        $model = $this->findModel($modelDestinoCampana->idImagenCampana);
        $destinoCampana = CampanasDestino::listaDestinos($model->idImagenCampana);

        if ($modelDestinoCampana->save()) {
            $modelDestinoCampana = new CampanasDestino;
        }

        $respond = [
          'result' => 'ok',
          'response' => $this->renderAjax('_destinoCampanas', [
            'model' => $model,
            'destinoCampanas' => $destinoCampana,
            'modelDestinoCampana' => $modelDestinoCampana
        ])];

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;

        }

    /**
     * Encuentra un modelo PublicacionesCampanas basado en su llave primaria.
     * @param string $id
     * @return PublicacionesCampanas the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = PublicacionesCampanas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelCampanaDestino($idImagenCampana, $idGrupoInteres, $idCiudad) {
        $model = CampanasDestino::find()->where('( codigoCiudad =:idCiudad and idGrupoInteres =:idGrupoInteres and idImagenCampana =:idImagenCampana )')
                ->addParams(['idCiudad' => $idCiudad, 'idGrupoInteres' => $idGrupoInteres, 'idImagenCampana' => $idImagenCampana])
                ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
