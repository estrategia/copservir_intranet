<?php

namespace app\modules\newportal;

use Yii;
use yii\base\BootstrapInterface;
use yii\web\ForbiddenHttpException;
/**
 * newportal module definition class
 */
class NewPortalModule extends \yii\base\Module implements BootstrapInterface
{
    public $layout = '@app/modules/intranet/views/layouts/main';
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\newportal\controllers';

    public $allowedIPs = ['127.0.0.1', '::1'];

    public $generators = ['portal' => 'app\modules\newportal\generators\portal\Generator'];

    public $newFileMode = 0666;

    public $newDirMode = 0777;

    public function bootstrap($app)
    {
        if ($app instanceof \yii\web\Application) {
            $app->getUrlManager()->addRules([
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id, 'route' => $this->id . '/default/index'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<id:\w+>', 'route' => $this->id . '/default/view'],
                ['class' => 'yii\web\UrlRule', 'pattern' => $this->id . '/<controller:[\w\-]+>/<action:[\w\-]+>', 'route' => $this->id . '/<controller>/<action>'],
            ], false);
        } elseif ($app instanceof \yii\console\Application) {
            $app->controllerMap[$this->id] = [
                'class' => 'yii\gii\console\GenerateController',
                'generators' => array_merge($this->coreGenerators(), $this->generators),
                'module' => $this,
            ];
        }
    }

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        // if (Yii::$app instanceof \yii\web\Application && !$this->checkAccess()) {
        //     throw new ForbiddenHttpException('You are not allowed to access this page.');
        // }

        foreach ($this->generators as $id => $config) {
            if (is_object($config)) {
                $this->generators[$id] = $config;
            } else {
                $this->generators[$id] = Yii::createObject($config);
            }
        }

        $this->resetGlobalSettings();

        return true;
    }

    protected function resetGlobalSettings()
    {
        if (Yii::$app instanceof \yii\web\Application) {
            Yii::$app->assetManager->bundles = [];
        }
    }

    // /**
    //  * @return boolean whether the module can be accessed by the current user
    //  */
    // protected function checkAccess()
    // {
    //     $ip = Yii::$app->getRequest()->getUserIP();
    //     foreach ($this->allowedIPs as $filter) {
    //         if ($filter === '*' || $filter === $ip || (($pos = strpos($filter, '*')) !== false && !strncmp($ip, $filter, $pos))) {
    //             return true;
    //         }
    //     }
    //     Yii::warning('Access to Gii is denied due to IP address restriction. The requested IP is ' . $ip, __METHOD__);

    //     return false;
    // }
}
