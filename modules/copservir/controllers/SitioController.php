<?php

namespace app\modules\copservir\controllers;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use app\modules\intranet\models\Portal;
use app\modules\intranet\models\Contenido;
use app\controllers\CController;

class SitioController extends CController {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionAcercaDe() {
        return $this->render('mision-vision');
    }

    public function actionVision() {
        return $this->render('vision');
    }

    public function actionHistoria() {
        return $this->render('historia');
    }


    public function actionIdentidad() {
        return $this->render('identidad');
    }

    public function actionCompromiso() {
        return $this->render('compromiso');
    }

    public function actionGestionAmbiental() {
        return $this->render('gestion-ambiental');
    }

    public function actionSectorCoperativo() {
        return $this->render('sector-coperativo');
    }

    public function actionContacto() {
        return $this->render('contacto');
    }

    public function actionLineaEtica() {
        return $this->render('linea-etica');
    }

    public function actionConveniosEmpresariales() {
        $this->layout = 'main_convenios';
        return $this->render('convenios-empresariales');
    }
}
