<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

// importancion necesaria para el modal
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Intranet - Copservir';
?>
<div class="col-md-12">
  <div class="tiles overflow-hidden full-height tiles-overlay-hover m-b-10 widget-item">
    Banner
  </div>
</div>



<div class="col-md-9">

  <!-- nav lineas de tiempo -->
  <ul class="nav nav-tabs">
      <?php foreach ($lineasTiempo as $linea): ?>
          <li ><a data-toggle="tab" data-role="cambiar-timeline" data-timeline="<?= $linea->idLineaTiempo ?>" href="#lt<?= $linea->idLineaTiempo ?>"><?= $linea->nombreLineaTiempo ?></a></li>
      <?php endforeach; ?>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active">

      <?= Html::a('<i class="fa fa-pencil"></i> Publicar <i><small>Requiere Aprobación</small></i>', '#', [
            'id' => 'show-publications',
            'class' => 'btn btn-primary btn-lg btn-large',
            'data-toggle' => 'modal',
            'data-target' => '#modal',
            //'data-url' => Url::to(['guardarContenido']),
        ]); ?>


    <?php
        Modal::begin([
            'id' => 'modal',
            'header' => '<h4 class="modal-title">Complete</h4>',
            'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Cerrar</a>',
        ]);

        echo "<div class=''>hola</div>";

        Modal::end();
    ?>

      <!--<a data-toggle="modal" data-target="#modal_formulario_noticias" type="button" class="btn btn-primary btn-lg btn-large"> <i class="fa fa-pencil"></i> Publicar <i><small>Requiere Aprobación</small></i></a>-->

      <!-- el contenido de las lineas de tiempo -->
      <?php foreach ($lineasTiempo as $linea): ?>

          <div id="lt<?= $linea->idLineaTiempo ?>" class="tab-pane fade lineastiempo">
          </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>
<!-- END PUBLICACIONES -->

<!--  BEGIN ESTADISTICAS -->
<div class="col-md-3">
  <!-- Estadisticas -->
  <div class="col-md-12 col-sm-12">
    <div class="tiles blue    m-b-10">
      <div class="tiles-body">
        <div class="controller">
          <a href="javascript:;" class="reload"></a>
          <a href="javascript:;" class="remove"></a>
        </div>
        <h4 class="text-black no-margin semi-bold">Productos</h4>
        <h2 class="text-white bold "><span data-animation-duration="900" data-value="24534" class="animate-number">24,534</span></h2>
        <div class="description">
          <i class="icon-custom-up"></i><span class="text-white mini-description ">&nbsp; 4% aumento  <span class="blend">en el mes</span></span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- END ESTADISTICAS -->
