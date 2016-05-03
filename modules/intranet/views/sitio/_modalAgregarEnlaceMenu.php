<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Modal -->
<div class="modal fade" id="widget-agregar-opcion-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          Agrega un enlace
        </h4>
      </div>
      <div class="modal-body">

        <?php $form = ActiveForm::begin(['id'=>'formAgregarEnlace']); ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'idMenu')->hiddenInput(['value'=> $idMenu])->label(false); ?>

        <?php ActiveForm::end(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= Html::submitButton('Agregar enlace', ['class' => 'btn btn-success', 'data-role' => 'guardar-enlace' ]) ?>
      </div>
    </div>
  </div>
</div>
