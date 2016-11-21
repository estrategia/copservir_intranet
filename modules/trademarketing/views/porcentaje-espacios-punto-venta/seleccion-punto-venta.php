<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\modules\trademarketing\models\PorcentajeEspaciosPuntoVenta */

$this->title = 'Selecciona un punto de venta';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing - % Espacio PDV')];

?>

<div class="">

    <?php $form = ActiveForm::begin(); ?>

    <?=
      $form->field($model, 'idComercial')->widget(Select2::classname(), [
        'data' => $model->getMapListaPuntosVenta(),
        'options' => ['placeholder' => 'Seleccione un punto de venta']
      ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Seleccionar' , ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
