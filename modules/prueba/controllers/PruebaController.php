<?php 

namespace app\modules\prueba\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

use app\models\Descuento;

class PruebaController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}

?>