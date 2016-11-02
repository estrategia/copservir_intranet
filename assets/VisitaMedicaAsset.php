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
class VisitaMedicaAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'libs/visita-medica/css/bootstrap/bootstrap.min.css',
        'css/visita-medica.css',
        // 'libs/boostrapv3/css/bootstrap.min.css',
        // 'libs/boostrapv3/css/bootstrap-theme.min.css',

        // carousel
      /*  'libs/multiportal/owl-carousel/owl.carousel.css',
        'libs/multiportal/owl-carousel/owl.theme.css',

        // visor imagenes
        'libs/bootstrap-media-lightbox-master/bootstrap-media-lightbox.css',*/

        //Pantilla para visita medica
        'libs/visita-medica/css/theme-white.css',
        //'libs/bootstrap-select2/select2.css',

        'libs/visita-medica/ad-gallery/jquery.ad-gallery.css',

        //genericas plantilla intranet
       /* 'css/portales-style.css',
        'css/portales-main.css',
        'css/portales-main_1.css',
        'css/common.css'*/
    ];
    public $js = [
        // boostrap

        // 'libs/modernizr/modernizr.js',
        // 'libs/timeago/jquery.timeago.js',
        // 'libs/timeago/jquery.timeago.es.js',

        // // carousel
        // 'libs/multiportal/owl-carousel/owl.carousel.min.js',

        // // visor imagenes
        // 'libs/bootstrap-media-lightbox-master/bootstrap-media-lightbox.min.js',

        // //genericas plantilla intranet
        // 'js/multiportal/timeline.js',
        // 'js/multiportal/vendor/holder.min.js',
        // 'js/multiportal/main.js',

        // 'libs/visita-medica/js/plugins/jquery/jquery.min.js',
        'libs/visita-medica/js/plugins/jquery/jquery-ui.min.js',
        //'libs/bootstrap-select2/select2.js',

        'libs/visita-medica/js/plugins/bootstrap/bootstrap.min.js',

        'libs/visita-medica/js/plugins/icheck/icheck.min.js',
        'libs/visita-medica/js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js',
        'libs/visita-medica/js/plugins/scrolltotop/scrolltopcontrol.js',
        'libs/visita-medica/js/plugins/morris/raphael-min.js',
        'libs/visita-medica/js/plugins/morris/morris.min.js',
        // 'libs/visita-medica/js/plugins/rickshaw/d3.v3.js',
        // 'libs/visita-medica/js/plugins/rickshaw/rickshaw.min.js',
        // 'libs/visita-medica/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        // 'libs/visita-medica/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'libs/visita-medica/js/plugins/bootstrap/bootstrap-datepicker.js',
        'libs/visita-medica/js/plugins/owl/owl.carousel.min.js',
        // 'libs/visita-medica/js/plugins/nvd3/lib/d3.v3.js',
        // 'libs/visita-medica/js/plugins/nvd3/nv.d3.min.js',
        // 'libs/visita-medica/js/demo_charts_nvd3.js',
        'libs/visita-medica/js/plugins/moment.min.js',
        'libs/visita-medica/js/plugins/daterangepicker/daterangepicker.js',
        'libs/visita-medica/js/plugins/datatables/jquery.dataTables.min.js',
        'libs/visita-medica/js/settings.js',
        'libs/visita-medica/js/plugins.js',
        'libs/visita-medica/js/actions.js',
        // 'libs/visita-medica/js/demo_dashboard.js',
        // 'libs/visita-medica/js/demo_maps.js',

        'libs/visita-medica/ad-gallery/jquery.ad-gallery.min.js',

        'js/visitamedica/visitamedica.js',

        


        //propios
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}

?>