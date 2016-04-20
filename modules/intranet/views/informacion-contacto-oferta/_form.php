<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\InformacionContactoOferta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="informacion-contacto-oferta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombrePlantilla')->textInput() ?>


    <?= $form->field($model, 'estado')->dropDownList(['0' => 'Inactiva', '1' => 'Activa'],['prompt'=>'Select...']); ?>

    <?= $form->field($model, 'plantillaContactoHtml')->textarea(['rows' => 6]) ?>
    <?php
    echo \vova07\imperavi\Widget::widget([
        'selector' => '#informacioncontactooferta-plantillacontactohtml',
        'settings' => [
            'lang' => 'es',
            'minHeight' => 80,
            'imageManagerJson' => Url::to(['/default/images-get']),
            'plugins' => [
                'imagemanager'
            ]
        ]
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
