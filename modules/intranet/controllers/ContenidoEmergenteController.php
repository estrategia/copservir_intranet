<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\ContenidoEmergente;
use app\modules\intranet\models\ContenidoEmergenteDestino;
use app\modules\intranet\models\ContenidoEmergenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContenidoEmergenteController implements the CRUD actions for ContenidoEmergente model and other actions.
 */
class ContenidoEmergenteController extends Controller {
    //public $defaultAction = "admin";

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
                'only' => [
                    'admin', 'detalle', 'crear', 'actualizar', 'eliminar',
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
     * Lista todos los modelos ContenidoEmergente.
     * @param none
     * @return mixed
     */
    public function actionAdmin() {
        $searchModel = new ContenidoEmergenteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('listar', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * muestra un solo modelo ContenidoEmergente.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id) {
        return $this->render('detalle', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Crea un nuevo modelo ContenidoEmergente.
     * Si la creacion es exitosa redirige a la vista detalle.
     * @param none
     * @return mixed
     */
    public function actionCrear() {
        $model = new ContenidoEmergente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idContenidoEmergente]);
        } else {
            return $this->render('crear', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo existente ContenidoEmergente.
     * Si la actualizacion es exitosa redirige a la vista detalle.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id) {
        $model = $this->findModel($id);
        $destinoContenidoEmergente = ContenidoEmergenteDestino::listaDestinos($model->idContenidoEmergente);
        $modelDestinoContenidoEmergente = new ContenidoEmergenteDestino;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idContenidoEmergente]);
        } else {
            return $this->render('actualizar', [
                        'model' => $model,
                        'destinoContenidoEmergente' => $destinoContenidoEmergente,
                        'modelDestinoContenidoEmergente' => $modelDestinoContenidoEmergente
            ]);
        }
    }

    /**
     * Elimina un modelo existente ContenidoEmergente.
     * Si la eliminacion es exitosa redirige a la vista listar.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id) {
        $model = $this->findModel($id);
        $model->estado = ContenidoEmergente::ESTADO_INACTIVO;
        if ($model->save()) {
            return $this->redirect(['admin']);
        }
    }

    /**
     * Encuenta un modelo ContenidoEmergente basado en su llave primaria
     * Si no encuentra un modelo lanza una excepcion 404 HTTP exception.
     * @param string $id
     * @return modleo ContenidoEmergente
     * @throws NotFoundHttpException si el modelo no es encontrado
     */
    protected function findModel($id) {
        if (($model = ContenidoEmergente::findOne(['idContenidoEmergente' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Obtiene el html del ContenidoEmergente para renderizarlo en el modal.
     * @param none
     * @return html contenido modal
     */
    public function actionContenidoEmergenteHtml() {

        $db = Yii::$app->db;
        $userCiudad = Yii::$app->user->identity->getCiudadCodigo();
        $userGrupos = Yii::$app->user->identity->getGruposCodigos();
        $userNumeroDocumento = Yii::$app->user->identity->numeroDocumento;

        $query = ContenidoEmergente::getContenidoEmergente($userCiudad, $userGrupos, $userNumeroDocumento);

        if ($query) {
            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('_contenidoemergenteHtml', ['query' => $query]),
            ];
        } else {
            $respond = [
                'result' => 'ok',
                'response' => '',
            ];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * inactiva un ContenidoEmergente con esto el usuario no lo vera mas
     * @param idPopup = idContenidoEmergente
     * @return respond.result = indica si la operacion se realizo correctamente o no
     */
    public function actionInactivaContenidoEmergente() {

        $idPopup = Yii::$app->request->post('idPopup', '');
        $modelContenido = $this->findModel($idPopup);
        $modelContenido->estado = ContenidoEmergente::ESTADO_INACTIVO;
        $respond = [];
        if ($modelContenido->save()) {
            $respond = [
                'result' => 'ok',
            ];
        } else {
            $respond = [
                'result' => 'error',
            ];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * @return mixed
     */
    public function actionEliminarContenidoEmergenteDestino() {

        $idCiudad = Yii::$app->request->post('idCiudad', '');
        $idGrupoInteres = Yii::$app->request->post('idGrupo', '');
        $idContenidoEmergente = Yii::$app->request->post('idContenidoEmergente', '');
        $respond = [
            'result' => 'error',
        ];

        $contenidoEmergenteDestino = $this->findModelContenidoEmergenteDestino($idContenidoEmergente, $idGrupoInteres, $idCiudad);

        if ($contenidoEmergenteDestino->delete()) {

          $model = $this->findModel($idContenidoEmergente);
          $destinoContenidoEmergente = ContenidoEmergenteDestino::listaDestinos($idContenidoEmergente);
          $modelDestinoContenidoEmergente = new ContenidoEmergenteDestino;

            $respond = [
                'result' => 'ok',
                'response' => $this->renderAjax('_destinoContenidoEmergente', [
                    'model' => $model,
                    'destinoContenidoEmergente' => $destinoContenidoEmergente,
                    'modelDestinoContenidoEmergente' => $modelDestinoContenidoEmergente
            ])];
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $respond;
    }

    /**
     * @return respond = []
     *         respond.result = indica si todo se realizo bien o mal
     *         respond.response = html para renderizar los destinos de los Contenidos Emergente
     */
     public function actionAgregaDestinoContenidoEmergente() {
       $modelDestinoContenidoEmergente = new ContenidoEmergenteDestino;
       $model = '';
       $destinoContenidoEmergente = '';

       if ($modelDestinoContenidoEmergente->load(Yii::$app->request->post())) {

         $model = $this->findModel($modelDestinoContenidoEmergente->idContenidoEmergente);
         $destinoContenidoEmergente = ContenidoEmergenteDestino::listaDestinos($model->idContenidoEmergente);


         if ($modelDestinoContenidoEmergente->save()) {
             $modelDestinoContenidoEmergente = new ContenidoEmergenteDestino;
         }
       }

       $respond = [
         'result' => 'ok',
         'response' => $this->renderAjax('_destinoContenidoEmergente', [
           'model' => $model,
           'destinoContenidoEmergente' => $destinoContenidoEmergente,
           'modelDestinoContenidoEmergente' => $modelDestinoContenidoEmergente
       ])];

       Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
       return $respond;
    }

    /**
     * Encuentra un modelo ContenidoEmergenteDestino.
     * @param string $idContenidoEmergente, idGrupoInteres, idCiudad
     * @return ContenidoEmergenteDestino the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelContenidoEmergenteDestino($idContenidoEmergente, $idGrupoInteres, $idCiudad) {
        $model = ContenidoEmergenteDestino::find()->where('( codigoCiudad =:idCiudad and idGrupoInteres =:idGrupoInteres and idContenidoEmergente =:idContenidoEmergente )')
                ->addParams(['idCiudad' => $idCiudad, 'idGrupoInteres' => $idGrupoInteres, 'idContenidoEmergente' => $idContenidoEmergente])
                ->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
