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
class VisitaMedicaReportesAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        // 'libs/visita-medica/css/bootstrap/bootstrap.min.css',
        'css/visita-medica.css',

        // 'libs/visita-medica/css/theme-white.css',

    ];
    public $js = [

        // 'libs/visita-medica/js/plugins/jquery/jquery.min.js',
        // 'libs/visita-medica/js/plugins/jquery/jquery-ui.min.js',
        //'libs/bootstrap-select2/select2.js',

        // 'libs/visita-medica/js/plugins/bootstrap/bootstrap.min.js',

        // 'libs/visita-medica/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js',
        // 'libs/visita-medica/ad-gallery/jquery.ad-gallery.min.js',
        // 'libs/visita-medica/js/plugins/scrolltotop/scrolltopcontrol.js',
        'js/multiportal/reportes-visitamedica.js',
        'libs/visita-medica/js/plugins/morris/raphael-min.js',
        'libs/visita-medica/js/plugins/morris/morris.min.js',
        // 'libs/jquery-datatable/js/jquery.dataTables.min.js',
        // 'libs/visita-medica/js/plugins/moment.min.js',
        // 'libs/visita-medica/js/plugins/datatables/jquery.dataTables.min.js',
        // 'libs/visita-medica/js/settings.js',
        // 'libs/visita-medica/js/plugins.js',
        // 'libs/visita-medica/js/actions.js',

        // 'js/visitamedica/visitamedica.js',

        


        //propios
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}

?>
