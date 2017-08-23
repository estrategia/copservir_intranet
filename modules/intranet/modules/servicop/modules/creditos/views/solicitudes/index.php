<?php 
    use yii\helpers\Url;
    $this->registerJsFile("@web/libs/jquery-datatable/js/jquery.dataTables.js", ['depends' => [app\assets\DataTableAsset::className()]]);
?>

<table id="solicitudes-list" class="table table-hover table-condensed dataTable">
    <thead>
        <tr>
            <th>Linea de credito</th>
            <th>Estado</th>
            <th>Fecha de solicitud</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($solicitudes as $key => $solicitud): ?>
            <tr>
                <td><?php echo $solicitud['nombreCredito']; ?></td>
                <td>
                <?php 
                    echo Yii::$app->params['servicop']['estados']['solicitudes'][$solicitud['estado']];
                ?>
                </td>
                <td><?php echo $solicitud['fechaCreacion']; ?></td>
                <td><a href="<?php echo Url::to(['detalle', 'idSolicitud' => $solicitud['idSolicitud']]); ?>">Detalle</a></td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
<?php $this->registerJs("
  $(document).ready(function() {
    $('#solicitudes-list').dataTable();
  });
"); ?>