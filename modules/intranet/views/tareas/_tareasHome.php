<?php
use yii\helpers\Url;
?>
    <br><br><br>
    <div class="col-md-12 col-sm-12 spacing-bottom">
      <div class="widget">
        <div class="widget-title dark">
          <div class="pull-left ">
              <a href="<?= Url::to(['/intranet/tareas/listar-tareas']) ?>" class="btn btn-dark  btn-small"><i class="fa fa-plus"></i></a>
          </div>
          Tareas
          <div class="controller"> <a href="javascript:;" class="collapse"></a> <a href="javascript:;" class="remove" data-role="quitar-elemento" data-elemento="<?=\app\modules\intranet\models\UsuarioWidgetInactivo::WIDGET_TAREAS?>"></a> </div>
        </div>
        <div class="widget-body">
          <br>

          <?php foreach ($tareasUsuario as $tarea): ?>
            <div class="row-fluid">

              <?php

                $clase ='';
                $check_success= '';
                $checkeado = '';

                if ($tarea->estadoTarea == 1) {
                    $clase = 'done';
                    $check_success = 'check-success';
                    $checkeado = 'checked';
                }

              ?>
              <div class= "<?=  "checkbox ".$check_success ?>" >
                <a href='#' data-tarea= "<?= $tarea->idTarea?>" data-location='1' data-role='inactivarTarea'>
                  <li class="fa fa-times"></li>
                </a>
                <input type="checkbox" <?= $checkeado?>  id="chk_todo<?= $tarea->idTarea ?>" class="todo-list" data-tarea="<?= $tarea->idTarea ?>" data-role="tarea-check">
                <label for="chk_todo<?= $tarea->idTarea ?>"  class="<?= $clase ?>"><?= $tarea->descripcion ?></label>
              </div>
            </div>
          <?php endforeach; ?>
          </div>
        </div>
    </div>
