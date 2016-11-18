<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\AuthItem;
use app\modules\intranet\models\AuthItemSearch;
use app\modules\intranet\models\AuthItemChildSearch;
use app\modules\intranet\models\AuthItemChild;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class RbacController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => \app\components\AccessFilter::className(),
            ],
            [
                 'class' => \app\components\AuthItemFilter::className(),
                 'only' => [
                     'admin', 'detalle', 'crear', 'actualizar', 'quitar-permiso'
                 ],
                 'authsActions' => [
                     'admin' => 'intranet_rbac_admin',
                     'detalle' => 'intranet_rbac_admin',
                     'crear' => 'intranet_rbac_admin',
                     'actualizar' => 'intranet_rbac_admin',
                     'quitar-permiso' => 'intranet_rbac_admin',
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

    // CRUD ROLES

    /**
     * Lista todos los modelos AuthItem.
     * @return mixed
     */

    public function actionAdmin()
    {
        $searchModel = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Muestra un solo modelo AuthItem.
     * @param string $id
     * @return mixed
     */
    public function actionDetalle($id)
    {
        $searchModel = new AuthItemChildSearch;
        $authItemChild = new AuthItemChild;
        $dataProviderPermisos = $searchModel->searchPermisos(Yii::$app->request->queryParams);

        if ($authItemChild->load(Yii::$app->request->post()) && $authItemChild->save()){

          $authItemChild = new AuthItemChild;
          return $this->renderAjax('detalle', [
              'model' => $this->findModel($id),
              'searchModel' => $searchModel,
              'dataProviderPermisos' => $dataProviderPermisos,
              'authItemChild' => $authItemChild
          ]);

        }

          return $this->render('detalle', [
              'model' => $this->findModel($id),
              'searchModel' => $searchModel,
              'dataProviderPermisos' => $dataProviderPermisos,
              'authItemChild' => $authItemChild
          ]);

    }

    /**
     * Crea un nuevo modelo AuthItem.
     * @return mixed
     */
    public function actionCrear()
    {
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->name]);
        } else {
            return $this->render('crear', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Actualiza un modelo AuthItem existente.
     * @param string $id
     * @return mixed
     */
    public function actionActualizar($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['detalle', 'id' => $model->name]);
        } else {
            return $this->render('actualizar', [
                'model' => $model,
            ]);
        }
    }


    public function actionQuitarPermiso($parent, $child)
    {

      $searchModel = new AuthItemChildSearch;
      $authItemChild = $this->findModelAuthItemChil($parent, $child);
      $dataProviderPermisos = $searchModel->searchPermisos(['id' => $parent]);
      $respond = [];

      if ($authItemChild->delete()) {
        $authItemChild = new AuthItemChild;
        Yii::$app->session->setFlash('success', 'permiso eliminado con exito');
      }else{
        Yii::$app->session->setFlash('error', 'no se pudo eliminar el permiso');
      }

      $respond = [
          'result' => 'ok',
          'response' =>$this->renderAjax('_listaPermisos', [
              'model' => $this->findModel($parent),
              'searchModel' => $searchModel,
              'dataProviderPermisos' => $dataProviderPermisos,
              'authItemChild' => $authItemChild
          ])
      ];

      Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
      return $respond;

    }


    /**
     * elimina un modelo AuthItem existente.
     * @param string $id
     * @return mixed
     */

    public function actionEliminar($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['admin']);
    }

    /**
     * Encuentra un modelo AuthItem basado en su llave primaria.
     * @param string $id
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelAuthItemChil($parent, $child)
    {
        if (($model = AuthItemChild::findOne(['parent' => $parent, 'child' => $child])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
