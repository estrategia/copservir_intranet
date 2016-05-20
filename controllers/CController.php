<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\modules\intranet\models\Portal;
use app\modules\intranet\models\Contenido;
use app\modules\intranet\models\ContenidoSearch;

abstract class CController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $flagVerMas = false;
        $contenidoModels  = Contenido::traerNoticiasIndexPortal($this->module->id, $flagVerMas);

        return $this->render('index', [
          'contenidoModels' => $contenidoModels,
          'flagVerMas' => $flagVerMas,
        ]);
    }

    public function actionVerTodasNoticias()
    {
      $searchModel = new ContenidoSearch();
      $searchModel->load(Yii::$app->request->post());

      $dataProviderNoticias = $searchModel->searchNoticiasPortal(Yii::$app->request->queryParams, $this->module->id);

      return $this->render('//common/noticias/todas-noticias', [
        'dataProviderNoticias' => $dataProviderNoticias,
        'searchModel' => $searchModel,
      ]);
    }

    public function actionDetalleNoticia($idNoticia)
    {
      $contenidoModel  = Contenido::traerNoticiaPortal($this->module->id, $idNoticia);
      
      if($contenidoModel===null){
          throw new \yii\web\HttpException(404, 'Contenido no existente');
      }

      return $this->render('//common/noticias/detalle-noticia', [
        'contenidoModel' => $contenidoModel,
      ]);
    }

}
