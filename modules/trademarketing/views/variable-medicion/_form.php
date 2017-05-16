<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use app\modules\trademarketing\models\VariableMedicion;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\VariableMedicion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12 variable-medicion-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? VariableMedicion::ESTADO_ACTIVO : $model->estado;  ?>
    <?=
      $form->field($model, 'estado')->dropDownList([VariableMedicion::ESTADO_INACTIVO => 'Inactivo',
        VariableMedicion::ESTADO_ACTIVO => 'Activo']);
    ?>

    <?=
      $form->field($model, 'idCategoria')->widget(Select2::classname(), [
        'data' => $model->getMapListaCategorias(),
        'options' => ['placeholder' => 'Seleccione la una categoria']
      ]);
    ?>

    <?php $model->calificaUnidadNegocio = $model->isNewRecord ? '1' : $model->calificaUnidadNegocio;  ?>
    <?=
      $form->field($model, 'calificaUnidadNegocio')->dropDownList([VariableMedicion::CALIFICA_UNIDAD => 'Si', VariableMedicion::NO_CALIFICA_UNIDAD => 'No']);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',
              ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
