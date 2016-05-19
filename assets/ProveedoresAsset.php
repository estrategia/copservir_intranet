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
class ProveedoresAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/boostrapv3/css/bootstrap.min.css',
        'libs/boostrapv3/css/bootstrap-theme.min.css',

        // carousel
        'libs/multiportal/owl-carousel/owl.carousel.css',
        'libs/multiportal/owl-carousel/owl.theme.css',

        //genericas plantilla intranet
        'css/multiportal/style.css',
        'css/multiportal/main.css'

    ];
    public $js = [
        // boostrap
        'libs/boostrapv3/js/bootstrap.min.js',

        //genericas plantilla intranet
        'js/multiportal/timeline.js',
        'js/multiportal/vendor/holder.min.js',
        'js/multiportal/main.js',

        'libs/modernizr/modernizr.js',
        'libs/timeago/jquery.timeago.js',
        'libs/timeago/jquery.timeago.es.js',

        // carousel
        'libs/multiportal/owl-carousel/owl.carousel.min.js',

        //propios
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
