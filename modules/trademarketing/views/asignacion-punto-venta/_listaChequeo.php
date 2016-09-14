<center>
		<h2>LISTA DE CHEQUEO DE LA REVISIÓN EN PUNTOS DE VENTA PLUS</h2>
</center>

<?php $this->render('_cabeceraListaChequeo', array('modeloAsignacion'=>$modeloAsignacion)); ?>

<div class="col-md-12">
	<center>
		<table class="table table-condensed table-bordered" width="100%">
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
					<?php $contadorObservaciones = 0 ?>
					<?php foreach ($modelosCategoria as $categoria): ?>
							<tr>
									<td rowspan="<?= count($modelosVariables[$categoria->nombre])+1 ?>">
										<?= $categoria->nombre ?>
									</td>

									<?php foreach ($modelosVariables[$categoria->nombre] as $variable): ?>
											<tr>
												<td>
													<?= $variable->nombre ?>
												</td>
												<?php if ($variable->calificaUnidadNegocio === 1): ?>

													<?php foreach ($modelosUnidadesNegocio as $unidadNegocio): ?>
														<td>
															<button type="button" hidden="true" id="<?= 'calificacionvariable-'.$contador.'-valor' ?>" data-califica-unidad = 'si' data-index = "<?= $contador ?>" data-cantidad-variables = "<?= count($modelosVariables[$categoria->nombre]) ?>" value="<?= $modelosCalificacion[$contador]->valor ?>"></button>
															<?= $modelosCalificacion[$contador]->valor  ?>

														</td>
														<?php $contador++ ?>
													<?php endforeach; ?>
												<?php else: ?>

													<td colspan="<?= count($modelosUnidadesNegocio) ?>" >
														<?= $modelosCalificacion[$contador]->valor  ?>
														<button type="button" hidden="true" id="<?= 'calificacionvariable-'.$contador.'-valor' ?>" data-index = "<?= $contador ?>" data-cantidad-variables = "<?= count($modelosVariables[$categoria->nombre]) ?>" value="<?= $modelosCalificacion[$contador]->valor ?>"></button>
													</td>

													<?php $contador++ ?>

												<?php endif; ?>

												<td id = "total-<?= $contador-1 ?>"></td> <!-- total -->

												<td> <!-- observacion -->
													<?=  $modelosObservaciones[$contadorObservaciones]->descripcion ?>
													<?php $contadorObservaciones++ ?>
												</td>
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
											0
										</td>
										<?php $contadorTotalUnidades++ ?>
									<?php endforeach; ?>
							</tr>
					<?php endforeach; ?>

					<tr>
						<td colspan="2">
							TOTAL
						</td>
							<?php foreach ($modelosUnidadesNegocio as $index => $unidadNegocio): ?>

								<td id='total-definitivo-<?= $index ?>'>
									0
								</td>
							<?php endforeach; ?>
					</tr>

				</tbody>
		</table>
	</center>
</div>

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
