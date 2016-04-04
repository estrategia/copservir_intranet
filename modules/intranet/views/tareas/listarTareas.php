<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Tareas';
?>

<div class="col-md-12">
    <div class="grid simple">
        <div class="grid-title no-border" style="background-color:#367FA9 !important;">
            <h4 style='color:#fff !important;'>Administrar  <span class="semi-bold">Tareas</span></h4>
            <div class="tools">	<a href="javascript:;" class="collapse"></a>
				<a href="#grid-config" data-toggle="modal" class="config"></a>
				<a href="javascript:;" class="reload"></a>
				<a href="javascript:;" class="remove"></a>
            </div>
        </div>
        <div class="grid-body no-border">
              <h3>Tareas  <span class="semi-bold">Personales</span></h3>
              <?= Html::a('crear tarea', ['crear'], ['class'=>'btn btn btn-primary pull-right']) ?>
                <table class="table no-more-tables">
                    <thead>
                        <tr>
                            <th style="width:1%">
                                <div class="checkbox check-default"></div>
                            </th>
                            <th style="width:9%">Título</th>
                            <th style="width:22%">Descripción</th>
                            <th style="width:22%">Prioridad</th>
                            <th style="width:6%">Fecha Estimada</th>
                            <th style="width:10%">Progreso</th>
                        </tr>
                    </thead>
                    <tbody id="widget-tareas">
                        <?php echo $this->render('/tareas/_listaTareas',['tareasUsuario' => $tareasUsuario])?>
                    </tbody>
                </table>
        </div>
    </div>
</div>

<?php
$this->registerJs(
        "
  //::::::::::::::::::::::
  // SLIDER TAREAS
  //::::::::::::::::::::::

  /*
  * funcionamiento del slider
  */
  $( document ).ready(function() {
      $('.slider-element').slider();
  });

  "
);
?>
