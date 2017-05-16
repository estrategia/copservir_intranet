<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author MASM <miguel.sanchez@eiso.coom.co>
 * @since 2.0
 */
class CalendarAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/fullcalendar/fullcalendar.css',
        'libs/font-awesome/css/font-awesome.css',
    ];
    public $js = [
        'libs/fullcalendar/fullcalendar.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
