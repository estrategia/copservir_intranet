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

class IntranetAdminFilter extends ActionFilter {
    public function beforeAction($action) {
        if (!Yii::$app->user->identity->tienePermiso('intranet_admin')) {
            if (Yii::$app->request->isAjax) {
                echo \yii\helpers\Json::encode([
                    'result' => 'error',
                    'response' => "Acceso no permitido"
                ]);
                exit();
            } else {
                throw new \yii\web\ForbiddenHttpException('Acceso no permitdo.',403);
                exit();
            }
        }

        return parent::beforeAction($action);
    }

}
