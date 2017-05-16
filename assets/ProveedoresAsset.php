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
        // 'libs/boostrapv3/css/bootstrap-theme.min.css',
        'libs/font-awesome/css/font-awesome.css',
        
        // 'libs/webarch/webarch.css',


        // carousel
        'libs/multiportal/owl-carousel/owl.carousel.css',
        'libs/multiportal/owl-carousel/owl.theme.css',

        // visor imagenes
        'libs/bootstrap-media-lightbox-master/bootstrap-media-lightbox.css',

        //genericas plantilla intranet
        'css/portales-style.css',
        'css/portales-main.css',
        'css/portales-main_1.css',
        'css/common.css',
    	'css/portales-common.css',
    ];
    public $js = [
        // boostrap
        'libs/boostrapv3/js/bootstrap.min.js',

        'libs/modernizr/modernizr.js',
        'libs/timeago/jquery.timeago.js',
        'libs/timeago/jquery.timeago.es.js',

        // carousel
        'libs/multiportal/owl-carousel/owl.carousel.min.js',

        // visor imagenes
        'libs/bootstrap-media-lightbox-master/bootstrap-media-lightbox.min.js',

        //genericas plantilla intranet
        'js/multiportal/timeline.js',
        'js/multiportal/vendor/holder.min.js',
        'js/multiportal/main.js',

        //propios
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
