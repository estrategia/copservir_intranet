<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;

?>
<div class="modal fade" id="widget-contenido" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          <?php
          $modalTitle = '';
          $model->isNewRecord ? $modalTitle = 'Crea un contenido' : $modalTitle = 'Actualiza el contenido';
          echo $modalTitle;
          ?>
        </h4>
      </div>
      <div class="modal-body">
        
        <?php $form = ActiveForm::begin(['id' => 'form-contenido', 'enableClientValidation' => true]); ?>

          <?= $form->field($model, 'idCapitulo')->hiddenInput(['value' => $idCapitulo])->label(false) ?>

          <?= $form->field($model, 'tituloContenido')->textInput() ?>

          <?= $form->field($model, 'descripcionContenido')->textInput() ?>
          
          <?= $form->field($model, 'tiempoRequerido')->textInput() ?>

          <?= $form->field($model, 'idTercero')->widget(Select2::classname(), [
            'data' => $terceros,
            'options' => ['placeholder' => 'Selecciona proveedor ...'],
            'hideSearch' => false,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]); ?>
         
          <?= $form->field($model, 'estadoContenido')->widget(Select2::classname(), [
            'data' => ['1' => 'Activo', '0' => 'Inactivo'],
            'options' => ['placeholder' => 'Selecciona estado ...'],
            'hideSearch' => true,
            'pluginOptions' => [
              'allowClear' => true
            ],
          ]); ?>

        <?php ActiveForm::end(); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-role' => $model->isNewRecord ? 'crear-contenido' : 'actualizar-contenido', $model->isNewRecord ? : 'data-contenido'=> $model->idContenido, 'data-capitulo-id' => $idCapitulo]) ?>
      </div>
    </div>
  </div>
</div>