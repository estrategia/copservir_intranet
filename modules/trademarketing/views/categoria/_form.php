<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\trademarketing\models\Categoria;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\Categoria */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="col-md-12 categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?php $model->estado = $model->isNewRecord ? Categoria::ESTADO_ACTIVO : $model->estado;  ?>
    <?= $form->field($model, 'estado')->dropDownList([Categoria::ESTADO_INACTIVO => 'Inactivo', Categoria::ESTADO_ACTIVO => 'Activo']); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar',
              ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
