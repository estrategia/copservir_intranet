<?php $traza = $datosEncabezado['traza'];?>
<?php $usuario = $datosEncabezado['usuario'];?>
<table class="table table-bordered">
    <tbody>
        <tr>
            <th>Año</th>
            <td>
                <?php echo $traza['anio'] ?>
            </td>
            <th>Mes</th>
            <td>
                <?php echo $traza['mes'] ?>
            </td>
            <th>Quincena</th>
            <td>
                <?php echo $traza['quincena'] ?>
            </td>
        </tr>

    </tbody>
</table>