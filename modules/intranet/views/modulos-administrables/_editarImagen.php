<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="modal fade" tabindex="-1" role="dialog" id="modal-editar-imagen">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <div>
           <?php $form = ActiveForm::begin(['action' => ['modulos-administrables/guardar-cambios-imagen'], 'method' => 'post', 'id' => 'form-editar-imagen',  'enableClientValidation' => true,]); ?>

          <?= $form->field($model, 'idImagenModuloGaleria')->hiddenInput()->label(false) ?>

          <?= $form->field($model, 'idModulo')->hiddenInput()->label(false) ?>

          <?= $form->field($model, 'nombreImagen')->textInput(['maxlength' => true]) ?>

          <?= $form->field($model, 'rutaImagen')->hiddenInput()->label(false) ?>

          <?= $form->field($model, 'orden')->textInput() ?>
<!-- 
          <div class="form-group">
              <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
          </div> -->

          <?php ActiveForm::end(); ?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" data-role="guardar-cambios-imagen">Guardar cambios</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->