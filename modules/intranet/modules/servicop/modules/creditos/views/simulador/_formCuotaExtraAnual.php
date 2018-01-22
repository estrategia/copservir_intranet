<?php 
    use yii\helpers\Html;
?>
<div id="<?= "form-cuota-" . $tipoCuotaExtra['idTipoCuotaExtra'] ?>">
<h4><?= $tipoCuotaExtra['nombreCuotaExtra'] ?></h4>
<?php foreach ($anios as $key => $fecha): ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Mes</label>
                <input type="text" value="Diciembre" readonly>
                <input type="hidden" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-mes-' . date('Y', strtotime($fecha)) ?>" value="<?= date('m', strtotime($fecha)) ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form group">
                <label for="">Año</label>
                <input type="text" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-anio-' . date('Y', strtotime($fecha)) ?>" value="<?= date('Y', strtotime($fecha)) ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Valor</label>
                <input class="form-control formatear-numero" type="text" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-valor-' . date('Y', strtotime($fecha)) ?>" value="0" data-maximo="<?php echo $maximo ?>" data-role="cuota-extra-valor">
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>