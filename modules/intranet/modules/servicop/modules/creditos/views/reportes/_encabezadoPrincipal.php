<?php $traza = $datosEncabezado['traza'];?>
<?php $usuario = $datosEncabezado['usuario'];?>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th>Nombre</th>
            <td>
                <?php echo $usuario['ApellidosNombres'] ?>
            </td>
            <th>Documento</th>
            <td>
                <?php echo $usuario['NumeroDocumento'] ?>
            </td>
            <th>Año</th>
            <td>
                <?php echo date('Y') ?>
            </td>
            <th>Mes</th>
            <td>
                <?php $mes = strtoupper(date('n')); ?>
                <?php $meses = [
                    1 => 'ENERO', 2 => 'FEBRERO', 3 => 'MARZO', 4 => 'ABRIL', 5 => 'MAYO', 6 => 'JUNIO',
                    7 => 'JULIO', 8 => 'AGOSTO', 9 => 'SEPTIEMBRE', 10 => 'OCTUBRE', 11 => 'NOVIEMBRE', 12 => 'DICIEMBRE'
                ] ?>
                <?php echo $meses[$mes] ?>
            </td>
            <th>Día</th>
            <td>
                <?php echo date('d') ?>
            </td>
        </tr>

    </tbody>
</table>