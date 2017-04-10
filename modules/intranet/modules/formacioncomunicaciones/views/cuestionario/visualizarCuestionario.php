<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;
use app\modules\intranet\modules\formacioncomunicaciones\models\Cuestionario;
$src = Yii::$app->homeUrl . 'img/formacioncomunicaciones/';



$this->title = 'Resolver Cuestionario';

$this->params['breadcrumbs'][] = ['label' => 'Mis Cursos', 'url' => ['mis-cursos']];
$this->params['breadcrumbs'][] = ['label' => $model->objCurso->nombreCurso, 'url' => ['/curso/visualizar-curso','id' => $model->idCurso]];
$this->params['breadcrumbs'][] = ['label' => 'Resumen cuestionario', 'url' => ['aplicar-cuestionario','id' => $model->idCuestionario]];
$this->params['breadcrumbs'][] = $this->title;
//$this->params['breadcrumbs'][] = ['label' => 'Cuestionarios', 'url' => ['/intranet/formacioncomunicaciones/cuestionario']];
?>
<style> .cuestionario table, th, td{border:solid 1px; padding: 2px 2px 2px 2px} .cuestionario input[type="checkbox"]{opacity:1}</style>
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
    		<table class='table table-striped table-bordered'>
    			<tr> <td colspan="2">Resumen del cuestionario</td></tr>
    			<tr> <td>Iniciado</td><td><?=  $cuestionarioUsuario->fechaCreacion?></td></tr>
    			<tr> <td>Finalizado</td><td><?=  $cuestionarioUsuario->fechaActualizacion?></td></tr>
    			<tr> <td>Preguntas correctas</td><td><?=  $cuestionarioUsuario->numeroPreguntasRespondidas?></td></tr>
    			<tr> <td>Puntaje</td><td><?=  round($cuestionarioUsuario->porcentajeObtenido,2)?>%/100%</td></tr>
    		</table>
    		<br/>
    		<?php $disabled=" disabled";?>
    <?php endif;?>
    <?php $form = ActiveForm::begin(); ?>
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
	   						value='$value'/> ", $preguntaHija->pregunta)?>
	   						<?php echo $icon?>
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

