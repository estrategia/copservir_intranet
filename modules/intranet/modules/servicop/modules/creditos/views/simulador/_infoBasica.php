<?php if (!is_null($linea)): ?>
    
    <div class="col-md-12">
        <label for="plazo">Interés Mensual</label>
        <input type="text" name="interesMensual" class="form-control" value="<?= $linea['porcentajeInteres'] ?>" readonly>
    </div>
    <div class="col-md-12">
        <label for="plazo">Plazo Máximo (Quincenas)</label>
        <input type="text" name="plazoMaximo" class="form-control" value="<?= $linea['plazoMaximo'] ?>" readonly>
    </div>
    <div class="col-md-12">
        <label for="valor">Cupo Máximo</label>
        <input type="text" name="cupoMaximo" class="form-control" value="0" readonly>
    </div>

<?php endif ?>