<?php

namespace app\modules\intranet\modules\formacioncomunicaciones\controllers;

use Yii;
use app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntos;
use app\modules\intranet\modules\formacioncomunicaciones\models\ParametrosPuntosSearch;
use app\modules\intranet\modules\formacioncomunicaciones\models\PuntosSearch;
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
            [
                'class' => \app\components\AccessFilter::className(),
                'redirectUri' => ['/intranet/usuario/autenticar']
            ],

            [
                'class' => \app\components\AuthItemFilter::className(),
                'only' => [
                    'index', 'crear', 'actualizar', 'detalle','parametros', 'puntos'
                ],
                'authsActions' => [
                    'index' => 'formacionComunicaciones_parametros-puntos_admin',
                    'detalle' => 'formacionComunicaciones_parametros-puntos_admin',
                    'crear' => 'formacionComunicaciones_parametros-puntos_admin',
                    'actualizar' => 'formacionComunicaciones_parametros-puntos_admin',
                    'detalle' => 'formacionComunicaciones_parametros-puntos_admin',
                    'parametros' => 'formacionComunicaciones_parametros-puntos_admin',
                    'puntos' => 'formacionComunicaciones_parametros-puntos_admin'
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
        return $this->render('index');
    }

    public function actionParametros()
    {
        $searchModel = new ParametrosPuntosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        return $this->render('parametros', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tiposContenidos' => $tiposContenido
        ]);
    }

    public function actionPuntos()
    {
        $searchModelPuntos = new PuntosSearch();
        $dataProviderPuntos = $searchModelPuntos->search(Yii::$app->request->queryParams);
        
        return $this->render('puntos', [
            'searchModelPuntos' => $searchModelPuntos,
            'dataProviderPuntos' => $dataProviderPuntos,
        ]);
    }

    /**
     * Displays a single ParametrosPuntos model.
     * @param integer $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ParametrosPuntos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new ParametrosPuntos();
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idParametroPunto]);
        } else {
            return $this->render('crear', [
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
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);
        $tiposContenido = ArrayHelper::Map(TipoContenido::find()->where(['estadoTipoContenido' => 1])->asArray()->all(), 'idTipoContenido', 'nombreTipoContenido');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->idParametroPunto]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
                'tiposContenido' => $tiposContenido
            ]);
        }
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
