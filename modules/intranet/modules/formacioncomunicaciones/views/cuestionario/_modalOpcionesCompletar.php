<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="modal fade" id="modal-opciones-completar" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Opciones pregunta</h4>
      </div>
      
      <div class="modal-body">
		<?php
	      $form = ActiveForm::begin([
	        'id' => 'form-opciones-completar',
	        'method' => 'POST',
	        'enableClientValidation' => true,
	        'options' => [
	          'enctype' => 'multipart/form-data',
	          'data-pjax' => true
	        ],
	      ]);
	    ?>
        <?php echo $form->field($modelOpciones, 'respuesta')->textInput(['class' => 'form-control']); ?>
		<?php echo $form->field($modelOpciones, 'esCorrecta')->hiddenInput(['value' => 1])->label(false); ?>
		<?php echo $form->field($modelOpciones, 'idPregunta')->hiddenInput(['value' => $idPregunta])->label(false); ?>
      	<?= Html::button(Yii::t('app', 'Guardar' ), ['class' => 'btn btn-primary', 'data-role' => 'guardar-respuesta-completar']) ?>
      	 <?php ActiveForm::end(); ?>
      	 <br/>
      	<div id='tabla-opciones'>
      	<?php echo $this->render('_tablaOpcionesCompletar',['opcionesAgregadas' => $opcionesAgregadas])?>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

     
    </div>
  </div>
</div>