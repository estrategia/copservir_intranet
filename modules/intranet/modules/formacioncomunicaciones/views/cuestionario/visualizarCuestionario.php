<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;
use app\modules\intranet\modules\formacioncomunicaciones\models\Cuestionario;
$src = Yii::$app->homeUrl . 'img/formacioncomunicaciones/assets/';



$this->title = 'Resolver Cuestionario';

$this->params['breadcrumbs'][] = ['label' => 'Programas', 'url' => ['curso/mis-cursos']];
$this->params['breadcrumbs'][] = ['label' => $model->objCurso->nombreCurso, 'url' => ['/curso/visualizar-curso','id' => $model->idCurso]];
$this->params['breadcrumbs'][] = ['label' => 'Resumen cuestionario', 'url' => ['aplicar-cuestionario','id' => $model->idCuestionario]];
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Cuestionarios', 'url' => ['/intranet/formacioncomunicaciones/cuestionario']];
?>
<style> .cuestionario table, th, td{border:solid 1px; padding: 2px 2px 2px 2px} .cuestionario input[type="checkbox"]{opacity:1}</style>
<?php  if($model->tiempo != 0):?>
<script type="text/javascript">
	var milisegundos = 1000;
	var restante = <?php echo $model->tiempo*60?>;
	var empleado = 0;
	<?php if($cuestionarioUsuario->estadoCuestionario != Cuestionario::CUESTIONARIO_CERRADO):?>
	timer = setInterval('temporizador()', milisegundos);
	<?php endif;?>
	function temporizador() {
		$(document).ready(function() {
			$("#tiempoRestante").html(formato(restante));
			$("#tiempoEmpleado").html(formato(empleado));
			restante--;
			empleado++;

			if(restante < 0 ){
				alert("El tiempo ha finalizado");
				restante = <?php echo $model->tiempo*60?>;
				$("#form-cuestionario").submit();
			}
		});
		
	}

	function formato(x){ // x en segundos

		if(x > 0){
			var horas= x/3600;
	
			var minutosPendientes= x%3600;
			var minutos = minutosPendientes/60;
			var segundos = minutosPendientes%60;
			
			return pad(Math.floor(horas))+":"+pad(Math.floor(minutos))+":"+pad(segundos);
		}else{
			return "00:00:00";
		}
		
	}

	function pad (n) {
	    var  n = n.toString();
	    while(n.length < 2)
	         n = "0" + n;
		return n;
	}
		
</script>
<?php endif;?>
<div class="cuestionario">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php $disabled="";?>
    
    <?php if (Yii::$app->session->has('success')): ?>
	  <div class="alert alert-success" role="alert">
	    <?= Yii::$app->session->getFlash('success') ?>
	  </div>
	<?php endif ?>
	<?php if (Yii::$app->session->has('error')): ?>
	  <div class="alert alert-danger" role="alert">
	    <?= Yii::$app->session->getFlash('error') ?>
	  </div>
	<?php endif ?>
	    
    <?php if($cuestionarioUsuario->estadoCuestionario == Cuestionario::CUESTIONARIO_CERRADO):?>
    		<table class='table table-striped table-bordered' >
    			<tr> <td colspan="2">Resumen del cuestionario</td></tr>
    			<tr> <td>Iniciado</td><td><?=  $cuestionarioUsuario->fechaCreacion?></td></tr>
    			<tr> <td>Finalizado</td><td><?=  $cuestionarioUsuario->fechaActualizacion?></td></tr>
    			<tr> <td>Tiempo empleado</td><td><?=  $cuestionarioUsuario->getTiempoEmpleado()?></td></tr>
    			<tr> <td>Preguntas correctas</td><td><?=  $cuestionarioUsuario->numeroPreguntasRespondidas?></td></tr>
    			<tr> <td>Puntaje</td><td><?=  round($cuestionarioUsuario->porcentajeObtenido,2)?>%/100%</td></tr>
    			<tr> <td>Aprobado</td><td>
    						<?php if($cuestionarioUsuario->cuestionarioAprobado()):?>
    								<img class="" style="margin:0 auto;"  src='<?php echo $src?>correct.png'/>
    						<?php else:?>
    								<img class="" style="margin:0 auto;"  src='<?php echo $src?>mistake.png'/>
    						<?php endif;?>
    				</td></tr>
    			<tr> <td>Puntos Ganados</td><td><?=  $cuestionarioUsuario->getPuntosObtenidos();?> Pts</td></tr>
    		</table>
    		<div class='row'>
    			<div class='col-sm-2'>
    				Respuesta correcta:
    			</div>
    			<div class='col-sm-2'>
    				<img class="" style="margin:0 auto;"  src='<?php echo $src?>correct.png'/>
    			</div>
    			<div class='col-sm-2'>
    				Respuesta incorrecta:
    			</div>
    			<div class='col-sm-2'>
    				<img class="" style="margin:0 auto;"  src='<?php echo $src?>mistake.png'/>
    			</div>
    			<div class='col-sm-2'>
    				Respuesta correcta sin marcar:
    			</div>
    			<div class='col-sm-2'>
    				<img class="" style="margin:0 auto;"  src='<?php echo $src?>unmarked.png'/>
    			</div>
    		</div>
    		<br/>
    		<?php $disabled=" disabled";?>
    <?php else:?>
    	<table class='table table-striped table-bordered' style="width:30%">
    			<tr> <td >Tiempo restante</td><td> <span id='tiempoRestante'></span></td></tr>
    			<tr> <td >Tiempo empleado</td><td> <span id='tiempoEmpleado'></span></td></tr>
    	</table>
    <?php endif;?>
    <?php $form = ActiveForm::begin(['id' => 'form-cuestionario']); ?>
    <?php $i = 1;?>
    <input type='hidden' value='<?php echo $cuestionarioUsuario->idCuestionarioUsuario?>' name='idCuestionarioUsuario' />
    <?php foreach($preguntas as $pregunta):?>
    	<?php if($pregunta->idPreguntaPadre == NULL):?>
    		<?php echo $i;?>.
    		<?php if($pregunta->idTipoPregunta != Pregunta::PREGUNTA_COMPLETAR):?>
	    	 		<?php echo $pregunta->pregunta;?> <?php echo ($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_MULTIPLE)?" (Seleccione varias)":""?><br/>
	    			
	    			<?php if($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_UNICA || $pregunta->idTipoPregunta == Pregunta::PREGUNTA_FALSO_VERDADERO):?>
	    				
	    				<?php foreach($pregunta->listOpcionRespuestas as $opcionRespuesta):?>
	    				
	    						<input type='radio' <?= $disabled ?>
	    						 	value='<?= $opcionRespuesta->idOpcionRespuesta ?>' 
	    						 	name='opcionRespuesta[<?= $pregunta->idPregunta?>]' 
	    						 	<?php if(isset($respuestasUsuario[$pregunta->idPregunta])):
	    						 			if($respuestasUsuario[$pregunta->idPregunta] == $opcionRespuesta->idOpcionRespuesta ):
	    						 				echo " checked ";
	    						 			endif;
	    						 		endif;
	    						 	?> />
	    						 	<?= $opcionRespuesta->respuesta ?> <?php //echo $opcionRespuesta->esCorrecta ? ' Ok':' X'?>
	    						<?php if($cuestionarioUsuario->estadoCuestionario == Cuestionario::CUESTIONARIO_CERRADO && isset($respuestasUsuario[$pregunta->idPregunta])):?>
	    							<?php if($opcionRespuesta->esCorrecta && $respuestasUsuario[$pregunta->idPregunta] == $opcionRespuesta->idOpcionRespuesta):?>
	    									<img class="" style="margin:0 auto;"  src='<?php echo $src?>correct.png'/>
	    							<?php elseif($opcionRespuesta->esCorrecta && $respuestasUsuario[$pregunta->idPregunta] != $opcionRespuesta->idOpcionRespuesta):?>
	    									<img class="" style="margin:0 auto;" src='<?php echo $src?>unmarked.png'/>
	    							<?php elseif(!$opcionRespuesta->esCorrecta && $respuestasUsuario[$pregunta->idPregunta] == $opcionRespuesta->idOpcionRespuesta):?>
	    									<img class="" style="margin:0 auto;" src='<?php echo $src?>mistake.png'/>
	    							<?php endif;?>
	    						<?php endif;?>
	    						<br/>
	    				<?php endforeach;?>
	    			<?php elseif($pregunta->idTipoPregunta == Pregunta::PREGUNTA_SELECCION_MULTIPLE):?>
	    				<?php foreach($pregunta->listOpcionRespuestas as $opciones):?>
	    					    					<input type='checkbox'  <?= $disabled ?>
	    						   name='opcionRespuesta[<?= $pregunta->idPregunta?>][<?= $opciones->idOpcionRespuesta?>]'
	    						   <?php if(isset($respuestasUsuario[$pregunta->idPregunta])):
	    						 			if(isset($respuestasUsuario[$pregunta->idPregunta][$opciones->idOpcionRespuesta])):
	    						 				echo " checked ";
	    						 			endif;
	    						 		endif;
	    						 	?> />  
	    						   <?php echo $opciones->respuesta?>
   						   <?php if($cuestionarioUsuario->estadoCuestionario == Cuestionario::CUESTIONARIO_CERRADO && isset($respuestasUsuario[$pregunta->idPregunta])):?>
									 <?php if($opciones->esCorrecta && isset($respuestasUsuario[$pregunta->idPregunta][$opciones->idOpcionRespuesta])):?>
	    									<img class="" style="margin:0 auto;" src='<?php echo $src?>correct.png'/>
	    							<?php elseif($opciones->esCorrecta && !isset($respuestasUsuario[$pregunta->idPregunta][$opciones->idOpcionRespuesta])):?>
	    									<img class="" style="margin:0 auto;" src='<?php echo $src?>unmarked.png'/>
	    							<?php elseif(!$opciones->esCorrecta && isset($respuestasUsuario[$pregunta->idPregunta][$opciones->idOpcionRespuesta])):?>
	    									<img class="" style="margin:0 auto;" src='<?php echo $src?>mistake.png'/>
	    							<?php endif;?>   						   
   						   <?php endif;?>
	    						<br/>
	    				<?php endforeach;?>
	    			<?php endif;?>
	   		<?php else: /*Pregunta de completar*/?>
	   			<?php foreach($pregunta->listPreguntasHijas as $preguntaHija):?>
	   			<?php // echo $value = (isset($preguntaHija->objRespuestaUsuario)? $preguntaHija->objRespuestaUsuario->respuestaTextual:"")?>
	   			<?php $value = ""; $icon = "";
	   				
	   					if(isset($respuestasUsuario[$pregunta->idPregunta])):
		   					if(isset($respuestasUsuario[$pregunta->idPregunta][$preguntaHija->idPregunta])):
		   						$value = $respuestasUsuario[$pregunta->idPregunta][$preguntaHija->idPregunta];
		   						if($preguntaHija->validarRespuesta($value)):
		   							$icon = "<img style='margin:0 auto;' src='".$src."correct.png'/>";
		   						else:
		   							$icon = "<img style='margin:0 auto;' src='".$src."mistake.png'/>";
		   						endif;
		   					endif;
	   					endif;?>
	   				<?php echo $preguntaHija =  str_replace("@pregunta", 
	   						" <input type='text'  $disabled class='input-sm' name='opcionRespuesta[$pregunta->idPregunta][$preguntaHija->idPregunta]' 
	   						value='$value'/> $icon", $preguntaHija->pregunta)?>
	   						
	   			<?php endforeach;?>
	   		<?php endif;?> 			
	    	<?php $i++;?>
	    	<br/>
	    <?php endif;?>
    <?php endforeach;?>
    <?php if($cuestionarioUsuario->estadoCuestionario != Cuestionario::CUESTIONARIO_CERRADO):?>
    <div class="form-group">
    	<?= Html::submitButton('Terminar cuestionario', ['class' => 'btn btn-success', 'name' => 'boton', 'value' => Cuestionario::CUESTIONARIO_INICIADO ]) ?>
    </div>
    <?php endif;?>
    <?php $form = ActiveForm::end(); ?>
</div>

