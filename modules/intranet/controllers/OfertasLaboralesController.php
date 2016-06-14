<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\OfertasLaborales;
use app\modules\intranet\models\OfertasLaboralesDestino;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfertasLaboralesController implements the CRUD actions for OfertasLaborales model.
 */
class OfertasLaboralesController extends Controller {
    public $defaultAction = 'admin';

    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar',
                    'eliminar', 'eliminar-oferta-destino', 'agrega-destino-oferta'
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
     * Lists all OfertasLaborales models.
     * @return mixed
     */
    public function actionAdmin() {
        $userCiudad = Yii::$app->user->identity->getCiudadCodigo();
        $ofertas = new OfertasLaborales;
        $data = $ofertas->getVertodos(Yii::$app->request->queryParams);

        return $this->render('listarOfertas', [
                    'dataProvider' => $data,
        ]);
    }

    /**
     * Displays a single OfertasLaborales model.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id) {
        return $this->render('detalle', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo de OfertasLaborales y los registros de su respectivo registro
     * si la creacion es exitosa redirige a la vista listarOfertas
     * @return mixed
     */
    public function actionCrear() {

        $model = new OfertasLaborales();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = OfertasLaborales::getDb()->beginTransaction();

            try {

                if ($model->save()) {
                    $transaction->commit();
                    return $this->redirect(['actualizar', 'id' => $model->idOfertaLaboral]);
                } else {
                    //ocurrio un error al guardar
                    return $this->render('crear', [
                                'model' => $model,
                    ]);
                }
            } catch (\Exception $e) {

                $transaction->rollBack();
                throw $e;
            }
        } else {

            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OfertasLaborales model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $destinoOfertasLaborales = OfertasLaboralesDestino::listaOfertas($id);
        $modelDestinoOferta = new OfertasLaboralesDestino;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['admin']);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
                        'destinoOfertasLaborales' => $destinoOfertasLaborales,
                        'modelDestinoOferta' => $modelDestinoOferta
            ]);
        }
    }

    /**
     * Deletes an existing OfertasLaborales model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return mixed
     */
    public function actionEliminarOfertaDestino() {
        $idCiudad = Yii::$app->request->post('idCiudad', '');
        $idGrupoInteres = Yii::$app->request->post('idGrupo', '');
        $idOferta = Yii::$app->request->post('idOferta', '');
        $respond = [
            'result' => 'error',
        ];

        $ofertaDestino = $this->findModelOfertaDestino($idOferta, $idGrupoInteres, $idCiudad);

        if ($ofertaDestino->delete()) {

            $model = $this->findModel($idOferta);
            $destinoOfertasLaborales = OfertasLaboralesDestino::listaOfertas($idOferta);
            $modelDestinoOferta = new OfertasLaboralesDestino;

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('_destinoOfertas', [
                    'model' => $model,
                    'destinoOfertasLaborales' => $destinoOfertasLaborales,
                    'modelDestinoOferta' => $modelDestinoOferta
            ])];
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * @param none
     * @return respond = []
     *         respond.result = indica si todo se realizo bien o mal
     *         respond.response = html para renderizar los destinos de las ofertas
     */
    public function actionAgregaDestinoOferta() {
        $modelDestinoOferta = new OfertasLaboralesDestino();


        if ($modelDestinoOferta->load(Yii::$app->request->post())) {

            $model = $this->findModel($modelDestinoOferta->idOfertaLaboral);
            $destinoOfertasLaborales = OfertasLaboralesDestino::listaOfertas($modelDestinoOferta->idOfertaLaboral);

            if ($modelDestinoOferta->save()) {
                $modelDestinoOferta = new OfertasLaboralesDestino;
            }

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('_destinoOfertas', [
                    'model' => $model,
                    'destinoOfertasLaborales' => $destinoOfertasLaborales,
                    'modelDestinoOferta' => $modelDestinoOferta
            ])];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * Finds the OfertasLaborales model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return OfertasLaborales the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = OfertasLaborales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelOfertaDestino($idOferta, $idGrupoInteres, $idCiudad) {
        $model = OfertasLaboralesDestino::find()->where('( codigoCiudad =:idCiudad and idGrupoInteres =:idGrupoInteres and idOfertaLaboral =:idOferta )')
                ->addParams(['idCiudad' => $idCiudad, 'idGrupoInteres' => $idGrupoInteres, 'idOferta' => $idOferta])
                ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
