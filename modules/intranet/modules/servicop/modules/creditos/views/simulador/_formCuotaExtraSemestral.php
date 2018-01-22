<?php
    use yii\helpers\Html;
?>
<div id="<?= "form-cuota-" . $tipoCuotaExtra['idTipoCuotaExtra'] ?>">
<h4><?= $tipoCuotaExtra['nombreCuotaExtra'] ?></h4>
    
<?php foreach ($anios as $key => $anio): ?>
    <?php if (date('m', strtotime($anio)) == '06'): ?>
        
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes</label>
                    <input type="text" value="Junio" readonly>
                    <input type="hidden" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-mes-' . date('Y', strtotime($anio)) . '-1' ?>" value="<?= date('m', strtotime($anio)) ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form group">
                    <label for="">Año</label>
                    <input type="text" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-anio-' . date('Y', strtotime($anio)) . '-1'?>" value="<?= date('Y', strtotime($anio)) ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Valor</label>
                    <input class="form-control formatear-numero" type="text" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-valor-' . date('Y', strtotime($anio)) . '-1' ?>" value="0" data-maximo="<?php echo $maximo ?>" data-role="cuota-extra-valor">
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Mes</label>
                    <input type="text" value="Diciembre" readonly>
                    <input type="hidden" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-mes-' . date('Y', strtotime($anio)) . '-2' ?>" value="<?= date('m', strtotime($anio)) ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form group">
                    <label for="">Año</label>
                    <input type="text" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-anio-' . date('Y', strtotime($anio)) . '-2'?>" value="<?= date('Y', strtotime($anio)) ?>" readonly>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="">Valor</label>
                    <input class="form-control formatear-numero" type="text" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-valor-' . date('Y', strtotime($anio)) . '-2' ?>" value="0" data-maximo="<?php echo $maximo ?>" data-role="cuota-extra-valor">
                </div>
            </div>
        </div>
    <?php endif ?>
<?php endforeach ?>
</div>
