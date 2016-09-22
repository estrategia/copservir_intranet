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
						'modeloAsignacion' => $modeloAsignacion,
					  'modelosUnidadesNegocio' => $modelosUnidadesNegocio,
						'modelosCategoria' => $modelosCategoria,
						'modelosCalificacion' => $modelosCalificacion,
						'modelosObservaciones' => $modelosObservaciones,
						'modelosVariables' => $modelosVariables
						)
					);

				?>

			</div>

			<div role="tabpanel" class="tab-pane" id="reporte">
				<?=

					$this->render('_reporteEvaluacion', array(
						'modeloAsignacion' => $modeloAsignacion,
					  'modelosUnidadesNegocio' => $modelosUnidadesNegocio,
						'modelosEspacios' => $modelosEspacios,
						'modelosRangoCalificaciones' => $modelosRangoCalificaciones,
						'modelosPorcentajeUnidad' => $modelosPorcentajeUnidad,
						'modelosPorcentajeEspacio' => $modelosPorcentajeEspacio,
						'valoresReporte' => $valoresReporte,
						)
					);

				?>
			</div>
	  </div>

	</div>

</div>
