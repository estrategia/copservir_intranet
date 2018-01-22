<?php 
    use kartik\select2\Select2;
    use yii\helpers\Url;
?>
<h3>Reglamento de la sección de crédito de la cooperativa multiactiva de servicios solidarios Copservir  </h3>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <!-- <label for="tipoLineaCredito">Tipos de Línea de Crédito</label> -->
                <?php Select2::widget([
                    'name' => 'tipo',
                    'id' => 'tipo-linea-credito-detalle',
                    'data' => $selectTiposLineaCredito,
                    'options' => [
                        'placeholder' => 'Seleccione un tipo de línea de crédito',
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-12" id="select-detalle-linea">
        
    </div>
    <div class="col-md-12">
        <br>
        <pre style="background-color: inherit !important;" id="widget-detalle-linea">

        </pre>
    </div>
</div>
<div class="center-text">
    <a href="<?= Url::toRoute('simulador/index') ?>" class="btn btn-primary">Simulador de creditos</a>
    <a href="<?= Url::toRoute('reportes/financiero') ?>" class="btn btn-primary">Reporte Financiero del Asociado</a>
</div>