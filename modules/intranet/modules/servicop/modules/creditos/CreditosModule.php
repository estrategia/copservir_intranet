<?php

namespace app\modules\intranet\modules\servicop\modules\creditos;

use yii\httpclient\Client;
use yii\helpers\Json;

/**
* 
*/
class CreditosModule extends \yii\base\Module
{

    public $controllerNamespace = 'app\modules\intranet\modules\servicop\modules\creditos\controllers';
    
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function consultarWebService($url, $parametros=[], $metodo='get')
    {
        $client = new Client();
        $response = $client->createRequest()
            ->setMethod($metodo)
            ->setUrl($url)
            ->setData($parametros)
            ->send();
        return Json::decode($response->content);
        // return $response->content;
    }   
}