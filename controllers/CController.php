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

    public function actionVerTodasNoticias($nombrePortal)
    {
      //$dataProviderNoticias  = Contenido::traerTodasNoticiasPortal($this->module->id);

      $searchModel = new ContenidoSearch();
      $searchModel->load(Yii::$app->request->post());

      $dataProviderNoticias = $searchModel->searchNoticiasPortal(Yii::$app->request->queryParams);

      return $this->render('//common/noticias/todas-noticias', [
        'dataProviderNoticias' => $dataProviderNoticias,
        'searchModel' => $searchModel,
      ]);
    }

    public function actionDetalleNoticia($idNoticia, $nombrePortal)
    {
      $contenidoModel  = Contenido::traerNoticiaPortal($this->module->id, $idNoticia);

      return $this->render('//common/noticias/detalle-noticia', [
        'contenidoModel' => $contenidoModel,
      ]);
    }

}
