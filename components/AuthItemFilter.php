<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IntranetAdminFilter
 *
 * @author Miguel Sanchez
 */

namespace app\components;

use Yii;
use yii\base\ActionFilter;

class AuthItemFilter extends ActionFilter {

    public $authsActions = [];

    public function beforeAction($action) {
        $actualAction = Yii::$app->controller->action->id;
        $auth = isset($this->authsActions[$actualAction]) ? $this->authsActions[$actualAction] : Yii::$app->controller->module->id . "_" . Yii::$app->controller->id . "_" . $actualAction;
        
        if (!Yii::$app->user->identity->tienePermiso($auth)) {
            if (Yii::$app->request->isAjax) {
                echo \yii\helpers\Json::encode([
                    'result' => 'error',
                    'response' => "Acceso no permitido"
                ]);
                \Yii::$app->end();
            } else {
                throw new \yii\web\ForbiddenHttpException('Acceso no permitdo.', 403);
            }
        }

        return parent::beforeAction($action);
    }

}
