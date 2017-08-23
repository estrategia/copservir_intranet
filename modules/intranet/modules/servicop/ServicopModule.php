<?php

namespace app\modules\intranet\modules\servicop;

use yii\httpclient\Client;
use yii\helpers\Json;

/**
 * sascop module definition class
 */
class ServicopModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\intranet\modules\servicop\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    // public function consultarWebService($url, $parametros=[], $metodo='get')
    // {
    //     $client = new Client();
    //     $response = $client->createRequest()
    //         ->setMethod($metodo)
    //         ->setUrl($url)
    //         ->setData($parametros)
    //         ->send();
    //     return Json::decode($response->content);
    //     // return $response->content;
    // }   
}
