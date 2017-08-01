<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use app\modules\intranet\modules\formacioncomunicaciones\models\Pregunta;
?>

<div class="cuestionario-form">
    
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="form-group">
        <?= $form->field($model, 'pregunta')->textarea(['rows' => 6] ) ?>
        <?php if($model->idTipoPregunta != Pregunta::PREGUNTA_COMPLETAR):?>
        
	
	    
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif;?>
    </div>

    <?php ActiveForm::end(); ?>

</div>