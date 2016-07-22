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
class IntranetAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/boostrapv3/css/bootstrap.min.css',
        'libs/boostrapv3/css/bootstrap-theme.min.css',
        'libs/jquery-bootstrap-scrolling-tabs/jquery.scrolling-tabs.min.css',
        // calendario intranet
        //'libs/fullcalendar/fullcalendar.css',
        //slider tareas intranet
        'libs/boostrap-slider/css/slider.css',
        // carousel
        'libs/multiportal/owl-carousel/owl.carousel.css',
        'libs/multiportal/owl-carousel/owl.theme.css',
        //genericas plantilla intranet
        'libs/pace/pace-theme-flash.css',
        'libs/animate/animate.min.css',
        'libs/font-awesome/css/font-awesome.css',
        'libs/jquery-scrollbar/jquery.scrollbar.css',
        'libs/jquery-nestable/jquery.nestable.min.css',
        'libs/webarch/webarch.css',
        'libs/bootstrap-media-lightbox-master/bootstrap-media-lightbox.css',
        'css/intranet.css',
        'css/common.css'
    ];
    public $js = [
        // boostrap
        'libs/boostrapv3/js/bootstrap.min.js',
        'libs/jquery-bootstrap-scrolling-tabs/jquery.scrolling-tabs.min.js',

        //genericas plantilla intranet
        'libs/pace/pace.min.js',
        'libs/jquery-scrollbar/jquery.scrollbar.min.js',
        'libs/jquery-numberAnimate/jquery.animateNumbers.js',
        'libs/jquery-validation/js/jquery.validate.min.js',
        'libs/jquery-nestable/jquery.nestable.min.js',
        'libs/webarch/webarch.js',
        'libs/jquery-block-ui/jqueryblockui.min.js',
        'libs/jquery-unveil/jquery.unveil.min.js',
        'libs/jquery-ui/jquery-ui-1.10.1.custom.min.js',
        'libs/jquery-ui-touch/jquery.ui.touch-punch.min.js',
        //slider tareas intranet
        'libs/boostrap-slider/js/bootstrap-slider.js',
        'libs/bootstrap-media-lightbox-master/bootstrap-media-lightbox.min.js',
        'libs/modernizr/modernizr.js',
        // 'js/dashboard/dashboard.js',
        'libs/timeago/jquery.timeago.js',
        'libs/timeago/jquery.timeago.es.js',
        // carousel
        'libs/multiportal/owl-carousel/owl.carousel.min.js',

        
        //propios
        //'libs/fullcalendar/fullcalendar.js',
        'js/funciones-jj.js',
        'js/funciones-mabc.js',
        'js/funciones-masm.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
