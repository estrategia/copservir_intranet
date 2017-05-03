<?php
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;
use app\modules\intranet\modules\formacioncomunicaciones\models\OpcionRespuesta;
?>

<div class="modal fade" id="modal-visualizacion-pregunta" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $pregunta->tituloPregunta;?></h4>
      </div>
      
      <div class="modal-body">
      
      	<?php if($pregunta->idTipoPregunta != Pregunta::PREGUNTA_COMPLETAR):?>
			<?php echo $pregunta->pregunta;?><br/>
			
			<table class='table table-striped table-bordered'>
			      	<tr>
			      		<th> Respuesta	</th>
			      		<th> Es correcta </th>
			      	</tr>
			      	<?php foreach($pregunta->listOpcionRespuestas as $opcion):?>
			      		<tr>
			      			<td> <?php echo $opcion->respuesta?></td>
			      			<td> <?php echo $opcion->esCorrecta? 'Si':'No'?></td>
			      		</tr>
			      	<?php endforeach;?>
			</table>
			
		<?php else:?>
			<?php $respuestas = [];?>
			<?php foreach($pregunta->listPreguntasHijas as $pregunta):?>
				<?php echo str_replace("@pregunta", "___________", $pregunta->pregunta);?>
				<?php $respuestas[] = $pregunta->listOpcionRespuestas; ?>
			<?php endforeach;?>
			
			<table class='table table-striped table-bordered'>
			      	<tr>
			      		<th> No. Pregunta </th>
			      		<th> Respuesta	</th>
			      		
			      	</tr>
			      	<?php foreach($respuestas as $indice => $listaOpciones):?>
			      		<?php foreach ($listaOpciones as $opcion):?>
				      		<tr>
				      			<td> <?php echo ($indice+1)?></td>
				      			<td> <?php echo $opcion->respuesta?></td>
				      		</tr>
			      		<?php endforeach;?>
			      	<?php endforeach;?>
			</table>
		<?php endif;?>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

     
    </div>
  </div>
</div>