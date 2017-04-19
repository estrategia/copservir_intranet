<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

?>
<div class="modal fade" id="widget-modulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          <?php
          $modalTitle = '';
          $model->isNewRecord ? $modalTitle = 'Crea un modulo' : $modalTitle = 'Actualiza el modulo';
          echo $modalTitle;
          ?>
        </h4>
      </div>
      <div class="modal-body">

        <?php $form = ActiveForm::begin(['id' => 'form-modulo', 'enableClientValidation' => true]); ?>

        <?= $form->field($model, 'idCurso')->hiddenInput(['value' => $idCurso])->label(false) ?>

        <?= $form->field($model, 'nombreModulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descripcionModulo')->textInput(['maxlength' => true]) ?>
        
        <?= $form->field($model, 'duracionDias')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'estadoModulo')->hiddenInput(['value' => 0])->label(false) ?>

        <?php ActiveForm::end(); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-role' => $model->isNewRecord ? 'crear-modulo' : 'actualizar-modulo', $model->isNewRecord ? : 'data-modulo'=>$model->idModulo]) ?>
      </div>
    </div>
  </div>
</div>