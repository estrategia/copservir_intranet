<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\intranet\models\ModuloContenido;
/* @var $this yii\web\View */
/* @var $model app\modules\intranet\models\Documento */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="documento-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($modelForm, 'archivo')->fileInput(); ?>


    <div class="form-group">
        <?= Html::submitButton('cargar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php if (!empty($model->contenido)): ?>
<?php $this->registerJsFile("@web/js/datatable.js", ['depends' => [app\assets\DataTableAsset::className()]]); ?>
    <div class="portal-container" hidden>
        <?= $model->contenido ?>
    </div>
<?php endif; ?>


<?php if ($model->tipo == ModuloContenido::TIPO_DATATABLE_CEDULA): ?>

<?php
  $numeroDocumento = Yii::$app->user->identity->numeroDocumento;
  $this->registerJs("

  $( document ).ready(function() {
    $('.dataTables_filter').css('display','none');
    $('.dataTables_length').css('display','none');
    $('.dataTables_paginate').css('display','none');
    $('.dataTables_info').css('display','none');

    dataTablesGroupSearch2($model->idModulo, $numeroDocumento)
  });
  ");
?>
<?php endif; ?>
