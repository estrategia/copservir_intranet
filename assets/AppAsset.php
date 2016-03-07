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
        'libs/font-awesome/css/font-awesome.css',
        'css/animate/animate.min.css',
        'css/jquery-scrollbar/jquery.scrollbar.css',
        'css/webarch/webarch.css',
        'css/site.css'
    ];
    public $js = [
        'js/bootstrap.min.js',
        'js/jquery-scrollbar/jquery.scrollbar.min.js',
        'js/jquery-numberAnimate/jquery.animateNumbers.js',
        'js/jquery-validation/js/jquery.validate.min.js',
        'js/webarch/webarch.js',
        'js/funciones-jj.js',
            // 'js/dashboard/dashboard.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
