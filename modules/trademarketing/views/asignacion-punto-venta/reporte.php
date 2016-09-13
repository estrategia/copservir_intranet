<?php

use yii\helpers\Html;
use app\modules\trademarketing\models\AsignacionPuntoVenta;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\trademarketing\models\AsignacionPuntoVentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte calificacion punto de venta';

$colspan = count($modelosEspacios) + 3;

?>
<div class="space-1"></div>
<div class="space-2"></div>

<div class="container">


		<div class="col-md-12">

			<?= $this->render('/common/errores', []) ?>

			<table class="table table-condensed table-bordered" width="100%" >
				<thead>
						<tr class="tableizer-firstrow">
							<th colspan="<?= $colspan ?>">EVALUACION POR DESEMPEÑO EN ADMINISTRACION POR CATEGORIAS. <?= $modeloAsignacion->NombrePuntoDeVenta ?> </th>
						</tr>
				</thead>
				<tbody>

					 	<tr>
							<td colspan="2"></td>
							<!-- porcentajes -->
							<?php foreach ($modelosEspacios as $index => $espacio): ?>

								<td id="porcentaje-<?= $index ?>">
										<?= $porcentajesEspacios[$espacio->nombre]. '%' ?>
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
									<td id="porcentaje-unidad-<?= $index ?>"><?= $porcentajesUnidades[$unidadNegocio['NombreUnidadNegocio']]. '%'?></td>
									<?php foreach ($modelosEspacios as $espacio): ?>

										<td id="calificacion-<?= $contador ?>">
											10,0 <!-- valor de la calificacion a la que apunta  -->
										</td>
										<?php $contador++; ?>
									<?php endforeach; ?>

									<td id="promedio-unidad-<?= $index ?>"></td> <!-- resultado por unidad de negocio -->

							</tr>
						<?php endforeach; ?>

			 			<tr>
							<td colspan="<?= $colspan-1 ?>">RANGO DE CALIFICACION</td>
							<td id="total-rango"></td> <!-- total -->
							<!--<td>DEFICIENTE </td>  nombre rango en el que esta -->
						</tr>
				</tbody>
			</table>
		</div>


		<div class="space-2"></div>
		<?= $this->render('_rangoCalificaciones', [
        'modelosRangoCalificaciones' => $modelosRangoCalificaciones
    ]) ?>

</div>

<div class="space-1"></div>
<div class="space-2"></div>

<?php

	$cantidadUnidades = count($modelosUnidadesNegocio);
	$cantidadEspacios = count($modelosEspacios);

	$this->registerJs("

		var cantidadCampos = $contador;
		var cantidadUnidades = $cantidadUnidades;
		var cantidadEspacios = $cantidadEspacios;

		var calculos = new ReporteAsignacionView(cantidadCampos, cantidadUnidades, cantidadEspacios);

		$( document ).ready(function() {
			calculos.calcularTotalPorUnidades();
			calculos.calcularTotalRango();
		});

	");
?>
