<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Resumen Cuestionario';

if($resumen):
	$this->params['breadcrumbs'][] = ['label' => 'Cuestionario Usuarios', 'url' => ['cuestionario-usuarios']];
	$this->params['breadcrumbs'][] = $this->title;
else:
	$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['curso/mis-cursos']];
	$this->params['breadcrumbs'][] = ['label' => $modelCuestionario->objCurso->nombreCurso, 'url' => ['curso/visualizar-curso','id' => $modelCuestionario->idCurso]];
	$this->params['breadcrumbs'][] = $this->title;
endif;
?>

<h1><?php echo $this->title?></h1>

<h2><?php echo $modelCuestionario->tituloCuestionario?></h2>
<h5>Porcentaje necesario para aprobar: <?= $modelCuestionario->porcentajeMinimo ?>%</h5>
<h5>Puntos otorgados al aprobar: <?php echo $modelCuestionario->idContenido == null ? $modelCuestionario->objCurso->cantidadPuntos : $modelCuestionario->objContenido->cantidadPuntos ?></h5>
<?php echo $modelCuestionario->descripcionCuestionario ?>
<table class='table table-striped table-bordered'>
	<tr>
		<th>Intento </th>
		<th>Fecha Inicializado </th>
		<th>Fecha Finalizado </th>
		<th>Tiempo empleado </th>
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
				<td><?php echo $intento->getTiempoEmpleado()?></td>
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
				$calificacion < $modelCuestionario->porcentajeMinimo):
			 echo Html::a('Iniciar Cuestionario', ['visualizar-cuestionario', 'id' => $modelCuestionario->idCuestionario] ,['class' => 'btn btn-success'] );
			?>
	
			<?php elseif($calificacion >= $modelCuestionario->porcentajeMinimo):?>
		
			<div class="jumbotron" style="padding-top: 20px;">
			<!-- <div class='alert alert-success'>Has aprobado este cuestionario  </div> -->
				<h3>Has obtenido <?php echo $modelCuestionario->getPuntos(); ?> puntos al superar la prueba de conocimiento.</h3>
				<h4>Ahora puedes redimirlos en la tienda o ver los puntos acumulados.</h4>
				<a href="<?php echo Url::toRoute('redencion/index'); ?>" class="btn btn-default">Redimir</a>
				<button class="btn btn-default" data-role="ver-puntos-usuario">Acumulados</button>
			</div>
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
