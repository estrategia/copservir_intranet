<?php 
    use yii\helpers\Url;
    use yii\helpers\ArrayHelper;
    $this->registerJsFile("@web/libs/jquery-datatable/js/jquery.dataTables.js", ['depends' => [app\assets\DataTableAsset::className()]]);
    $idEstados = ArrayHelper::map($estados, 'idEstadoSolicitud', 'nombreEstado');
?>

<table id="solicitudes-list" class="table table-hover table-condensed dataTable">
    <thead>
        <tr>
            <th>Contribución</th>
            <th>Beneficiario</th>
            <th>Valor</th>
            <th>Estado</th>
            <th>Fecha de solicitud</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($solicitudes as $key => $solicitud): ?>
            <tr>
                <td><?php echo $solicitud['nombreContribucion']; ?></td>
                <td><?php echo $solicitud['NombreParentesco']; ?></td>
                <td><?php echo $solicitud['valorContribucion']; ?></td>
                <td>
                <?php 
                    echo $idEstados[$solicitud['idEstadoSolicitud']];
                ?>
                </td>
                <td><?php echo $solicitud['fechaSolicitud']; ?></td>
                <td><a href="<?php echo Url::to(['detalle', 'idSolicitudContribucion' => $solicitud['idSolicitudContribucion']]); ?>">Detalle</a></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php $this->registerJs("
  $(document).ready(function() {
    $('#solicitudes-list').dataTable();
  });
"); ?>