<?php

use yii\grid\GridView;
use yii\helpers\Html;
?>
<div class="container internal">
    <div class="space-2"></div>
    <div class="space-2"></div>
    <div class="row">
        <div class="col-lg-12">
            <?php foreach (Yii::$app->session->getAllFlashes() as $tipo => $mensaje): ?>
                <div role="alert" class="alert alert-<?= $tipo ?> alert-dismissible fade in">
                    <button aria-label="Close" data-dismiss="alert" class="close" type="button"></button>
                    <p><?= $mensaje ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="space-2"></div>
    <?php if ($dataProvider): ?>
        <div class="row">
            <div class="col-md-12">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'NUMEROTARJETA',
                            'label' => "Número de tarjeta"],
                        ['attribute' => 'ESTADOTARJETA', 'label' => "Estado tarjeta"],
                        ['attribute' => 'PORCENTAJE', 'label' => "Porcentaje"],
                        ['attribute' => 'FECHAACTIVACION', 'label' => "Fecha de activación"],
                        ['attribute' => 'FECHAVENCIMIENTO', 'label' => "Fecha de vencimiento"],
                        ['attribute' => 'DESCUENTOSDISPONIBLES', 'label' => "Descuentos Disponibles"],
                        ['attribute' => 'PRIMARIA', 'label' => "Principal"],
                        ['content' => function ($model) {
                                $html = Html::beginForm(['ver'], 'post', ['id' => 'form-ver']);
                                $html.= Html::input('hidden', 'numeroTarjeta', $model['NUMEROTARJETA']);
                                $html.= Html::submitButton('<i class="fa fa-eye"></i>', ['class' => 'btn btn-link', 'title' => 'Ver compras']);
                                $html.= Html::endForm();
                                if ($model['ESTADOTARJETA'] == 'ACTIVA'):
                                    $html.= Html::beginForm(['hacer-primaria'], 'post', ['id' => 'form-primary']);
                                    $html.= Html::input('hidden', 'numeroTarjeta', $model['NUMEROTARJETA']);
                                    $html.= Html::submitButton('<i class="fa fa-key"></i>', ['class' => 'btn btn-link', 'title' => 'Hacer primaria']);
                                    $html.= Html::endForm();

                                    $html.= Html::beginForm(['suspender'], 'post', ['id' => 'form-suspender']);
                                    $html.= Html::input('hidden', 'numeroTarjeta', $model['NUMEROTARJETA']);
                                    $html.= Html::submitButton('<i class="fa fa-power-off"></i>', ['class' => 'btn btn-link', 'title' => 'Bloquear']);
                                    $html.= Html::endForm();


                                    $html.= Html::endForm();
                                endif;

                                return $html;
                            }]
                            ]
                        ]);
                        ?>

                    </div>
                </div>
            <?php endif; ?>
    <div class="space-2"></div>
    <div class="space-2"></div>
</div>
