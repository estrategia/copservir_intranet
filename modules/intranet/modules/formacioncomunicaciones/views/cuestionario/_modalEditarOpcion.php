<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>


<div class="modal fade" id="modal-editar-opciones" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar opcion</h4>
      </div>
      
      <div class="modal-body">
		<?php
	      $form = ActiveForm::begin([
	        'id' => 'form-opciones-editar',
	        'method' => 'POST',
	        'enableClientValidation' => true,
	        'options' => [
	          'enctype' => 'multipart/form-data',
	          'data-pjax' => true
	        ],
	      ]);
	    ?>
        <?php echo $form->field($modelOpcion, 'respuesta')->textInput(['class' => 'form-control']); ?>
		<?= $form->field($modelOpcion, 'esCorrecta')->dropDownList(['0' => 'No', '1' => 'Si']); ?>
		<?php echo $form->field($modelOpcion, 'idOpcionRespuesta')->hiddenInput()->label(false); ?>
      	
      	 <?php ActiveForm::end(); ?>
      	 <br/>
      </div>
      <div class="modal-footer">
      	<?= Html::button(Yii::t('app', 'Guardar' ), ['class' => 'btn btn-primary', 'data-role' => 'actualizar-opcion-respuesta']) ?>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>

     
    </div>
  </div>
</div>