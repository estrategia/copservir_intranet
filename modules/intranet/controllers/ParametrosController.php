<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\Parametros;
use app\modules\intranet\models\ParametrosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ParametrosController extends Controller
{

    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            /*
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                     'admin', 'actualizar'
                 ],
                 'authsActions' => [
                   'admin' => '',
                   'actualizar' => '',

                 ]
             ],
             */
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

        ];
    }

    /**
     * Lista todos los modelos Parametros.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new ParametrosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Actualiza un modelo Parametros existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

          return $this->redirect(['admin']);

        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Encuentra un modelo Parametros basado en el valor de su llave primaria.
     * @param string $id
     * @return Parametros the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Parametros::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
