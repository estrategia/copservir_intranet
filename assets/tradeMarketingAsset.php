<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class tradeMarketingAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/boostrapv3/css/bootstrap.min.css',
        'libs/boostrapv3/css/bootstrap-theme.min.css',

        //genericas plantilla intranet
        'css/portales-style_1.css',
        'css/portales-main_1.css',
        'css/common.css',
    ];
    public $js = [
        // boostrap
        'libs/boostrapv3/js/bootstrap.min.js',

        //propios
        'js/tradeMarketing/vistas/calificacionAsignacionView.js',
        'js/tradeMarketing/vistas/reporteAsignacionView.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
