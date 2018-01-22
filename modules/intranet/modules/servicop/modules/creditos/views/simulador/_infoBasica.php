<?php if (!is_null($linea)): ?>
    <div class="col-md-12">
        <label for="plazo">Plazo Máximo (Quincenas)</label>
        <input type="text" name="plazoMaximo" class="form-control" value="<?= $linea['plazoMaximo'] ?>" readonly>
    </div>
    <div class="col-md-12" id="container-cupo-maximo">
        <label for="valor">Monto Máximo</label>
        <input type="text" name="cupoMaximo" class="form-control formatear-numero" value="<?= $cupoMaximo ?>" readonly>
    </div>
    <input type="hidden" name="interesMensual" value="<?= $linea['porcentajeInteres'] ?>" readonly>
<?php endif ?>