<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $modelosEspacio array modelos Espacio */
/* @var $modelosPorcentaje array modelos PorcentajeEspaciosPuntoVenta*/

$this->title = 'Asigna los porcentajes a cada espacio por punto de venta ';
// $this->params['breadcrumbs'][] = ['label' => 'Porcentaje Espacios Punto Ventas', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="space-1"></div>
<div class="space-2"></div>
<div class="container">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('/common/errores', []) ?>

    <?= $this->render('_form', [
        'modelosPorcentaje' => $modelosPorcentaje,
        'modelosEspacio' => $modelosEspacio,
    ]) ?>

</div>


<div class="space-1"></div>
<div class="space-2"></div>
