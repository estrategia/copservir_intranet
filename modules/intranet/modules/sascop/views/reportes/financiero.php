<h1>Reporte Financiero</h1>

<?php $formatter = \Yii::$app->formatter; ?>
<table class="table table-condensed">
    <thead>
    </thead>
    <tbody>
    <?php if (!empty($datosReporte)): ?>
        <tr class="active">
            <td><h3>Garantias</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['garantias'] as $garantia): ?>
            <tr>
                <td><?= $garantia['descripcion'] ?></td>
                <td><?= $formatter->asDecimal($garantia['valor'],2) ?></td>
            </tr>
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Obligaciones</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['obligaciones'] as $obligacion): ?>
            <tr>
                <td><?= $obligacion['descripcion'] ?></td>
                <td><?= $formatter->asDecimal($obligacion['valor'],2) ?></td>
            </tr>
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Ingresos</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['ingresos'] as $ingreso): ?>
            <tr>
                <td><?= $ingreso['descripcion'] ?></td>
                <td><?= $formatter->asDecimal($ingreso['valor'],2) ?></td>
            </tr>
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Egresos</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['egresos'] as $egreso): ?>
            <tr>
                <td><?= $egreso['descripcion'] ?></td>
                <td><?= $formatter->asDecimal($egreso['valor'],2) ?></td>
            </tr>
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Descuentos por prestamos</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['prestamos'] as $prestamo): ?>
            <tr>
                <td><?= $prestamo['descripcion'] ?></td>
                <td><?= $formatter->asDecimal($prestamo['valor'],2) ?></td>
            </tr>
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Nivel de endeudamiento reglamentario</h3></td>
            <td><h3><?= $datosReporte['nivelEndeudamientoR'] ?>%</h3></td>
        </tr>
        <tr class="active">
            <td><h3>Nivel de endeudamiento</h3></td>
            <td><h3><?= $formatter->asDecimal($datosReporte['nivelEndeudamiento'] * 100, 2) ?>%</h3></td>
        </tr>
    <?php else: ?>
        <tr class="active">
            <td colspan="2"><h3 class="text-center">Sin Datos</h3></td>
        </tr>
    <?php endif ?>
    </tbody>
</table>
