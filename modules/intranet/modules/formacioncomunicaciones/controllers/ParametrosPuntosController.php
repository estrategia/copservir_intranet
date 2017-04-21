<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos;
use app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\TipoContenido;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ParametrosPuntosController implements the CRUD actions for ParametrosPuntos model.
 */
class ParametrosPuntosController extends Controller
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
     * Lists all ParametrosPuntos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ParametrosPuntosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ParametrosPuntos model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ParametrosPuntos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ParametrosPuntos();
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idParametroPunto]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'tiposContenido' => $tiposContenido
            ]);
        }
    }

    /**
     * Updates an existing ParametrosPuntos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idParametroPunto]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tiposContenido' => $tiposContenido
            ]);
        }
    }

    /**
     * Deletes an existing ParametrosPuntos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ParametrosPuntos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ParametrosPuntos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ParametrosPuntos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
