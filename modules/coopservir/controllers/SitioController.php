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

     // renderiza la pagina de AcercaDe
    public function actionAcercaDe() {
        return $this->render('mision-vision');
    }   
    
    // renderiza la pagina de vision
    public function actionVision() {
        return $this->render('vision');
    }      
    
    //renderiza la pagina de Historia
    public function actionHistoria() {
        return $this->render('historia');
    }
    
     
    //renderiza la pagina de Identidad corporativa
    public function actionIdentidad() {
        return $this->render('identidad');
    }
    
    //renderiza la pagina de compromiso social
    public function actionCompromiso() {
        return $this->render('compromiso');
    }
    
    
     //renderiza la pagina de gestion ambiental
    public function actionGestionAmbiental() {
        return $this->render('gestion-ambiental');
    }
       
    
       //renderiza la pagina de sector coperativo
    public function actionSectorCoperativo() {
        return $this->render('sector-coperativo');
    }
         
    
    
    //renderiza la pagina de contacto
    public function actionContacto() {
        return $this->render('contacto');
    }
    


    //renderiza la pagina de LineaEtica
    public function actionLineaEtica() {
        return $this->render('linea-etica');
    }

    


    //renderiza la pagina de Historia
    public function actionConveniosEmpresariales() {
        $this->layout = 'main_convenios';
        return $this->render('convenios-empresariales');
    }
}
