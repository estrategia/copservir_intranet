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

class AccessFilter extends ActionFilter {

    //public $ajaxRequest = false;
    public $redirectUri = null;

    public function beforeAction($action) {
        if (empty($this->redirectUri)) {
            $this->redirectUri = Yii::$app->getUser()->loginUrl;
        }
        
        //$this->redirectUri = \yii\helpers\Url::to($this->redirectUri);

        if (Yii::$app->getUser()->isGuest && Yii::$app->getRequest()->url !== \yii\helpers\Url::to($this->redirectUri)) {
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'result' => 'error',
                    'response' => "Requiere autenticacion"
                ];
            } else {
                Yii::$app->getResponse()->redirect($this->redirectUri)->send();
                exit(0);
            }
        }

        return parent::beforeAction($action);
    }

}
