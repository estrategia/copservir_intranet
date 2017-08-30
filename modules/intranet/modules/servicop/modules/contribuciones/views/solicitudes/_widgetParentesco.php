<?php 
use \yii\helpers\Html;
use \yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$selectParentesco = ArrayHelper::map($parentescos,'IdParentesco', 'nombreParentesco');
?>
<label for="">Tipo Beneficiario</label>
<?= Select2::widget([
    'id' => 'id-parentesco',
    'name' => 'id-parentesco',
    'data' => $selectParentesco,
    'options' => [
        'placeholder' => 'Seleccione un Tipo de Beneficiario',
    ]
]); ?>


