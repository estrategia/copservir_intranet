<?php

namespace app\modules\tarjetamas;
use Yii;

/**
 * tarjetamas module definition class
 */
class TarjetaMasModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\tarjetamas\controllers';
    public $defaultRoute = 'sitio';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        Yii::$app->errorHandler->errorAction = 'tarjetamas/sitio/error';

        // custom initialization code goes here
    }
}
