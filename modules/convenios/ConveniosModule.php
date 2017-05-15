<?php

namespace app\modules\convenios;

/**
 * convenio module definition class
 */
class ConveniosModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\convenios\controllers';
    public $defaultRoute = 'sitio';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::$app->errorHandler->errorAction = 'convenios/sitio/error';

        // custom initialization code goes here
    }
}
