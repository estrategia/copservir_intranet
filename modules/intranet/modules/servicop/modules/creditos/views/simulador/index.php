<?php 
use kartik\select2\Select2;
use kartik\date\DatePicker;
use yii\helpers\Url;
?>
<h2>Simulador de Créditos</h2>
<p>
    “Señor Asociado, este
    simulador le facilita el cálculo de su cuota según el monto del crédito en la modalidad que
    usted lo necesita, diligencie la información solicitada y si lo requiere, modifíquela las
    veces que sea necesario hasta que se ajuste a su expectativa, si está seguro, confirme la
    solicitud, si requiere información presione el botón “Reglamento de Créditos”, o si tiene
    alguna inquietud escribanos al correo Servicoop@copservir.com”.
    La simulación del crédito es un paso obligatorio para avanzar con la solicitud de crédito.
</p>
<form action="" id="form-creditos">
<input type="hidden" name="numeroDocumento" value="<?= Yii::$app->user->identity->numeroDocumento ?>">
<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <label for="tipoLineaCredito">Línea de Crédito</label>
                <?= Select2::widget([
                    'name' => 'tipoLineaCredito',
                    'data' => $selectTiposLineaCredito,
                    'options' => [
                        'placeholder' => 'Seleccione una línea de crédito',
                    ],
                    'pluginEvents' => [
                        "select2:select" => "function() { $('#valor-cuota').val(0).trigger('change');}"
                    ]
                ]); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6" id="select-linea-credito">
        <label for="lineadCredito">Seleccione la Modalidad de crédito a utilizar <small style="color: crimson">(Obligatorio)</small></label>
        <?= Select2::widget([
            'id' => 'selector-lineas-credito',
            'name' => 'lineaCredito',
            'data' => [],
            'options' => [
                'placeholder' => 'Seleccione una línea de crédito',
            ],
            'pluginEvents' => [
                "select2:select" => "function() { $('#valor-cuota').val(0).trigger('change'); }"
            ]
        ]); ?>
    </div>
    <div class="col-md-12" id="widget-descripcion">
        
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12">
                <label for="plazo">Plazo (Quincenas)</label>
                <input type="text" name="plazo" class="formatear-numero">
                <button class="btn btn-primary" data-campo="plazo" data-role="campo-siguiente">Siguiente</button>
            </div>
            <div class="col-md-10">
                <label for="valor">Valor a solicitar</label>
                <input type="text" name="valor" class="formatear-numero">
                <button class="btn btn-primary" data-campo="valor" data-role="campo-siguiente">Siguiente</button>
            </div>
        </div>
    </div>
     
    <div class="col-md-6">
        <div class="row" id="widget-info-basica">
            <div class="col-md-12">
                <label for="plazo">Plazo Máximo (Quincenas)</label>
                <input type="text" name="plazoMaximo" class="form-control" readonly>
            </div>
            <div class="col-md-12">
                <label for="valor">Monto Máximo</label>
                <input type="text" name="cupoMaximo" class="form-control formatear-numero" readonly>
            </div>
        <input type="hidden" name="interesMensual" value="0" readonly>

        </div>
    </div>
</div>
<div id="garantias">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h4 class="text-center">Garantias</h4>
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
        <div class="col-md-6 col-md-offset-3" id="widget-parametros">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="widget-codeudor" style="display: none;">
            <?php echo $this->render('_selectCodeudor'); ?>
        </div>
    </div>
</div>
<div id="cuotas">
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
</div>
</form>
<!-- <button data-role="consultar">Consultar</button> -->
<div class="row">
    <div class="col-md-4 col-md-offset-4 text-center">
        <form action="" class="form-inline">
            <div class="form-group">
                <label class="control-label" for="valor-cuota">Valor Cuota Quincenal</label>
                <input type="text" id="valor-cuota" name="valor-cuota" readonly value="0" class="form-control formatear-numero">
            </div>
        </form>
        <form action="" class="form-inline">
            <div class="form-group">
                <label class="control-label" for="valor-cuota">Nivel de Endeudamiento</label>
                <input type="text" id="nivel-endeudamiento-cuota" name="nivel-endeudamiento-cuota" readonly value="0" class="form-control">
            </div>
        </form>
    </div>
</div>
<br>
<div class="center-text">
    <button class="btn btn-default" disabled data-role="simular-credito">Simular</button>
    <button class="btn btn-default" disabled data-role="solicitar-credito">Solicitar Credito</button>
    <a href="<?= Url::toRoute('reportes/financiero') ?>" class="btn btn-primary">Reporte financiero del asociado</a>
    <a href="<?= Url::toRoute('default/index') ?>" class="btn btn-primary">Reglamento de cŕeditos</a>
    <button class="btn btn-primary" data-role="limpiar-formulario">Limpiar formulario</button>
</div>
<br>