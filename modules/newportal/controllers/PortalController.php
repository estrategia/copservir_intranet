<?php

namespace app\modules\newportal\controllers;

use Yii;
use app\modules\intranet\models\Portal;
use app\modules\intranet\models\PortalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * PortalController implements the CRUD actions for Portal model.
 */
class PortalController extends Controller
{
    public $logoPortal;
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
     * Lists all Portal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PortalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Portal model.
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
     * Updates an existing Portal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $imagenAntigua = $model->logoPortal;
        if ($model->load(Yii::$app->request->post())) {
            $file = UploadedFile::getInstance($model, 'logoPortal');
            
            if ($file) {
                $rutaImagen = uniqid() . ".$file->extension";
                $folder = Yii::getAlias('@webroot') . '/img/multiportal/' . "{$model->nombrePortal}";
                if (!is_dir($folder)) {
                    mkdir($folder, 0777);         
                }
                $file->saveAs($folder . '/' . $rutaImagen);
                unlink($folder . '/' . $imagenAntigua);
                $model->logoPortal = $rutaImagen;
                $model->save();
            }
            return $this->redirect(['view', 'id' => $model->idPortal]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Finds the Portal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Portal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Portal::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
