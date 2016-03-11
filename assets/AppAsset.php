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
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',

        'libs/fullcalendar/fullcalendar.css',
        'libs/pace/pace-theme-flash.css',
        'libs/animate/animate.min.css',
        'libs/font-awesome/css/font-awesome.css',
        'libs/jquery-scrollbar/jquery.scrollbar.css',
        'libs/webarch/webarch.css',
        'css/site.css'
    ];
    public $js = [

        'libs/pace/pace.min.js',
        'libs/jquery-scrollbar/jquery.scrollbar.min.js',
        'libs/jquery-numberAnimate/jquery.animateNumbers.js',
        'libs/jquery-validation/js/jquery.validate.min.js',
        'libs/webarch/webarch.js',
        'js/funciones-jj.js',
        //

        'libs/jquery-block-ui/jqueryblockui.min.js',
        'libs/jquery-unveil/jquery.unveil.min.js',
        'libs/bootstrap-select2/select2.min.js',
        'libs/jquery-ui/jquery-ui-1.10.1.custom.min.js',
        'libs/jquery-ui-touch/jquery.ui.touch-punch.min.js',
        'libs/fullcalendar/fullcalendar.js',
        'libs/calender/calender.js',
            // 'js/dashboard/dashboard.js',

        'libs/bootstrap/js/bootstrap.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
