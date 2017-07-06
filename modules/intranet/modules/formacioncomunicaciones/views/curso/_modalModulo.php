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

        <?= $form->field($model, 'moduloGruposInteres')->widget(Select2::classname(),[
          'data' => $objModuloGruposInteres->getDatosSelectGruposInteres()['data'],
          'options' => [
            'placeholder' => 'Selecione ...',
            'options' => $objModuloGruposInteres->getDatosSelectGruposInteres()['options'],
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

        <?php ActiveForm::end(); ?>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'data-role' => $model->isNewRecord ? 'crear-modulo' : 'actualizar-modulo', $model->isNewRecord ? : 'data-modulo'=>$model->idModulo]) ?>
      </div>
    </div>
  </div>
</div>