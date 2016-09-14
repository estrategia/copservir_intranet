<?php

$colspan = count($modelosEspacios) + 3;
?>
<?php // var_dump($valoresReporte[0]->valor) ?>
<div class="col-md-12">
	<table class="table table-condensed table-bordered" width="100%">
		<thead>
			<tr>
				<th colspan="<?= $colspan ?>">
					EVALUACION POR DESEMPEÑO EN ADMINISTRACION POR CATEGORIAS. <?= $modeloAsignacion->NombrePuntoDeVenta ?>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2"></td>
				<!-- porcentajes -->
				<?php foreach ($modelosEspacios as $index => $espacio): ?>

					<td id="porcentaje-<?= $index ?>">
									<?= $modelosPorcentajeEspacio[$espacio->nombre].'%' ?>
					</td>

				<?php endforeach; ?>

				<td>100%</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>% PART ESPACIO</td>

				<?php foreach ($modelosEspacios as $espacio): ?>

					<td>
							<?= $espacio->nombre ?>
					</td>

				<?php endforeach; ?>

				<td>RESULTADO POR UNIDAD DE NEGOCIO</td>
			</tr>

			<?php $contador = 0; ?>
			<?php foreach ($modelosUnidadesNegocio as $index => $unidadNegocio): ?>
				<tr>
						<td>
								<?= $unidadNegocio['NombreUnidadNegocio'] ?>
						</td>
						<td id="porcentaje-unidad-<?= $index ?>"><?=  $modelosPorcentajeUnidad[$unidadNegocio['NombreUnidadNegocio']].'%'  ?></td>
						<?php foreach ($modelosEspacios as $espacio): ?>

							<td id="calificacion-<?= $contador ?>">
								<?= $valoresReporte[$contador]->valor  ?>
							</td>
							<?php $contador++; ?>
						<?php endforeach; ?>

						<td id="promedio-unidad-<?= $index ?>"></td> <!-- resultado por unidad de negocio -->

				</tr>
			<?php endforeach; ?>

			<tr>
				<td colspan="<?= $colspan-1 ?>">RANGO DE CALIFICACION</td>
				<td id="total-rango"></td> <!-- total -->
			</tr>
		</tbody>
	</table>

</div>

<div class="space-2"></div>
	<?= $this->render('_rangoCalificaciones', [
		'modelosRangoCalificaciones' => $modelosRangoCalificaciones
	]) ?>

<?php

	$cantidadUnidades = count($modelosUnidadesNegocio);
	$cantidadEspacios = count($modelosEspacios);


	$this->registerJs("

		var cantidadCampos2 = $contador;
		var cantidadUnidades2 = $cantidadUnidades;
		var cantidadEspacios2 = $cantidadEspacios;

		var calculosReporte = new ReporteAsignacionView(cantidadCampos2, cantidadUnidades2, cantidadEspacios2);
		$( document ).ready(function() {
			calculosReporte.calcularTotalPorUnidades();
			calculosReporte.calcularTotalRango();
		});

	");

?>
