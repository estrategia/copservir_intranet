<?php

use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Tareas */
/* @var $form yii\widgets\ActiveForm */
?>
<?php // Html::hiddenInput("Contenido[idLineaTiempo]", $linea->idLineaTiempo, ["id" => "idLineaTiempo"]); ?>
<div class="tareas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= Html::hiddenInput("numeroDocumento", $linea->idLineaTiempo, ["id" => "idLineaTiempo"]) ?>

    <?= Html::hiddenInput("fechaRegistro", $linea->idLineaTiempo, ["id" => "idLineaTiempo"]) ?>

    <?= Html::hiddenInput("estadoTarea", $linea->idLineaTiempo, ["id" => "idLineaTiempo"]) ?>

    <?= $form->field($model, 'fechaEstimada')->textInput() ?>

    <?= $form->field($model, 'prioridad')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
