<?php
use kartik\select2\Select2;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use yii\helpers\Html;

?>

<!-- Modal -->
<div class="modal fade" id="widget-enviarAmigo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Envia a un amigo</h4>
      </div>

      <div class="modal-body">
        <p>
          Selecciona a los amigos que quieres enviarle esta publicación
        </p>
        <!-- div con formulario para realizar la busqueda de los amigos y pega a la lista los amigos seleccionados -->
        <?= Html::beginForm(['contenido/enviar-amigo'], 'post', ['id'=> 'formEnviarAmigo']); ?>
        <div id="inputUsuarios" class="form-group">
        <?php
          echo Select2::widget([
            'name' => 'enviaAmigo',
            'data' => \yii\helpers\ArrayHelper::map($listaUsuarios, 'numeroDocumento', 'alias'),
            'size' => Select2::MEDIUM,
            'showToggleAll' => false,
            'changeOnReset' => false,
            'options' => ['class'=>'select2-container select2-container-multi', 'id' => 'enviaAmigo','placeholder' => 'buscar...', 'multiple' => true],
            'pluginOptions' => [
              'allowClear' => true,
              'escapeMarkup' => new JsExpression("function(m) { return m; }")
            ],

          ])
          ?>
        </div>
        <?=  Html::hiddenInput('clasificado',$modelClasificado->idContenido, []);  ?>
        <?= Html::endForm()     ?>

        <div class="error"></div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-role='enviar-amigos'>enviar</button>
      </div>
    </div>
  </div>
</div>
