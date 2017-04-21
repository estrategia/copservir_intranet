<table class='table table-striped table-bordered'>
      	<tr>
      		<th> Respuesta	</th>
      		<th> Eliminar	</th>
      	</tr>
      	<?php foreach($opcionesAgregadas as $opcion):?>
      		<tr>
      			<td> <?php echo $opcion->respuesta?></td>
      			<td> <a href='#' data-role='eliminar-opcion' data-opcion='<?php echo $opcion->idOpcionRespuesta?>' ><span class='glyphicon glyphicon-trash'> </span></a>     			</td>
      		</tr>
      	<?php endforeach;?>
</table>