</table>
<h3 class="text-center">Línea de crédito</h3>
<h4 class="text-center">
    <?= $solicitud['nombreCredito'] ?>
</h4>
<div class="row">
    <div class="col-md-3">
        <h4>
            Plazo máximo:
            <?= $solicitud['plazoMaximo'] ?>
        </h4>
    </div>
    <div class="col-md-3">
        <h4>
            Cupo máximo:
            <?= $solicitud['valorCuota'] ?>
        </h4>
    </div>
    <div class="col-md-3">
        <h4>
            Interes:
            <?= $solicitud['porcentajeIntereses'] ?> %
        </h4>
    </div>
    <div class="col-md-3">
        <h4>
            Fecha:
            <?= $solicitud['fechaCreacion'] ?>
        </h4>
    </div>
</div>
<div class="row">
    <h4>Observaciones</h4>
    <?php foreach ($relaciones['observaciones'] as $key => $observacion): ?>
        <span>
            <?php echo $observacion['fechaRegistro'] ?>
            <?php echo $observacion['observacion'] ?>
        </span><br>
    <?php endforeach ?>
</div>
<div class="row">
    <h4>Traza</h4>
    <?php foreach ($relaciones['traza'] as $key => $traza): ?>
        <span>
            <?php echo $traza['fechaRegistro'] ?>
            <?php 
                $estado = '';
                switch ($traza['estado']) {
                    case 1:
                        $estado = 'En proceso';
                        break;
                    case 2:
                        $estado = 'Radicado';
                        break;
                    case 3:
                        $estado = 'Aprobado';
                        break;
                    case 4:
                        $estado = 'Rechazado';
                        break;
                    case 5:
                        $estado = 'Documentación pendiente';
                        break;
                }
                echo $estado;
            ?>
        </span>
        <br>
    <?php endforeach ?>
</div>
<div class="row">
    <form enctype="multipart/form-data" method="post" name="fileinfo">
      <label>File to stash:</label>
      <input type="file" name="file"/>
      <input type="submit" class="subir-documento" value="Stash the file!" />
    </form>
</div>