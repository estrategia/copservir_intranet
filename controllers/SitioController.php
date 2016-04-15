<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Html;

class SitioController extends Controller {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
    * renderiza la pagina principal de la app multiportal
    * @param none
    * @return mixed
     */
    public function actionIndex() {
        return $this->render('index');
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
