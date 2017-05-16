<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\modules\formacioncomunicaciones\models\RestriccionesRedencion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="restricciones-redencion-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= 
        $form->field($model, 'numeroDocumento')->widget(Select2::classname(), [
            'options' => ['placeholder' => 'Seleccionar ...'],
             'size' => Select2::MEDIUM,
             'pluginOptions' => [
                 'allowClear' => true,
                 'minimumInputLength' => 3,
                 'language' => [
                     'errorLoading' => new JsExpression("function () { return 'Esperando resultados...'; }"),
                 ],
                 'ajax' => [
                     'url' => Url::to(['restricciones-redencion/list-ajax']),
                     'dataType' => 'json',
                     'data' => new JsExpression('function(params) { return {q:params.term}; }')
                 ],
                 'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                 'templateResult' => new JsExpression('function(data) { return data.text; }'),
                 'templateSelection' => new JsExpression('function (data) { return data.text; }'),
             ],
        ]);
      ?>

    <div class="form-group">
        <?= Html::submitButton('Crear', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
