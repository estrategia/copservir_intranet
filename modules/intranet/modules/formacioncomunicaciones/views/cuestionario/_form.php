<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
?>

<div class="cuestionario-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'tituloCuestionario')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcionCuestionario')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'porcentajeMinimo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numeroPreguntas')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'numeroIntentos')->textInput(['maxlength' => true]) ?>
    <?php
    echo \vova07\imperavi\Widget::widget([
        'selector' => '#cuestionario-descripcioncuestionario',
        'settings' => [
            'replaceDivs' => false,
            'lang' => 'es',
            'minHeight' => 80,
            'imageUpload' => Url::toRoute('cuestionario/cargar-imagen'),
            'fileUpload' => Url::toRoute('cuestionario/cargar-archivo'),
            'plugins' => [
                'imagemanager',
            ],
            'fileManagerJson' => Url::to(['sitio/files-get']),
        ]
    ]);
    ?>

    <?php $model->estado = $model->isNewRecord ? 1 : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>
    <?= $form->field($model, 'idContenido')->dropDownList(['0' => 'Inactivo', '1' => 'Activo']); ?>
   
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>