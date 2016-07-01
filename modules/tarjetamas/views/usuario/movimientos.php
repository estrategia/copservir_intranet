<?php

use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container internal">
    <div class="space-2"></div>
    <div class="space-2"></div>
    <div class="row">
        <div class="col-md-12">
            <?php
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'CEDULA', 'label' => 'Cedula'],
                    ['attribute' => 'NUMEROTARJETA',
                     'label' => "Número de tarjeta"],
                    ['attribute' => 'NOMBRE', 'label' => 'Nombre'],
                    ['attribute' => 'MENSAJE', 'label' => "Mensaje"],
                    ['attribute' => 'PDV','label' => "Codigo punto de venta"],
                    ['attribute' => 'CAJA','label' => "Caja"],
                    ['attribute' => 'FACTURA','label' => "Factura"],
                    ['attribute' => 'FECHA','label' => "Fecha"],
                    ['attribute' => 'TRANSACCION','label' => "Número de transacción"],
                    ['attribute' => 'VALORVENTA','label' => "Valor venta"],
                    ['attribute' => 'VALORDESCUENTO','label' => "Valor Descuentos"],
                    
                ]
            ]);
            ?>

        </div>
    </div>
    <div class="space-2"></div>
    <div class="space-2"></div>
</div>