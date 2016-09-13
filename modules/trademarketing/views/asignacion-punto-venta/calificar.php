<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\trademarketing\models\VariableMedicion;
use app\modules\trademarketing\models\AsignacionPuntoVenta;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trademarketing\models\AsignacionPuntoVentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Califica un punto de venta';

?>
<div class="space-1"></div>
<div class="space-2"></div>

<div class="container">

		<center>
				<h2>LISTA DE CHEQUEO DE LA REVISIÓN EN PUNTOS DE VENTA PLUS</h2>
		</center>

		<?= $this->render('/common/errores', []) ?>

		<?= $this->render('_cabeceraListaChequeo', [
        'modeloAsignacion' => $modeloAsignacion,
    ]) ?>

<!-- ACA FUE QUE -->
		<?php $form = ActiveForm::begin(); ?>
		<div class="col-md-12">

			<center>
				<table class="table table-condensed table-bordered" width="100%">
					<thead>
						<tr>
								<th rowspan="2">UNIDADES DE NEGOCIO</th>
								<th rowspan="2">VARIABLES</th>

								<?php foreach ($modelosUnidadesNegocio as $index => $unidadNegocio): ?>
									<th>
											<?= $unidadNegocio['NombreUnidadNegocio'] ?>
										</th>
									<?php endforeach; ?>
									<th rowspan="2">TOTAL</th>
									<th rowspan="2">OBSERVACIÓN</th>
						</tr>
						<tr>

							<?php foreach ($modelosUnidadesNegocio as $index => $unidadNegocio): ?>
							<th>
								<?php $modelosPorcentajeUnidad[$index]->porcentaje = $modelosPorcentajeUnidad[$index]->isNewRecord ?
											0 : $modelosPorcentajeUnidad[$index]->porcentaje ?>

								<?=  $form->field($modelosPorcentajeUnidad[$index], '['.$index.']porcentaje')->textInput(['maxlength' => true])->label(false) ?>

								<?=  $form->field($modelosPorcentajeUnidad[$index], '['.$index.']idAsignacion')->hiddenInput(
											['value'=> $modeloAsignacion->idAsignacion])->label(false); ?>

								<?=  $form->field($modelosPorcentajeUnidad[$index], '['.$index.']idAgrupacion')->hiddenInput(
											['value'=>  $unidadNegocio['IdAgrupacion']])->label(false); ?>
							</th>
							<?php endforeach; ?>

						</tr>
					</thead>
					<tbody>
						<?php $contador = 0 ?>
						<?php $contadorObservaciones = 0 ?>
						<?php foreach ($modelosCategoria as $categoria): ?>
							<tr>
								<td rowspan="<?= count($categoria->variablesMedicion)+1 ?>">
									<?= $categoria->nombre ?>
								</td>


						 		<?php foreach ($categoria->variablesMedicion as $variable): ?>
							 		<tr>
										<td>
											<?= $variable->nombre ?>
								 		</td>


								 		<?php if ($variable->calificaUnidadNegocio === VariableMedicion::CALIFICA_UNIDAD): ?>

											<?php foreach ($modelosUnidadesNegocio as $unidadNegocio): ?>

				 								 <td>

													<?php $modelosCalificacion[$contador]->valor = $modelosCalificacion[$contador]->isNewRecord ?
								                0 : $modelosCalificacion[$contador]->valor ?>

													<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']valor')->textInput(['maxlength' => true, 'data-califica-unidad' => 'si', 'data-index' => $contador,  'data-cantidad-variables' => count($categoria->variablesMedicion)])->label(false) ?>

													<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']idAsignacion')->hiddenInput(
								                ['value'=> $modeloAsignacion->idAsignacion])->label(false); ?>

													<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']idVariable')->hiddenInput(
								                ['value'=> $variable->idVariable])->label(false); ?>

													<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']IdAgrupacion')->hiddenInput(
								                ['value'=> $unidadNegocio['IdAgrupacion']])->label(false); ?>

													<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']nombreUnidadNegocio')->hiddenInput(
								                ['value'=> $unidadNegocio['NombreUnidadNegocio']])->label(false); ?>
				 								</td>
												<?php $contador++ ?>

											<?php endforeach; ?>
								 		<?php else: ?>

									 		<td colspan="<?= count($modelosUnidadesNegocio) ?>">
												<?php $modelosCalificacion[$contador]->valor = $modelosCalificacion[$contador]->isNewRecord ?
															0 : $modelosCalificacion[$contador]->valor ?>

												 <?=  $form->field($modelosCalificacion[$contador], '['.$contador.']valor')->textInput(['maxlength' => true, 'data-index' => $contador,  'data-cantidad-variables' => count($categoria->variablesMedicion)])->label(false) ?>

												<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']idAsignacion')->hiddenInput(
							                ['value'=> $modeloAsignacion->idAsignacion])->label(false); ?>

												<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']idVariable')->hiddenInput(
							                ['value'=> $variable->idVariable])->label(false); ?>

									 		</td>
											<?php $contador++ ?>
											<?php endif; ?>


								 		<td id = "total-<?= $contador-1 ?>"></td> <!-- total -->
							 	 		<td><!-- observacion -->

												<?=  $form->field($modelosObservaciones[$contadorObservaciones], '['.$contadorObservaciones.']descripcion')->textInput(['maxlength' => true])->label(false) ?>


												<?=  $form->field($modelosObservaciones[$contadorObservaciones], '['.$contadorObservaciones.']idAsignacion')->hiddenInput(
															['value'=>  $modeloAsignacion->idAsignacion])->label(false); ?>

												<?=  $form->field($modelosObservaciones[$contadorObservaciones], '['.$contadorObservaciones.']idVariable')->hiddenInput(
															['value'=>  $variable->idVariable])->label(false); ?>

												<?php $contadorObservaciones++ ?>

							 	 		</td> <!-- /observacion -->

							 		</tr>

								<?php endforeach; ?>

							</tr>

						<?php endforeach; ?>

						<?php $contadorTotalUnidades = 0 ?>
						<?php foreach ($modelosCategoria as $categoria): ?>
							<tr>
								<td colspan="2">
									<?= $categoria->nombre ?>
								</td>
									<?php foreach ($modelosUnidadesNegocio as $unidadNegocio): ?>

										<td id='total-unidad-<?= $contadorTotalUnidades ?>'>
											hola
										</td>
										<?php $contadorTotalUnidades++ ?>
									<?php endforeach; ?>
							</tr>
						<?php endforeach; ?>


							<tr>
								<td colspan="2">

								</td>
									<?php foreach ($modelosUnidadesNegocio as $index => $unidadNegocio): ?>

										<td id='total-definitivo-<?= $index ?>'>
											0
										</td>
									<?php endforeach; ?>
							</tr>
				  </tbody>
				</table>
			<center>

				<?=  Html::submitButton('Guardar',
							['class' => 'btn btn-primary', 'name' => 'guardar']) ?>

				<?=  Html::submitButton('Finalizar y Guardar',
							['class' => 'btn btn-success', 'name' => 'finalizar']) ?>
			<?php ActiveForm::end(); ?>

		</div>
<!-- ACA FUE QUE -->
</div>

<div class="space-1"></div>
<div class="space-2"></div>

<?php

	$cantidadCampos = count($modelosCalificacion);
	$cantidadUnidades = count($modelosUnidadesNegocio);
	$cantidadCategorias = count($modelosCategoria);



	$this->registerJs("
		var cantidadCampos = $cantidadCampos;
		var cantidadUnidades = $cantidadUnidades;
		var cantidadCategorias = $cantidadCategorias;
		var calculos = new CalificacionAsignacionView(cantidadCampos, cantidadUnidades, cantidadCategorias);
		calculos.actualizarTotales();

		$( document ).ready(function() {
			calculos.calcularTotalPorVariables();
			calculos.calcularTotalPorUnidades();
			calculos.calcularTotales();
		});

	");
?>
