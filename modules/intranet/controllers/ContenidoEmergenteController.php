<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\ContenidoEmergente;
use app\modules\intranet\models\ContenidoEmergenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ContenidoEmergenteController implements the CRUD actions for ContenidoEmergente model and other actions.
 */
class ContenidoEmergenteController extends Controller
{
    /**
     * @inheritdoc
     */
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
     * Lista todos los modelos ContenidoEmergente.
     * @param none
     * @return mixed
     */
    public function actionListar()
    {
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
    public function actionDetalle($id)
    {
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
    public function actionCrear()
    {
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
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idContenidoEmergente]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Elimina un modelo existente ContenidoEmergente.
     * Si la eliminacion es exitosa redirige a la vista listar.
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['listar']);
    }

    /**
     * Encuenta un modelo ContenidoEmergente basado en su llave primaria
     * Si no encuentra un modelo lanza una excepcion 404 HTTP exception.
     * @param string $id
     * @return modleo ContenidoEmergente
     * @throws NotFoundHttpException si el modelo no es encontrado
     */
    protected function findModel($id)
    {
        if (($model = ContenidoEmergente::findOne($id)) !== null) {
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
            $items = [
                'result' => 'ok',
                'response' => $this->renderAjax('_contenidoemergenteHtml', ['query' => $query]),
            ];
        } else {
            $items = [
                'result' => 'ok',
                'response' => '',
            ];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
    }

    /**
     * inactiva un ContenidoEmergente con esto el usuario no lo vera mas
     * @param idPopup = idContenidoEmergente
     * @return items.result = indica si la operacion se realizo correctamente o no
     */
    public function actionInactivaContenidoEmergente() {

        $idPopup = Yii::$app->request->post('idPopup');
        $modelContenido = ContenidoEmergente::findone(['idContenidoEmergente' => $idPopup]);
        $modelContenido->estado = ContenidoEmergente::ESTADO_INACTIVO;
        $items = [];
        if ($modelContenido->save()) {
          $items = [
              'result' => 'ok',
          ];
        }else{
          $items = [
              'result' => 'error',
          ];
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $items;
    }
}
