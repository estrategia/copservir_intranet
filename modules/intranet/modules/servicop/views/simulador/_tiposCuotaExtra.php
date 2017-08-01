<?php //var_dump($tiposCuotaExtra) ?>

<?php foreach ($tiposCuotaExtra as $key => $tipoCuota): ?>
    <div class="checkbox-inline">
        <label for="<?= $tipoCuota['idTipoCuotaExtra'] ?>" > 
            <?= $tipoCuota['nombreCuotaExtra'] ?> 
            <input style="opacity: 1;" type="checkbox" data-cuota-extra-id="<?= $tipoCuota['idTipoCuotaExtra'] ?>" name="<?= 'cuota-' . $tipoCuota['idTipoCuotaExtra'] ?>">
        </label>
    </div>
<?php endforeach ?>