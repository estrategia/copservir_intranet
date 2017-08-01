<?php 
    use kartik\select2\Select2;
?>
<div id="<?= "form-cuota-" . $tipoCuotaExtra['idTipoCuotaExtra'] ?>">
<h4><?= $tipoCuotaExtra['nombreCuotaExtra'] ?></h4>
    
<?php foreach ($anios as $key => $anio): ?>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Mes</label>
                <?= Select2::widget([
                    'name' => 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-mes',
                    'data' => ['6' => 'Junio', '12' => 'Diciembre'],
                    'options' => [
                        'class' => 'block',
                        'placeholder' => $tipoCuotaExtra['nombreCuotaExtra'],
                    ],
                ]); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form group">
                <label for="">Año</label>
                <input type="text" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-anio' ?>" value="<?= $anio ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Valor</label>
                <input class="form-control" type="text" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-valor' ?>" value="0">
            </div>
        </div>
    </div>

     <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Mes</label>
                <?= Select2::widget([
                    'name' => 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-mes',
                    'data' => ['6' => 'Junio', '12' => 'Diciembre'],
                    'options' => [
                        'class' => 'block',
                        'placeholder' => $tipoCuotaExtra['nombreCuotaExtra'],
                    ],
                ]); ?>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form group">
                <label for="">Año</label>
                <input type="text" class="form-control" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-anio' ?>" value="<?= $anio ?>" readonly>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Valor</label>
                <input class="form-control" type="text" name="<?= 'cuota-' . $tipoCuotaExtra['idTipoCuotaExtra'] . '-valor' ?>" value="0">
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>
