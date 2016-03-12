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

    <?= Html::hiddenInput("numeroDocumento", Yii::$app->user->identity->numeroDocumento, []) ?>

    <?= Html::hiddenInput("fechaRegistro", date('YmdHis'), []) ?>

    <?= Html::hiddenInput("estadoTarea", 2, []) ?>

    
        
         <?= $form->field($model, 'fechaEstimada')->widget(DatePicker::className(),[
                'dateFormat' => 'yyyy-MM-dd',
                'options' => [
                   'class' => 'input-group date',
                   'data-provide'=> "datepicker",
                ]
                ]); 
                   ?>

    

    <?= $form->field($model, 'idPrioridad')->dropDownList($model->listaPrioridad, ['prompt' => 'Seleccione la prioridad' ]);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
