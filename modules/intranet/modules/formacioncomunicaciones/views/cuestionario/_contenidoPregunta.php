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
	    <?= $form->field($model, 'pregunta')->textarea(['rows' => 6, ($model->idTipoPregunta == Pregunta::PREGUNTA_COMPLETAR) ? 'disabled': ''=> ''] ) ?>
	    <?php if($model->idTipoPregunta != Pregunta::PREGUNTA_COMPLETAR):?>
	    
	    <?php echo \vova07\imperavi\Widget::widget([
	        'selector' => '#pregunta-pregunta',
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
	    
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php endif;?>
    </div>

    <?php ActiveForm::end(); ?>

</div>