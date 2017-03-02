<?php

namespace app\modules\intranet;
use Yii;

class IntranetModule extends \yii\base\Module {

    public $controllerNamespace = 'app\modules\intranet\controllers';
    public $defaultRoute = 'sitio';
    public $layout = 'main';

    public function init() {
        parent::init();

        Yii::$app->errorHandler->errorAction = 'intranet/sitio/error';
    }

}