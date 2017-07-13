<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\select2\Select2;
use yii\web\JsExpression;


$format = <<< SCRIPT
function formatSelect(state) {
  if (!state.id) return state.text; // optgroup
    return '<span style="' + state.element.style.cssText + '">' + state.text + '</span>';
}
SCRIPT;

$this->registerJs($format, \yii\web\View::POS_HEAD);
$escape = new JsExpression("function(m) {return m; }");

?>
<div class="modal fade" id="widget-capitulo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">
          <?php
          $modalTitle = '';
          $model->isNewRecord ? $modalTitle = 'Crea un capítulo' : $modalTitle = 'Actualiza el capítulo';
          echo $modalTitle;
          ?>
        </h4>
      </div>
      <?php \yii\helpers\VarDumper::dump($model->errors,10,true); ?>
      <?php \yii\helpers\VarDumper::dump($idModulo,10,true); ?>
      <div class="modal-body">

        <?php $form = ActiveForm::begin(['id' => 'form-capitulo', 'enableClientValidation' => true]); ?>

        <?= $form->field($model, 'idModulo')->textInput(['value' => $idModulo])->label(false) ?>

        <?= $form->field($model, 'nombreCapitulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'descripcionCapitulo')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'capituloGruposInteres')->widget(Select2::classname(),[
          'data' => $objCapituloGruposInteres->getDatosSelectGruposInteres()['data'],
          'options' => [
            'placeholder' => 'Selecione ...',
            'options' => $objCapituloGruposInteres->getDatosSelectGruposInteres()['options'],
            'multiple' => true,
          ],
          'pluginOptions' => [
            'allowClear' => true,
            'templateResult' => new JsExpression('formatSelect'),
            'templateSelection' => new JsExpression('formatSelect'),
            'escapeMarkup' => $escape,
          ],
          'hideSearch' => false,
          ]);
        ?>

        <?= $form->field($model, 'estadoCapitulo')->widget(Select2::classname(), [
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
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-role' => $model->isNewRecord ? 'crear-capitulo' : 'actualizar-capitulo', $model->isNewRecord ? : 'data-capitulo'=>$model->idCapitulo]) ?>
      </div>
    </div>
  </div>
</div>