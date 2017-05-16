<?php
use app\modules\intranet\models\Tareas;
use yii\helpers\Url;

?>
<br><br><br>
<div class="col-md-12 col-sm-12 spacing-bottom">
  <div class="grid simple">
    <div class="grid-title no-border " style='background-color:#FF7F00 !important'>
      <div class="pull-left ">
        <a href="<?= Url::to(['/intranet/tareas/listar-tareas']) ?>" class="btn btn-dark  btn-small"><i class="fa fa-plus"></i></a>
      </div>
      <h4 style='color:#fff !important;'>Tareas</h4>
      <div class="tools">
        <a href="javascript:;" data-role="quitar-elemento"
        data-elemento="<?=\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_TAREAS?> " class="remove">

        </a>
      </div>
    </div>
    <div class="widget-body">
      <br>

      <?php foreach ($tareasUsuario as $tarea): ?>
        <div class="row-fluid">

          <?php

          $clase ='';
          $check_success= '';
          $checkeado = '';

          if ($tarea->estadoTarea == Tareas::ESTADO_TAREA_TERMINADA) {
            $clase = 'done';
            $check_success = 'check-success';
            $checkeado = 'checked';
          }
          ?>
          
          <div class= "<?=  "checkbox ".$check_success ?> col-md-12" >
            <div class="col-md-3 col-xs-2">
              <a href='#' data-tarea= "<?= $tarea->idTarea?>" data-location="<?= Tareas::TAREAS_INDEX ?>" data-role='inactivarTarea'>
                <li class="fa fa-times"></li>
              </a>
            </div>
            <div class="col-md-9 col-xs-10">
              <input type="checkbox" <?= $checkeado?>  id="chk_todo<?= $tarea->idTarea ?>" class="todo-list" data-tarea="<?= $tarea->idTarea ?>" data-role="tarea-check">
              <label for="chk_todo<?= $tarea->idTarea ?>"  class="<?= $clase ?>"><?= $tarea->descripcion ?></label>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
