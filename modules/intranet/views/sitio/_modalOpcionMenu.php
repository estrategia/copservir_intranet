<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Modal -->
<div class="modal fade" id="widget-opcion-menu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          <?php
            $modalTitle = '';
            $model->isNewRecord ? $modalTitle = 'crea una opcion al menu corporativo' : $modalTitle = 'actualiza la opcion del menu corporativo';
            echo $modalTitle;
          ?>
        </h4>
      </div>
      <div class="modal-body">

          <?php $form = ActiveForm::begin(['id'=>'formMenu']); ?>
                <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

                <?php $model->idPadre = $model->isNewRecord ? $idPadre : $model->idPadre;  ?>
                <?= $form->field($model, 'idPadre')->hiddenInput(['value'=> $model->idPadre])->label(false); ?>

                <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
                <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

          <?php ActiveForm::end(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-role' => $model->isNewRecord ? 'guardar-opcion-menu' : 'actualizar-opcion-menu', $model->isNewRecord ? : 'data-opcion'=>$model->idMenu]) ?>
      </div>
    </div>
  </div>
</div>
