<?php 
use \yii\helpers\Html;
use kartik\select2\Select2;
use \yii\helpers\ArrayHelper;

$beneficiariosNumeroDocumento = ArrayHelper::map($parentescos, 'IdGrupoFamiliar', 'ApellidosNombres');
?>
<label for="">Beneficiario</label>
<?= Select2::widget([
    'id' => 'id-grupo-familiar',
    'name' => 'id-grupo-familiar',
    'data' => $beneficiariosNumeroDocumento,
    'options' => [
        'placeholder' => 'Seleccione un Beneficiario',
    ],
    'pluginEvents' => [

    ]
]); ?>
