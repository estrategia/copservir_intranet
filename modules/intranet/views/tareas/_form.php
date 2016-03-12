<?php

//use vova07\imperavi\Widget;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;


use yii\jui\DatePicker;
/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Tareas */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="tareas-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= Html::hiddenInput("Tarea[numeroDocumento]", Yii::$app->user->identity->numeroDocumento, []) ?>

    <?= Html::hiddenInput("Tarea[fechaRegistro]", date('YmdHis'), []) ?>

    <?= Html::hiddenInput("Tarea[estadoTarea]", 2, []) ?>

    
        
        <?php /*

         $form->field($model, 'fechaEstimada')->widget(DatePicker::className(),[
            'dateFormat' => 'yyyy-MM-dd',
            'options' => [
            'class' => 'input-sm form-control',
            ]
        ]); 
        */
        ?>

    

    <?php //$form->field($model, 'idPrioridad')->dropDownList($model->listaPrioridad, ['prompt' => 'Seleccione la prioridad' ]);?>

    <?php //Html::hiddenInput("Contenido[idLineaTiempo]", $linea->idLineaTiempo, ["id" => "idLineaTiempo"]); ?>
    <?= $form->field($model, 'fechaEstimada')->textInput([]) ?>
    <?= $form->field($model, 'idPrioridad')->textInput([]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
