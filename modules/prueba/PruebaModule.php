<?php

namespace app\modules\prueba;

/**
 * prueba module definition class
 */
class PruebaModule extends \yii\base\Module
{
    public $layout = '@app/modules/prueba/views/layouts/main';
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\prueba\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
