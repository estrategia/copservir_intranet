<?php

namespace app\modules\tarjetamas\controllers;

use app\controllers\CController;
use Yii;


class SitioController extends CController
{
    public function actionInformacion(){
        return $this->render('informacion');
    }

    public function actionPreguntas(){
        return $this->render('preguntas');
    }

    public function actionTerminos(){
        return $this->render('terminos');
    }

    public function actionPoliticas(){
        return $this->render('politicas');
    }

     public function actionAtencion(){
        return $this->render('atencion');
    }
}

?>
