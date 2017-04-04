<?php
use yii\helpers\Html;
$this->title = 'Resolver Cuestionario';
?>

<h1><?php echo $this->title?></h1>

<div class='container'>
	<h2><?php echo $modelCuestionario->tituloCuestionario?></h2>
	
	<?php echo $modelCuestionario->descripcionCuestionario ?>
	<table class='table table-striped table-bordered'>
		<tr>
			<th>Intento </th>
			<th>Fecha Inicializado </th>
			<th>Fecha Finalizado </th>
			<th>Preguntas correctas</th>
			<th>Puntaje</th>
		</tr>
		<?php $i = 0;?>
		<?php if(count($cuestionariosPrevios) > 0):?>
			<?php foreach($cuestionariosPrevios as $intento):?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo $intento->fechaCreacion?></td>
					<td><?php echo $intento->fechaActualizacion?></td>
					<td><?php echo $intento->numeroPreguntasRespondidas?></td>
					<td><?php echo $intento->porcentajeObtenido?></td>
				</tr>
			<?php endforeach;?>
		<?php else:?>
		<tr> <td colspan='5' >No tiene intentos previos</td></tr>	
		<?php endif;?>
	</table>
		<?php if($modelCuestionario->numeroIntentos != 0 && count($cuestionariosPrevios) < $modelCuestionario->numeroIntentos):
			 echo Html::a('Nuevo intento', ['visualizar-cuestionario', 'id' => $modelCuestionario->idCuestionario] ,['class' => 'btn btn-success'] );
		else:?>
			<div class='alert alert-danger'>No se permiten m&aacute;s intentos.</div>
		<?php endif;?>
		
</div>