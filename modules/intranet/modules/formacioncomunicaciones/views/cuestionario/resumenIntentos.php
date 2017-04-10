<?php
use yii\helpers\Html;
$this->title = 'Resumen Cuestionario';

$this->params['breadcrumbs'][] = ['label' => 'Mis Cursos', 'url' => ['mis-cursos']];
$this->params['breadcrumbs'][] = ['label' => $modelCuestionario->objCurso->nombreCurso, 'url' => ['curso/visualizar-curso','id' => $modelCuestionario->idCurso]];
$this->params['breadcrumbs'][] = $this->title;
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
		<?php $i = 0;
		$calificacion = 0;?>
		<?php if(count($cuestionariosPrevios) > 0):?>
			<?php foreach($cuestionariosPrevios as $intento):?>
			<?php $calificacion = $intento->porcentajeObtenido>$calificacion?$intento->porcentajeObtenido:$calificacion?>
				<tr>
					<td><?php echo ++$i;?></td>
					<td><?php echo $intento->fechaCreacion?></td>
					<td><?php echo $intento->fechaActualizacion?></td>
					<td><?php echo round($intento->numeroPreguntasRespondidas,2)?></td>
					<td><?php echo round($intento->porcentajeObtenido,2)?></td>
				</tr>
			<?php endforeach;?>
		<?php else:?>
		<tr> <td colspan='5' >No tiene intentos previos</td></tr>	
		<?php endif;?>
	</table>
		<?php if($calificacion > 0):?>
			<h1> Calificaci&oacute;n m&aacute;s alta: <?php echo round($calificacion,2)?>%</h1>
		<?php endif;?>
		<?php if(!$resumen):?>
			<?php if((($modelCuestionario->numeroIntentos != 0 && 
					count($cuestionariosPrevios) < $modelCuestionario->numeroIntentos) || $modelCuestionario->numeroIntentos == 0) && 
					$calificacion < $modelCuestionario->porcentajeMinimo &&
					($modelCuestionario->objCurso->leido())):
				 echo Html::a('Nuevo intento', ['visualizar-cuestionario', 'id' => $modelCuestionario->idCuestionario] ,['class' => 'btn btn-success'] );
			
				 elseif(!$modelCuestionario->objCurso->leido()):?>
				 <div class='alert alert-danger'>Debes primero leer el curso antes de hacer el cuestionario  </div>
				<?php elseif($calificacion >= $modelCuestionario->porcentajeMinimo):?>
			
				<div class='alert alert-success'>Has aprobado este cuestionario  </div>
			<?php else:?>	
				<div class='alert alert-danger'>No se permiten m&aacute;s intentos.</div>
			<?php endif;?>
		<?php else:?>
				<?php if($calificacion >= $modelCuestionario->porcentajeMinimo):?>
				<div class='alert alert-success'>Cuestionario aprobado </div>
				<?php else:?>
				<div class='alert alert-danger'>Cuestionario reprobado.</div>
				<?php endif;?>
		<?php endif;?>
</div>