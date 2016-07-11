<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\controllers\ControllerCalendar;
use app\modules\intranet\models\EventosCalendario;
use app\modules\intranet\models\EventosCalendarioDestino;
use app\modules\intranet\models\EventosCalendarioSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\intranet\models\ContenidoSearch;

class CalendarioController extends ControllerCalendar {

  public function behaviors()
  {
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
                   'admin' => 'intranet_calendario_admin',
                   'detalle' => 'intranet_calendario_admin',
                   'crear' => 'intranet_calendario_admin',
                   'actualizar' => 'intranet_calendario_admin',
                   'eliminar' => 'intranet_calendario_admin',
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

  /**
   * Lista todos los modelos EventosCalendario.
   * @return mixed
   */
  public function actionAdmin()
  {
      $searchModel = new EventosCalendarioSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

      return $this->render('admin', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
      ]);
  }

  /**
   * Muestra un solo modelo EventosCalendario.
   * @param string $id
   * @return mixed
   */
  public function actionDetalle($id)
  {
      $model = $this->findModel($id);
      $searchModel = new ContenidoSearch();
      $dataProviderContenido = $searchModel->searchNoticiasPortal(Yii::$app->request->queryParams, $model->objPortal->nombrePortal);

      return $this->render('detalle', [
          'model' => $model,
          'searchModel' => $searchModel,
          'dataProviderContenido' => $dataProviderContenido
      ]);
  }

  /**
   * Crea un nuevo modelo EventosCalendario.
   * @return mixed
   */
  public function actionCrear()
  {
      $model = new EventosCalendario();
      if ($model->load(Yii::$app->request->post())) {
          $destinos = Yii::$app->request->post('EventosCalendarioDestino');
          $transaction = EventosCalendario::getDb()->beginTransaction();
          try {
              if ($model->save()) {
                if (!empty($destinos['codigoCiudad']) && !empty($destinos['idGrupoInteres']) && $model->idPortal == 1) { // 1 es el numero de intranet
                  $this->guardarEventoDestino($destinos, $model->idEventoCalendario);
                }

                $transaction->commit();
                return $this->redirect(['detalle', 'id' => $model->idEventoCalendario]);
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
   * Crea varios modelos EventosCalendarioDestino
   * @param array $destinos, int $idEventoCalendario
   * @throws Exception si uno de los modelos no se puede crear
   * @return mixed
   */
  protected function guardarEventoDestino($destinos, $idEventoCalendario)
  {
    $ciudades = $destinos['codigoCiudad'];
    $gruposInteres = $destinos['idGrupoInteres'];

    for ($i = 0; $i < count($gruposInteres); $i++) {
        $eventoDestino = new EventosCalendarioDestino();
        $eventoDestino->idGrupoInteres = $gruposInteres[$i];
        $eventoDestino->codigoCiudad = $ciudades[$i];
        $eventoDestino->idEventoCalendario = $idEventoCalendario;

        if (!$eventoDestino->save()) {
            throw new \Exception("Error al guardar el destino:" . json_encode($eventoDestino->getErrors()), 102);
        }
    }
  }


  /**
   * Actualiza un modelo EventosCalendario existente.
   * @param string $id
   * @return mixed
   */
  public function actionActualizar($id)
  {
      $model = $this->findModel($id);
      $destinoEventosCalendario = EventosCalendarioDestino::listaOfertas($id);
      $modelDestinoEventos = new EventosCalendarioDestino;

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['detalle', 'id' => $model->idEventoCalendario]);
      } else {
          return $this->render('actualizar', [
              'model' => $model,
              'destinoEventosCalendario' => $destinoEventosCalendario,
              'modelDestinoEventos' => $modelDestinoEventos
          ]);
      }
  }

  /**
   * Elimina un modelo EventosCalendario existente.
   * @param string $id
   * @return mixed
   */
  public function actionEliminar($id)
  {
      $model = $this->findModel($id);
      $model->estado = EventosCalendario::INACTIVO;
      if ($model->save()) {
          return $this->redirect(['admin']);
      }
  }

  /**
   * Elimina un modelo EventosCalendarioDestino existente.
   * @return mixed
   */
   public function actionEliminarEventoDestino() {

    $idCiudad = Yii::$app->request->post('idCiudad','');
    $idGrupoInteres = Yii::$app->request->post('idGrupo','');
    $idEvento = Yii::$app->request->post('idEvento','');
    $respond = [
      'result' => 'error',
    ];

    $eventoDestino = $this->findModelEventoDestino($idEvento, $idGrupoInteres, $idCiudad); // crear metodo

    if ($eventoDestino->delete()) {

      $model = $this->findModel($idEvento);
      $destinoEventosCalendario = EventosCalendarioDestino::listaOfertas($idEvento);
      $modelDestinoEventos = new EventosCalendarioDestino;

      $respond = [
        'result' => 'ok',
        'response' => $this->renderAjax('_destinoEventos', [
          'model' => $model,
          'destinoEventosCalendario' => $destinoEventosCalendario,
          'modelDestinoEventos' => $modelDestinoEventos
      ])];

    }
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    return $respond;
  }

  /**
   * Ecuentra un modelo EventosCalendarioDestino basado en su idEventoCalendario, idGrupoInteres e idCiudad.
   * @param string idEventoCalendario, string idGrupoInteres, string idCiudad
   * @return modelo EventosCalendarioDestino
   * @throws NotFoundHttpException si no encuentra el modelo
   */
  protected function findModelEventoDestino($idEvento, $idGrupoInteres, $idCiudad)
  {
    $model = EventosCalendarioDestino::find()->where('( codigoCiudad =:idCiudad and idGrupoInteres =:idGrupoInteres and idEventoCalendario =:idEventoCalendario )')
    ->addParams(['idCiudad'=>$idCiudad,'idGrupoInteres'=>$idGrupoInteres, 'idEventoCalendario'=>$idEvento])
    ->one();

    if ($model  !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

/**
* crea un modelo EventosCalendarioDestino
* @return respond = []
*         respond.result = indica si todo se realizo bien o mal
*         respond.response = html para renderizar los destinos
*/
public function actionAgregaDestinoEvento()
{
  $modelDestinoEvento = new EventosCalendarioDestino();


  if ($modelDestinoEvento->load(Yii::$app->request->post())) {

    $model = $this->findModel($modelDestinoEvento->idEventoCalendario);
    $destinoEventosCalendario = EventosCalendarioDestino::listaOfertas($modelDestinoEvento->idEventoCalendario);

    if ($modelDestinoEvento->save()) {
        $modelDestinoEvento = new EventosCalendarioDestino;
    }

    $respond = [
      'result' => 'ok',
      'response' => $this->renderAjax('_destinoEventos', [
        'model' => $model,
        'destinoEventosCalendario' => $destinoEventosCalendario,
        'modelDestinoEventos' => $modelDestinoEvento
    ])];

  }

  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
  return $respond;
}

/**
 * asigna un contenido a un modelo EventosCalendario existente
 * @param string $id = id del contenido, string idEvento
 * @return respond = []
 *         respond.result = indica si todo se realizo bien o mal
 *         respond.response = html GridView con lista de contenidos
 */
public function actionAsignarContenidoEvento($id, $idEvento)
{
  if (Yii::$app->request->isAjax) {

    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

    $model = $this->findModel($idEvento);
    $model->idContenido = $id;
    if ($model->save()) {

      $searchModel = new ContenidoSearch();
      $dataProviderContenido = $searchModel->searchNoticiasPortal(Yii::$app->request->queryParams, $model->objPortal->nombrePortal);

      return [
        'result' => 'ok',
        'response' => $this->renderAjax('_listaContenidos', [
        'modelo'=> $model,
        'searchModel' => $searchModel,
        'dataProviderContenido' => $dataProviderContenido
      ])];
    }else{
      return [
        'result' => 'error',
        'response' => 'error al asignar el contenido'
      ];
    }


  }
}

  /**
   * Ecuentra un modelo EventosCalendario basado en su llave pimaria .
   * @param string $id
   * @return MenuPortales the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id)
  {
      if (($model = EventosCalendario::findOne(['idEventoCalendario' => $id])) !== null) {
          return $model;
      } else {
          throw new NotFoundHttpException('The requested page does not exist.');
      }
  }

}
