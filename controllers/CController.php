<?php

namespace app\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\modules\intranet\models\Portal;
use app\modules\intranet\models\Contenido;

abstract class CController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionVerTodasNoticias($nombrePortal)
    {

      $portalModel = Portal::encontrarModeloPorNombre($nombrePortal);
      $dataProviderNoticias  = Contenido::traerTodasNoticiasPortal($portalModel->idPortal);

      return $this->render('/common/noticias/todas-noticias', [
        'dataProviderNoticias' => $dataProviderNoticias,
      ]);
    }

    public function actionDetalleNoticia($idNoticia, $nombrePortal)
    {
      $portalModel = Portal::encontrarModeloPorNombre($nombrePortal);
      $contenidoModel  = Contenido::traerNoticiasIndexPortal($portalModel->idPortal, $idNoticia);

      return $this->render('//common/noticias/detalle-noticia', [
        'contenidoModel' => $contenidoModel,
      ]);
    }

    public function actionHola()
    {
      echo $this->module->id;
    }




}
