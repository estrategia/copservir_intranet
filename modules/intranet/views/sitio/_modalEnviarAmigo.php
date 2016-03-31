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
        <?php
            $url = \yii\helpers\Url::to(['usuario/buscar-amigos']);
            $initScript = <<< SCRIPT
function (element, callback) {
    var id=$(element).val();
    if (id !== "") {
        $.ajax("{$url}?id=" + id, {
            dataType: "json"
        }).done(function(data) { callback(data.results);});
    }
}
SCRIPT;

            echo Select2::widget([
                  'name' => '',
                  //'data' => ['jhon','pepito'], //aca vendria el resultado de la consulta de todos los usuarios
                  'size' => Select2::MEDIUM,
                  'showToggleAll' => false,
                  'changeOnReset' => false,
                  'options' => ['class'=>'select2-container select2-container-multi','placeholder' => 'buscar...', 'multiple' => true],
                  'pluginOptions' => [
                    'allowClear' => true,
                    //'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                    'minimumInputLength' => 1,

                    'ajax' => [
                        'url' => $url,
                        'dataType' => 'json',
                        'data' => new JsExpression('function(params) { return {search:params.term, page: params.page}; }'),
                        'results' => new JsExpression('function(data,page) { return {results:data.results}; }'),
                        //'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),

                    ],


                    //'templateResult' => new JsExpression('function(usuario) { return usuario.text; }'),
                    //'templateSelection' => new JsExpression('function (usuario) { return usuario.alias; }'),
                    'initSelection' => new JsExpression($initScript)

                  ],

            ])
        ?>

        <?php Html::endForm()     ?>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-role='enviar-amigos'>enviar</button>
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" data-role='inactiva-popup' data-contenido="<?php /*$query['idContenidoEmergente']*/ ?>" class="btn btn-primary">ocultar</button>-->
      </div>
    </div>
  </div>
</div>
