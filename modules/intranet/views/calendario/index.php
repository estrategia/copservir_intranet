<?php
/* use vova07\imperavi\Widget;
  use yii\widgets\ActiveForm;
  use yii\helpers\Url;
  use yii\helpers\Html; */

/* @var $this yii\web\View */

$this->title = 'Calendario';
?>

<?php $this->registerJsFile("@web/js/calendario.js", ['depends' => [app\assets\AppAsset::className()]]); ?>

<div class="row" style="max-height:600px;">
    <div class="tiles row tiles-container red no-padding">
        <div class="col-md-4 tiles red no-padding">
            <div class="tiles-body">
                <div id="calendar-summary" class="calender-options-wrapper">
                    
                </div>
            </div>
        </div>
        <div class="col-md-8 tiles white no-padding">
            <div class="tiles-body">
                <div class="full-calender-header">
                    <div class="pull-left">
                        <div class="btn-group ">
                            <button class="btn btn-success" id="calender-prev"><i class="fa fa-angle-left"></i></button>
                            <button class="btn btn-success" id="calender-next"><i class="fa fa-angle-right"></i></button>
                        </div>
                    </div>
                    <div class="pull-right">
                        <div class="btn-group" data-toggle="buttons">
                            <button class="btn btn-primary active" type="button" id="change-view-month">mes</button>
                            <button class="btn btn-primary " type="button" id="change-view-week">semana</button>
                            <button class="btn btn-primary" type="button" id="change-view-day">d&iacute;a</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div id='calendar'></div>
            </div>
        </div>
    </div>
</div>
