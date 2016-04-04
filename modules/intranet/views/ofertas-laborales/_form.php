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


    <?= $form->field($model, 'idOfertaLaboral')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>


    <?= $form->field($model, 'cargo')->hiddenInput(['value'=> ' '])->label(false); ?>

    <?php //$form->field($model, 'idContenidoDestino')->textInput(['maxlength' => true]) ?>

    <?= Select2::widget([
        'name' => 'OfertasLaborales[idCiudad][]',
        'id' => "grupo_",
        'data' => $model->listaCiudad,
        'options' => ['placeholder' => 'Seleccione la ciudad']
    ]);
    ?>
    <br>
    <?php
     echo $form->field($model, 'fechaPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'y-m-d'
        ]
      ]);
    ?>


    <?php
     echo $form->field($model, 'fechaCierre')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'y-m-d h:i:s'
        ]
      ]);
    ?>

    <?= $form->field($model, 'idUsuarioPublicacion')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>


    <?php
     echo $form->field($model, 'fechaInicioPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'y-m-d h:i:s'
        ]
      ]);
    ?>


    <?php
     echo $form->field($model, 'fechaFinPublicacion')->widget(DatePicker::className(),[
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
        'class' => 'input-sm form-control',
        'placeholder' => 'y-m-d h:i:s'
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


    <?= Select2::widget([
        'name' => 'OfertasLaborales[idArea][]',
        'id' => "grupo2_",
        'data' => $model->listaArea,
        'options' => ['placeholder' => 'Seleccione el area']
    ]);
    ?>
    <br>
    <?= $form->field($model, 'descripcionContactoOferta')->textarea(['rows' => 6]) ?>


    <?= $form->field($model, 'idInformacionContacto')->hiddenInput(['value'=> Yii::$app->user->identity->numeroDocumento])->label(false); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
