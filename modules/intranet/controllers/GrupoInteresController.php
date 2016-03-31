<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\GrupoInteres;
use app\modules\intranet\models\GrupoInteresSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GrupoInteresController implementa las acciones para el modelo GrupoInteres.
 */
class GrupoInteresController extends Controller
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
     * Lista todos los modelos Grupointeres.
     * @return mixed
     */
    public function actionListar()
    {
        $searchModel = new GrupoInteresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Muesrtra un solo modelo Grupointeres.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        $grupo = $this->findModel($id);
        
        return $this->render('detalle', [
            'grupo' => $grupo, 'cargos' => $cargos
        ]);
    }

    /**
     * Crea un nuevo modelo GrupoInteres.
     * Si la creacion es exitosa el navegador redirige a la vista detalle.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new GrupoInteres();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo existente GrupoInteres.
     * si la actualizacion es exitosa el navegador redirige a la vista detalle.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idGrupoInteres]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Borra un modelo existente GrupoInteres.
     * si la elimiancion es existosa el navegador redirige a la vista index (Listar).
     * @param string $id
     * @return mixed
     */
    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['listar']);
    }

    /**
     * Encuentr un modelo GrupoInteres basado en el valor de su llave primaria.
     * @param string $id
     * Si el modelo no es encontrado se arroja una exepcion HTTP 404.
     * @return un modelo GrupoInteres
     * @throws NotFoundHttpException si el modelo no es enconrado
     */
    protected function findModel($id)
    {
        if (($model = GrupoInteres::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
