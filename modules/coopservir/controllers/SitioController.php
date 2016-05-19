<?php

namespace app\modules\coopservir\controllers;

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

    /**
    * renderiza la pagina de contacto
    * @param none
    * @return mixed
     */
    public function actionContacto() {
        return $this->render('contacto');
    }

    /**
    * renderiza la pagina de AcercaDe
    * @param none
    * @return mixed
     */
    public function actionAcercaDe() {
        return $this->render('mision-vision');
    }

    /**
    * renderiza la pagina de LineaEtica
    * @param none
    * @return mixed
     */
    public function actionLineaEtica() {
        return $this->render('linea-etica');
    }

    /**
    * renderiza la pagina de Historia
    * @param none
    * @return mixed
     */
    public function actionHistoria() {
        return $this->render('historia');
    }

    /**
    * renderiza la pagina de Historia
    * @param none
    * @return mixed
     */
    public function actionConveniosEmpresariales() {
        $this->layout = 'main_convenios';
        return $this->render('convenios-empresariales');
    }
}
