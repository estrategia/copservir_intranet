<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\trademarketing\models\VariableMedicion;

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


		<?= $this->render('_cabeceraListaChequeo', [
        'modeloAsignacion' => $modeloAsignacion,
    ]) ?>

<!-- ACA FUE QUE -->
		<?php $form = ActiveForm::begin(); ?>

		<center>
			<table class="table table-bordered" width="100%">
				<thead>
					<tr>
							<th>UNIDADES DE NEGOCIO</th>
							<th>VARIABLES</th>

							<?php foreach ($modelosUnidadesNegocio as $unidadNegocio): ?>
								<th>
										<?= $unidadNegocio['NombreUnidadNegocio'] ?>
									</th>
								<?php endforeach; ?>

								<th>TOTAL</th>
								<th>OBSERVACIÓN</th>
					</tr>
				</thead>
				<tbody>
					<?php $contador = 0 ?>
					<?php foreach ($modelosCategoria as $categoria): ?>
						<tr>
							<td rowspan="<?= count($categoria->variablesMedicion)+1 ?>"> <!-- aca +1 -->
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

												<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']idAgrupacion')->hiddenInput(
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

											<?=  $form->field($modelosCalificacion[$contador], '['.$contador.']idAgrupacion')->hiddenInput(
						              ['value'=> $unidadNegocio['IdAgrupacion']])->label(false); ?>

											<?php  $form->field($modelosCalificacion[$contador], '['.$contador.']nombreUnidadNegocio')->hiddenInput(
						                ['value'=> $unidadNegocio['NombreUnidadNegocio']])->label(false); ?>
								 		</td>
										<?php $contador++ ?>
										<?php endif; ?>


							 		<td id = "total-<?= $contador-1 ?>"></td> <!-- total -->
						 	 		<td></td> <!-- observacion -->

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
								TOTAL
							</td>
								<?php foreach ($modelosUnidadesNegocio as $unidadNegocio): ?>

									<td>
										total - 0
									</td>
								<?php endforeach; ?>
						</tr>
			  </tbody>
			</table>
		<center>

			<?php // Html::submitButton('Guardar',
						//['class' => 'btn btn-primary']) ?>

			<?php // Html::submitButton('Finalizar y Guardar',
						//['class' => 'btn btn-success']) ?>
		<?php ActiveForm::end(); ?>
<!-- ACA FUE QUE -->

</div>

<div class="space-1"></div>
<div class="space-2"></div>

<script type="text/javascript">

</script>
<?php

	$cantidadCampos = count($modelosCalificacion);
	$cantidadUnidades = count($modelosUnidadesNegocio);



	$this->registerJs("
		var cantidadCampos = $cantidadCampos;
		var cantidadUnidades = $cantidadUnidades;
		var calculos = new CalificacionAsignacionView(cantidadCampos, cantidadUnidades);
		calculos.actualizarTotalesPorVariables();

		$( document ).ready(function() {
			calculos.calcularTotalPorVariables();
			calculos.calcularTotalPorUnidades();
		});

	");
?>
