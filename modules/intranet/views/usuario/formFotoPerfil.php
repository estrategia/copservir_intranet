<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use bupy7\cropbox\Cropbox;

$form = ActiveForm::begin([
            "method" => "post",
            "enableClientValidation" => true,
            "options" => ["enctype" => "multipart/form-data"],
        ]);
?>
<?php

echo $form->field($modelFoto, 'imagenPerfil')->widget(Cropbox::className(), [
    'attributeCropInfo' => 'crop_info',
    'pluginOptions' => [
        'variants' => [[
        'width' => 200,
        'height' => 200,
        'minWidth' => 100,
        'minHeight' => 100,
        'maxWidth' => 450,
        'maxHeight' => 450
            ]],
        ['width' => 300, 'height' => 300]
    ]
]);
?>

<?= $form->field($modelFoto, "imagenFondo")->fileInput(['multiple' => false]) ?>

<?= Html::submitButton('Guardar cambios', ['class' => 'btn btn-success']) ?>
<?php

$form->end();
