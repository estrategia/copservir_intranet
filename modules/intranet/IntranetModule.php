<?php

namespace app\modules\intranet;
use Yii;

class IntranetModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\intranet\controllers';

    public function init()
    {
        parent::init();
        /*
        Yii::$app->setComponents([
          'errorHandler' => [
              'class'=> 'yii\web\ErrorHandler',
              'errorAction' => 'intranet/site/error',
          ],
        ]);*/

        Yii::$app->errorHandler->errorAction = 'intranet/site/error';


        // custom initialization code goes here
    }
}
