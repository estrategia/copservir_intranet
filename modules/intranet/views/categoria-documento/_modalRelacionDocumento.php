<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
?>
<!-- Modal -->
<div class="modal fade" id="widget-relaciona-documento" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          Relaciona un Documento
        </h4>
      </div>
      <div class="modal-body">


        <?php $form = ActiveForm::begin(['id'=>'formRelacionaCategoria']); ?>

        <?=
        $form->field($model, 'idDocumento')->widget(Select2::classname(), [
          //'model'=> $model,
          //'name' => 'CategoriaDocumentoDetalle[idDocumento]',
          'id'=> 'relacion',
          'data' => $listaDocumentos,
          'options' => ['placeholder' => 'Seleccione', 'onchange' => ' $( "#plantilla-documento" ).remove(); getPlantillaDocumento($(this).val())'],
          'pluginOptions' => [
            'allowClear' => true
          ],
        ]);
        ?>

        <?= $form->field($model, 'idCategoriaDocumento')->hiddenInput(['value'=> $idCategoriaDocumento])->label(false); ?>

        <?php ActiveForm::end(); ?>
        <div id = "contenido-plantilla">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= Html::submitButton('Relacionar', ['class' => 'btn btn-success', 'data-role' => 'guardar-relacion' ]) ?>

      </div>
    </div>
  </div>
</div>
