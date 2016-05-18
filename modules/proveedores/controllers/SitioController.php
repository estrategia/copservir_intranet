<?php

namespace app\modules\proveedores\controllers;

use app\controllers\CController;
use Yii;
use yii\web\Controller;
use app\modules\intranet\models\Portal;
use app\modules\intranet\models\Contenido;

class SitioController extends CController
{
    public function actionIndex()
    {
        $portalModel = Portal::encontrarModeloPorNombre($this->module->id);
        $contenidoModels  = Contenido::traerNoticiasIndexPortal($portalModel->idPortal);
        $numeroNoticias = Contenido::contarTotalNoticiasPortal($portalModel->idPortal);

        return $this->render('index', [
          'contenidoModels' => $contenidoModels,
          'numeroNoticias' => $numeroNoticias,
        ]);
    }

    
}

?>
