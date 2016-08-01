<?php

namespace app\modules\copservir;

/**
 * coopservir module definition class
 */
class CopservirModule extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\copservir\controllers';
    public $defaultRoute = 'sitio';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();
        \Yii::$app->errorHandler->errorAction = 'copservir/sitio/error';

        // custom initialization code goes here
    }

}
