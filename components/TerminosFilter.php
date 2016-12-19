<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccessFilter
 *
 * @author Miguel Sanchez
 */

namespace app\components;

use Yii;
use yii\base\ActionFilter;
// use yii\web\Request;

class TerminosFilter extends ActionFilter {

    //public $ajaxRequest = false;

    public function beforeAction($action) {
        if (Yii::$app->user->identity->confirmarDatosPersonales == 0) {
            // $this->redirect('/proveedores/usuario/mi-cuenta');
            // Yii::$app->request->redirect('');
            Yii::$app->getResponse()->redirect(Yii::$app->getUrlManager()->getBaseUrl().'/proveedores/usuario/actualizar-mi-cuenta')->send();
        }
        return parent::beforeAction($action);
    }

}
