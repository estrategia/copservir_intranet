<?php

namespace app\modules\coopservir;

/**
 * coopservir module definition class
 */
class CoopservirModule extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\coopservir\controllers';
    public $defaultRoute = 'sitio';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        \Yii::$app->errorHandler->errorAction = 'coopservir/sitio/error';

        // custom initialization code goes here
    }

}
