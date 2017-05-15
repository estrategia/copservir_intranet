<?php

namespace app\modules\trademarketing\controllers;

use Yii;
use app\modules\trademarketing\models\Espacio;
use app\modules\trademarketing\models\EspacioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class EspacioController extends Controller
{
	public $defaultAction = "admin";
	
    public function behaviors()
    {
        return [

            [
                'class' => \app\components\AccessFilter::className(),
            ],
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                   'admin', 'detalle', 'crear', 'actualizar', 'inactivar'
                 ],
                 'authsActions' => [
                     //colocar los permisos
                      'admin' => 'tradeMarketing_espacios_admin',
                      'detalle' => 'tradeMarketing_espacios_admin',
                      'crear' => 'tradeMarketing_espacios_admin',
                      'actualizar' => 'tradeMarketing_espacios_admin',
                      'inactivar' => 'tradeMarketing_espacios_admin'
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
     * Lista todos los modelos Espacio.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new EspacioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Vizualiza un solo modelo Espacio.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        return $this->render('detalle', [
            'model' => $this->encontrarModeloEspacio($id),
        ]);
    }

    /**
     * Crea un nuevo modelo Espacio.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new Espacio();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idEspacio]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo Espacio existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->encontrarModeloEspacio($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->idEspacio]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Inactiva un modelo Espacio existente.
     * @param string $id
     * @return mixed
     */
    public function actionInactivar($id)
    {
        $model = $this->encontrarModeloEspacio($id);
        $model->estado = Espacio::ESTADO_INACTIVO;

        if (!$model->save()) {
            Yii::$app->session->setFlash('error', json_encode($model->getErrors()));
        }

        return $this->redirect(['admin']);
    }

    /**
     * Encuentra un modelo Espacio basado en el valor de su llave primaria.
     * @param string $id
     * @return modelo Espacio cargado
     * @throws NotFoundHttpException si no encuentra el modelo.
     */
    protected function encontrarModeloEspacio($id)
    {
        if (($model = Espacio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('El recurso no existe.');
        }
    }
}
