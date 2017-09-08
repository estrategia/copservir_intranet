<?php 
    use yii\helpers\Html;
?>
<div id="<?= "form-cuota-" . $tipoCuotaExtra['idTipoCuotaExtra'] ?>">
<h4><?= $tipoCuotaExtra['nombreCuotaExtra'] ?></h4>
<?php foreach ($anios as $key => $anio): ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Mes</label>
                <?php echo Html::dropDownList('cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-mes-' . $anio, '', ['12' => 'Diciembre'], ['prompt'=>'']); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form group">
                <label for="">Año</label>
                <input type="text" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-anio-' . $anio ?>" value="<?= $anio ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Valor</label>
                <input class="form-control formatear-numero" type="text" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-valor-' . $anio ?>" value="0">
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>