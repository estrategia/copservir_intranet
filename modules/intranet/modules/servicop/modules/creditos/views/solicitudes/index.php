<?php 
    use yii\helpers\Url;
    $this->registerJsFile("@web/libs/jquery-datatable/js/jquery.dataTables.js", ['depends' => [app\assets\DataTableAsset::className()]]);
?>

<h3>Historial de solicitudes de crédito</h3>
<h4>Señor asociado, en este espacio usted encuentra la información general de las solicitudes de cŕedito que actualmente está tramitando, si requiere mayor información y adicionar documentos, haga click en "Detalles"</h4>
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
    $('#solicitudes-list').dataTable({
        'order': [[ 3, 'desc' ]],
        'language': {
            'sProcessing':     'Procesando...',
            'sLengthMenu':     'Mostrar _MENU_ registros',
            'sZeroRecords':    'No se encontraron resultados',
            'sEmptyTable':     'Ningún dato disponible en esta tabla',
            'sInfo':           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
            'sInfoEmpty':      'Mostrando registros del 0 al 0 de un total de 0 registros',
            'sInfoFiltered':   '(filtrado de un total de _MAX_ registros)',
            'sInfoPostFix':    '',
            'sSearch':         'Buscar:',
            'sUrl':            '',
            'sInfoThousands':  ',',
            'sLoadingRecords': 'Cargando...',
            'oPaginate': {
                'sFirst':    'Primero',
                'sLast':     'Último',
                'sNext':     'Siguiente',
                'sPrevious': 'Anterior'
    },
            'oAria': {
                'sSortAscending':  ': Activar para ordenar la columna de manera ascendente',
                'sSortDescending': ': Activar para ordenar la columna de manera descendente'
    }
            
        }
    });
  });
"); ?>