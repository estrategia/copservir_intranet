<?php 
use kartik\select2\Select2;
use kartik\date\DatePicker;

?>
<form action="" id="form-creditos">
<input type="hidden" name="numeroDocumento" value="<?= Yii::$app->user->identity->numeroDocumento ?>">
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <label for="lineadCredito">Línea de Crédito</label>
                <?= Select2::widget([
                    'name' => 'lineaCredito',
                    'data' => $selectLineasCredito,
                    'options' => [
                        'placeholder' => 'Seleccione una línea de crédito',
                    ],
                ]); ?>
            </div>
            <div class="col-md-12">
                <label for="plazo">Plazo</label>
                <input type="text" name="plazo" class="form-control">
            </div>
            <div class="col-md-12">
                <label for="valor">Valor</label>
                <input type="text" name="valor" class="form-control">
            </div>
            <!-- <div class="col-md-12">
                <label for="lineaCredito">Tipo Garantía</label>
                <?php echo Select2::widget([
                    'name' => 'garantia',
                    'data' => [],
                    'options' => [
                        'placeholder' => 'Seleccione una garantía',
                    ],
                ]); ?>
            </div> -->
        </div>
    </div>

    <div class="col-md-6">
        <div class="row" id="widget-info-basica">
            <div class="col-md-12">
                <label for="plazo">Interés Mensual</label>
                <input type="text" name="interesMensual" class="form-control" readonly>
            </div>
            <div class="col-md-12">
                <label for="plazo">Plazo Máximo</label>
                <input type="text" name="plazoMaximo" class="form-control" readonly>
            </div>
            <div class="col-md-12">
                <label for="valor">Cupo Máximo</label>
                <input type="text" name="cupoMaximo" class="form-control" readonly>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12" id="widget-garantias">

    </div>
</div>
<div class="row">
    <div class="col-md-12" id="widget-garantias-combinadas">

    </div>
</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <h4 class="text-center">El valor de las cuotas extraordinarias no puede superar el 40% del valor del prestamo</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12" id="widget-cuotas-extra">

    </div>
</div>
<div class="row">
    <div class="col-md-8 col-md-offset-2" id="forms-cuotas-extra">
        
    </div>
</div>
</form>
<!-- <button data-role="consultar">Consultar</button> -->
<div class="row">
    <div class="col-md-4 col-md-offset-4 text-center">
        <form action="" class="form-inline">
            <div class="form-group">
                <label class="control-label" for="valor-cuota">Valor Cuota</label>
                <input type="text" name="valor-cuota" readonly value="0" class="form-control">
            </div>
        </form>
    </div>
</div>
<br>
<div class="center-text">
    <button class="btn btn-default" data-role="simular-credito">Simular</button>
    <button class="btn btn-primary" data-role="solicitar-credito">Solicitar Credito</button>
</div>