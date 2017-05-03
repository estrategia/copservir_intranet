<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author MASM <miguel.sanchez@eiso.coom.co>
 * @since 2.0
 */
class DataTableAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //datatables
        'libs/jquery-datatable/css/jquery.dataTables.css',
        //'libs/datatables-responsive/css/datatables.responsive.css',
    ];
    public $js = [
        //datatables
        //'libs/jquery-datatable/js/jquery.dataTables.min.js',
        'libs/jquery-datatable/js/jquery.dataTables.min.js',
        //'libs/jquery-datatable/extra/js/dataTables.tableTools.min.js',
        //'libs/datatables-responsive/js/datatables.responsive.js',
        //'libs/datatables-responsive/js/lodash.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
