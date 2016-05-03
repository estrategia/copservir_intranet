<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<!-- Modal -->
<div class="modal fade" id="widget-categoria" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          <?php
          $modalTitle = '';
          $model->isNewRecord ? $modalTitle = 'crea una categoria' : $modalTitle = 'actualiza la categoria';
          echo $modalTitle;
          ?>
        </h4>
      </div>
      <div class="modal-body">


        <?php $form = ActiveForm::begin(['id'=>'formCategoria']); ?>
        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

        <?php $model->idCategoriaPadre = $model->isNewRecord ? $categoriaPadre : $model->idCategoriaPadre;  ?>
        <?= $form->field($model, 'idCategoriaPadre')->hiddenInput(['value'=> $model->idCategoriaPadre])->label(false); ?>

        <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
        <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>

        <?= $form->field($model, 'fechaCreacion')->hiddenInput(['value'=> Date("Y-m-d H:i:s")])->label(false); ?>

        <?php ActiveForm::end(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-role' => $model->isNewRecord ? 'guardar-categoria' : 'actualizar-categoria', $model->isNewRecord ? : 'data-categoria'=>$model->idCategoriaDocumento]) ?>

      </div>
    </div>
  </div>
</div>
