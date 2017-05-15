<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelosEspacio array modelos Espacio */
/* @var $modelosPorcentaje array modelos PorcentajeEspaciosPuntoVenta*/

$this->title = 'Asigna los porcentajes a cada espacio por punto de venta ';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'TradeMarketing-%Espacio PDV'), 'url' => ['/trademarketing/porcentaje-espacios-punto-venta/seleccion-punto-venta']];
$this->params['breadcrumbs'][] = "Asignar";
?>
<div class="">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/common/errores', []) ?>

    <?= $this->render('_form', [
        'modelosPorcentaje' => $modelosPorcentaje,
        'modelosEspacio' => $modelosEspacio,
    ]) ?>

</div>
