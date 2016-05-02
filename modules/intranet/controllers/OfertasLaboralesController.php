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
class OfertasLaboralesController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all OfertasLaborales models.
     * @return mixed
     */
    public function actionListarOfertas()
    {
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
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo de OfertasLaborales y los registros de su respectivo registro
     * si la creacion es exitosa redirige a la vista listarOfertas
     * @return mixed
     */
    public function actionCrear()
    {

        $model = new OfertasLaborales();

        if ($model->load(Yii::$app->request->post())) {

            $transaction = OfertasLaborales::getDb()->beginTransaction();

            try {

                  if ($model->save()) {

                    $ofertaDestino = Yii::$app->request->post('ContenidoDestino','');
                    $ciudades = $ofertaDestino['codigoCiudad'];
                    $gruposInteres = $ofertaDestino['idGrupoInteres'];

                    $innerTransaction = OfertasLaboralesDestino::getDb()->beginTransaction();

                    try {

                        for ($i = 0; $i < count($gruposInteres); $i++) {

                          $modelOfertasDestino = new OfertasLaboralesDestino();
                          $modelOfertasDestino->idOfertaLaboral = $model->idOfertaLaboral;
                          $modelOfertasDestino->idGrupoInteres = $gruposInteres[$i];
                          $modelOfertasDestino->codigoCiudad = $ciudades[$i];
                          $modelOfertasDestino->save();
                        }
                        $innerTransaction->commit();

                    } catch (Exception $e) {
                        $innerTransaction->rollBack();

                        throw $e;
                    }
                  $transaction->commit();
                  return $this->redirect(['listar-ofertas']);
                }else{
                  //ocurrio un error al guardar
                  return $this->render('crear', [
                      'model' => $model,
                  ]);
                }

            } catch(\Exception $e) {

                $transaction->rollBack();
                throw $e;
            }
        }else {

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
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);
        $destinoOfertasLaborales = OfertasLaboralesDestino::listaOfertas($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['listar-ofertas']);
        }else{
            return $this->render('actualizar', [
                'model' => $model,
                'destinoOfertasLaborales' => $destinoOfertasLaborales
            ]);
        }
    }

    /**
     * Deletes an existing OfertasLaborales model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Borra un registro de GrupoInteresCargo donde este ese cargo
     * si la elimiancion es existosa el navegador redirige a la vista index (Listar).
     * @param string $id
     * @return mixed
     */
    public function actionEliminarOfertaDestino() {

        $idCiudad = Yii::$app->request->post('idCiudad','');
        $idGrupoInteres = Yii::$app->request->post('idGrupo','');
        $idOferta = Yii::$app->request->post('idOferta','');

        $ofertaDestino = OfertasLaboralesDestino::find()->where('( codigoCiudad =:idCiudad and idGrupoInteres =:idGrupoInteres and idOfertaLaboral =:idOferta )')
        ->addParams(['idCiudad'=>$idCiudad,'idGrupoInteres'=>$idGrupoInteres, 'idOferta'=>$idOferta])
        ->one();

        $respond = [
        'result' => 'error',
        ];

        if ($ofertaDestino->delete()) {

          $destinoOfertasLaborales = OfertasLaboralesDestino::listaOfertas($idOferta);

          $respond = [
              'result' => 'ok',
              'response' => $this->renderPartial('_destinoOfertas', [
                'destinoOfertasLaborales' => $destinoOfertasLaborales
              ])
            ];
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * accion para para agregar un destino a una oferta laboral
     * @param none
     * @return respond = []
     *         respond.result = indica si todo se realizo bien o mal
     *         respond.response = html para renderizar los destinos de las ofertas
     */
     public function actionAgregaDestinoOferta()
     {
        $model = new OfertasLaboralesDestino();
        $respond = [
        'result' => 'error',
        ];

        $idOferta = Yii::$app->request->post('ofertaLaboral', '');
        $model->idGrupoInteres = Yii::$app->request->post('grupo', '');
        $model->codigoCiudad = Yii::$app->request->post('ciudad', '');;
        $model->idOfertaLaboral = $idOferta;

        if (!$model->save()) {

          $ofertaDestino = OfertasLaboralesDestino::find()->where('( codigoCiudad =:idCiudad and idGrupoInteres =:idGrupoInteres and idOfertaLaboral =:idOferta )')
          ->addParams(['idCiudad'=>$idCiudad,'idGrupoInteres'=>$idGrupoInteres, 'idOferta'=>$idOferta])
          ->one();

          if (empty($ofertaDestino)) {
              $respond = [
                  'result' => 'error',
                  'response' => 'El destino ya no existe'
              ];
          } else {
              $respond = [
                  'result' => 'error',
                  'response' => 'Error al guardar el destino'
              ];
          }

        }else{
          $destinoOfertasLaborales = OfertasLaboralesDestino::listaOfertas($idOferta);
          $respond = [
              'result' => 'ok',
              'response' => $this->renderPartial('_destinoOfertas', [
                'destinoOfertasLaborales' => $destinoOfertasLaborales
              ])
          ];
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
    protected function findModel($id)
    {
        if (($model = OfertasLaborales::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
