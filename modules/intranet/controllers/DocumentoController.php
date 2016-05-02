<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\Documento;
use app\modules\intranet\models\DocumentoSearch;
use app\modules\intranet\models\LogDocumento;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * DocumentoController implements the CRUD actions for Documento model and other actions.
 */
class DocumentoController extends Controller
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
     * Lista todos los modelos Documento.
     * @return mixed
     */
    public function actionListar()
    {
        $searchModel = new DocumentoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('listar', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muestra un solo modelo Documento.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        $model = $this->findModel($id);

        $logDocumento = LogDocumento::find()
        ->where("( idDocumento =:id )")
        ->addParams([':id'=> $id])->all();


        return $this->render('detalle', [
            'model' => $model,
            'logDocumento'=> $logDocumento
        ]);
    }

    /**
     * Crea un nuevo modelo Documento.
     * Si la creacion es exitosa redirige a la vista detalle .
     * @param none
     * @return mixed
     */
    public function actionCrear()
    {

        $model = new Documento();
        $model->scenario = Documento::SCENARIO_CREAR;

        if ($model->load(Yii::$app->request->post())) {
          $model->setRutaDocumento();
          $transaction = Documento::getDb()->beginTransaction();
          try {
              if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['detalle', 'id' => $model->idDocumento]);
              }
          } catch(\Exception $e) {

              $transaction->rollBack();
              Yii::$app->session->setFlash('error', $e->getMessage());
              throw $e;
          }
        } else {
            // error no cargo modelo
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo existente Documento.
     * Si la actualizacion es exitosa el navegagor redirige al detalle.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {

        $model = $this->findModel($id);
        $model->scenario = Documento::SCENARIO_ACTUALIZAR;

        if ($model->load(Yii::$app->request->post())) {
          $model->setRutaDocumento();
          try {
              if ($model->save()) {
                $transaction->commit();
                return $this->redirect(['detalle', 'id' => $model->idDocumento]);
              }
          } catch(\Exception $e) {

              $transaction->rollBack();
              Yii::$app->session->setFlash('error', $e->getMessage());
              throw $e;
          }
        } else {
            // error no cargo el modelo
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Elimina un modelo Documento existente.
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
     * Encuentra un modelo Documento basado en su llave primaria.
     * Si el modelo no se encuentra se lanza una excepcion 404 HTTP exception.
     * @param string $id
     * @return modelo Documento
     * @throws NotFoundHttpException si no encuentra el modelo
     */
    protected function findModel($id)
    {
        if (($model = Documento::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
