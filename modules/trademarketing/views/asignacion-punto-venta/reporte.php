<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Reportes';
//$this->params['breadcrumbs'][] = ['label' => 'Asignacion Punto Ventas', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>

<div class="">

	<div>

	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">

			<li role="presentation" class="active">
				<a href="#lista" aria-controls="lista" role="tab" data-toggle="tab">Lista de chequeo</a>
			</li>

			<li role="presentation">
				<a href="#reporte" aria-controls="reporte" role="tab" data-toggle="tab">Reporte evaluación</a>
			</li>

	  </ul>

	  <!-- Tab panes -->
	  <div class="tab-content">

			<div role="tabpanel" class="tab-pane active" id="lista">
				<?=
					$this->render('_listaChequeo', array(
						'informacionReporte' => $informacionReporte,
						)
					);
				?>
			</div>

			<div role="tabpanel" class="tab-pane" id="reporte">
				<?=
					$this->render('_reporteEvaluacion', array(
						'informacionReporte' => $informacionReporte,
						)
					);
				?>
			</div>
	  </div>

	</div>

</div>

<div class="modal fade" id="listado-observaciones" tabindex="-1" role="dialog" aria-labelledby="listado-observaciones">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Observaciones</h4>
      </div>
      <div class="modal-body">
        <ul id="listado">
          
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>