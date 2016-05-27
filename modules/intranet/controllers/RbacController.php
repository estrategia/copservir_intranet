<?php

namespace app\modules\intranet\controllers;

use Yii;
use app\modules\intranet\models\AuthItem;
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // por si se quiere tener un lugar donde crear los permisos y roles por defecto
    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // SE DEFINEN LOS PERMISOS
        $crear = $auth->createPermission('crear');
        //$crear->description = 'Crear';
        $auth->add($crear);

        $actualizar = $auth->createPermission('actualizar');
        //$actualizar->description = 'Actualizar';
        $auth->add($actualizar);

        $visualizar = $auth->createPermission('visualizar');
        //$visualizar->description = 'Visualizar';
        $auth->add($visualizar);

        $eliminar = $auth->createPermission('eliminar');
        //$eliminar->description = 'Eliminar';
        $auth->add($eliminar);

        // SE DEFINEN LOS ROLES Y SE RELACIONAN CON LOS PERMISOS
        $usuario = $auth->createRole('usuario');
        $auth->add($usuario);
        $auth->addChild($usuario, $visualizar);
        $auth->addChild($usuario, $crear);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $actualizar);
        $auth->addChild($admin, $eliminar);
        $auth->addChild($admin, $usuario);


        //ASIGNACION DE LOS ROLES A LOS USUARIOS
        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        $auth->assign($usuario, 1234567);
        $auth->assign($admin, 1234567);
        $auth->assign($admin, 123456);
    }

    // CRUD PERMISOS

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
     /*
    public function actionIndex()
    {
        $auth = Yii::$app->authManager;
        $dataProvider = new ActiveDataProvider([
            'query' => AuthItem::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }*/

    /**
     * Displays a single AuthItem model.
     * @param string $id
     * @return mixed
     */
    /*
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    */
    /**
     * Creates a new AuthItem model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
     /*
    public function actionCreate()
    {
        $model = new AuthItem();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    */
    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
     /*
    public function actionUpdate($id)
    {

      if (Yii::$app->authManager->checkAccess(Yii::$app->user->identity->numeroDocumento, 'actualizar')) {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
      }else{
        throw new ForbiddenHttpException('no tienes permiso para acceder');

      }
    }
    */
    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
     /*
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    */
    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
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
}
