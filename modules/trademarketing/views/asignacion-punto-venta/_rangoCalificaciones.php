<div class="col-md-12">
	<center>
		<!-- rango calificaciones -->
		<table class="table table-condensed table-bordered" width="100%" >
			<thead>
					<tr>
						<th colspan="2" >Rango de calificaciones</th>
					</tr>
			</thead>
			<tbody>
					<?php foreach ($modelosRangoCalificaciones as $calificacion): ?>
						<tr>
							<td>
									<?= $calificacion->valor ?>
							</td>
							<td>
									<?= $calificacion->nombre ?>
							</td>
						</tr>
					<?php endforeach; ?>
			</tbody>
		</table>
	</center>
</div>
