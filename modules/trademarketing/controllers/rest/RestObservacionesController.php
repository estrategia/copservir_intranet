<?php

namespace app\modules\trademarketing\controllers\rest;

use app\modules\trademarketing\models\Observaciones;
use app\modules\trademarketing\models\ObservacionesSearch;
use yii\rest\ActiveController;

/**
* Controlador para api REST del modelo Observaciones
*/
class RestObservacionesController extends ActiveController
{

    public $modelClass = 'app\modules\trademarketing\models\Observaciones';

    public function actions()
    {
        $actions = parent::actions();

        // Personaliza el dataProvider que va a usar la accion
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    // uso del dataProvider personalizado
    public function prepareDataProvider()
    {
        $searchModel = new ObservacionesSearch();
        return $searchModel->search(\Yii::$app->request->queryParams);
    }

    public function actionListarObservaciones()
    {
        $idAsignacion = $_GET['idAsignacion'];
        $idVariable = $_GET['idVariable'];
        // $idAsignacion = 1;
        // $idVariable = 1;
        $model = new Observaciones();
        $observaciones = $model->find()
            ->where(['idAsignacion' => $idAsignacion])
            ->andWhere(['idVariable' => $idVariable])
            ->all();
        return $observaciones;
    }
}
