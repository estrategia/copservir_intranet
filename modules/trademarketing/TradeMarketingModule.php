<?php

namespace app\modules\trademarketing;

/**
 * convenio module definition class
 */
class TradeMarketingModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\trademarketing\controllers';
    public $defaultRoute = 'sitio';
    public $layout = 'main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        \Yii::$app->errorHandler->errorAction = 'trademarketing/sitio/error';

        // custom initialization code goes here
    }
}
