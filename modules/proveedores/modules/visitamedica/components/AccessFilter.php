<?php 

namespace app\modules\proveedores\modules\visitamedica\components;

use Yii;
use yii\base\ActionFilter;
use yii\web\Session;
use yii\helpers\Url;


class AccessFilter extends ActionFilter {


    public function beforeAction($action) {
        
        $ciudad = \Yii::$app->session->get(\Yii::$app->params['visitamedica']['session']['ubicacion']['ciudad']);
        $url = Yii::$app->getUrlManager()->getBaseUrl() . '/proveedores/visitamedica/ubicacion';
        if(is_null($ciudad)){
            Yii::$app->getResponse()->redirect($url)->send();
        }

        return parent::beforeAction($action);
    }

}
?>