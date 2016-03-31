<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\OfertasLaborales */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ofertas-laborales-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php /*$form->field($model, 'idOfertaLaboral')->textInput(['maxlength' => true])*/ ?>
    <?= $form->field($model, 'idOfertaLaboral')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

    <?php /*$form->field($model, 'cargo')->textInput(['maxlength' => true]) */?>
    <?= $form->field($model, 'cargo')->hiddenInput(['value'=> ' '])->label(false); ?>

    <?= $form->field($model, 'idContenidoDestino')->textInput(['maxlength' => true]) ?>

    <?php /* $form->field($model, 'idCiudad')->textInput(['maxlength' => true]) */?>

    <?= Select2::widget([
        'name' => 'OfertasLaborales[idCiudad][]',
        'id' => "grupo_",
        'data' => $model->listaCiudad,
        'options' => ['placeholder' => 'Seleccione la ciudad']
    ]);
    ?>
    <br>
    <?php /*$form->field($model, 'fechaPublicacion')->textInput()*/ ?>
    <?php
     echo $form->field($model, 'fechaPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        ]
      ]);
    ?>

    <?php /*$form->field($model, 'fechaCierre')->textInput() */?>
    <?php

     echo $form->field($model, 'fechaCierre')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        ]
      ]);
    ?>

    <?php /*$form->field($model, 'idUsuarioPublicacion')->textInput(['maxlength' => true])*/ ?>
    <?= $form->field($model, 'idUsuarioPublicacion')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

    <?php /*$form->field($model, 'fechaInicioPublicacion')->textInput()*/ ?>
    <?php

     echo $form->field($model, 'fechaInicioPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        ]
      ]);
    ?>

    <?php /*$form->field($model, 'fechaFinPublicacion')->textInput()*/ ?>
    <?php

     echo $form->field($model, 'fechaFinPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        ]
      ]);
    ?>

    <?= $form->field($model, 'tituloOferta')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'urlElEmpleo')->textInput(['maxlength' => true]) ?>

    <?php /*$form->field($model, 'idCargo')->textInput()*/ ?>
    <?php /*$form->field($model, 'idCargo')->dropDownList($model->listaCargo, ['prompt' => 'Seleccione el cargo' ]);*/?>
    <?= Select2::widget([
        'name' => 'OfertasLaborales[idCargo][]',
        'id' => "grupo1_",
        'data' => $model->listaCargo,
        'options' => ['placeholder' => 'Seleccione el cargo']
    ]);
    ?>
    <br>
    <?php /*$form->field($model, 'idArea')->textInput() */ ?>
    <?php  /*$form->field($model, 'idArea')->dropDownList($model->listaArea, ['prompt' => 'Seleccione el area' ]);*/ ?>

    <?= Select2::widget([
        'name' => 'OfertasLaborales[idArea][]',
        'id' => "grupo2_",
        'data' => $model->listaArea,
        'options' => ['placeholder' => 'Seleccione el area']
    ]);
    ?>
    <br>
    <?= $form->field($model, 'descripcionContactoOferta')->textarea(['rows' => 6]) ?>

    <?php /*$form->field($model, 'idInformacionContacto')->textInput(['maxlength' => true]) */?>
    <?= $form->field($model, 'idInformacionContacto')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
