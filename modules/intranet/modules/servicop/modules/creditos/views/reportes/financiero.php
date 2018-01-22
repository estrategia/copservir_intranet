<?php 
use yii\helpers\Url;
?>
<h1>Reporte Financiero del Asociado</h1>
<h4> “Señor Asociado, la información que se presenta en este Reporte atiende lo indicado en el Reglamento de Créditos de la Cooperativa Copservir Ltda.”</h4>
<?php echo $this->render('_encabezadoPrincipal', ['datosEncabezado' => $datosReporte['encabezado']]) ?>
<?php $formatter = \Yii::$app->formatter; ?>
<table class="table table-condensed">
    <thead>
    </thead>
    <tbody>
    <?php if (!empty($datosReporte['reporte'])): ?>
        <tr class="active">
            <td><h3>Garantias</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['reporte']['garantias'] as $key => $garantia): ?>
            <?php if (sizeof($datosReporte['reporte']['garantias']) -1 == $key): ?>
                <tr style="background-color: lightgreen;">
                    <td><?= $garantia['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($garantia['valor'],0) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $garantia['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($garantia['valor'],0) ?></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Obligaciones</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['reporte']['obligaciones'] as $key => $obligacion): ?>
            <?php if (sizeof($datosReporte['reporte']['obligaciones']) -1 == $key): ?>
                <tr style="background-color: lightpink;">
                    <td><?= $obligacion['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($obligacion['valor'],0) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $obligacion['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($obligacion['valor'],0) ?></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
    </tbody>
</table>
<table class="table table-condensed">
    <body>
        <tr class="active">
            <td><h3>Ingresos</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['reporte']['ingresos'] as $key => $ingreso): ?>
            <?php if (sizeof($datosReporte['reporte']['ingresos']) -1 == $key): ?>
                <tr style="background-color: lightgreen;">
                    <td><?= $ingreso['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($ingreso['valor'],0) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $ingreso['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($ingreso['valor'],0) ?></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Egresos</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['reporte']['egresos'] as $key => $egreso): ?>
            <?php if (sizeof($datosReporte['reporte']['egresos']) -1 == $key): ?>
                <tr style="background-color: lightpink;">
                    <td><?= $egreso['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($egreso['valor'],0) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $egreso['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($egreso['valor'],0) ?></td>
                </tr>
            <?php endif ?>
            
        <?php endforeach ?>
        <tr class="active">
            <td><h3>Descuentos por prestamos</h3></td>
            <td></td>
        </tr>
        <?php foreach ($datosReporte['reporte']['prestamos'] as $key => $prestamo): ?>
            <?php if (sizeof($datosReporte['reporte']['prestamos']) -1 == $key): ?>
                <tr style="background-color: lightpink;">
                    <td><?= $prestamo['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($prestamo['valor'],0) ?></td>
                </tr>
            <?php else: ?>
                <tr>
                    <td><?= $prestamo['descripcion'] ?></td>
                    <td align="right"><?= $formatter->asDecimal($prestamo['valor'],0) ?></td>
                </tr>
            <?php endif ?>
        <?php endforeach ?>
         <tr class="active">
            <?php 
                $totalEgresos = end($datosReporte['reporte']['egresos']);
                $totalPrestamos = end($datosReporte['reporte']['prestamos']);
                $totalIngresos = end($datosReporte['reporte']['ingresos']);
             ?>
            <td>TOTAL EGRESOS MÁS DESCUENTOS POR PRÉSTAMOS</td>
            <td align="right"><?= $formatter->asDecimal($totalEgresos['valor'] + $totalPrestamos['valor'],0)  ?></td>
        </tr>
        <tr class="active">
            <td>DIFERENCIA ENTRE TOTAL INGRESOS MENOS TOTAL EGRESOS MÁS DESCUENTOS POR PRESTAMOS</td>
            <td align="right"><?= $formatter->asDecimal($totalIngresos['valor'] - $totalEgresos['valor'] + $totalPrestamos['valor'],0)  ?></td>
        </tr>
        <tr class="active">
            <td>NIVEL DE ENDEUDAMIENTO MÁXIMO PERMITIDO POR EL REGLAMENTO</td>
            <td align="right"><?= $datosReporte['reporte']['nivelEndeudamientoR'] ?>%</td>
        </tr>
        <tr class="active">
            <td>NIVEL DE ENDEUDAMIENTO</td>
            <td align="right"><?= $formatter->asDecimal($datosReporte['reporte']['nivelEndeudamiento'] * 100, 0) ?>%</td>
        </tr>
    <?php else: ?>
        <tr class="active">
            <td colspan="2"><h3 class="text-center">Sin Datos</h3></td>
        </tr>
    <?php endif ?>
    </tbody>
</table>
<div class="center-text">
    <a href="<?= Url::toRoute('simulador/index') ?>" class="btn btn-primary">Simulador de creditos</a>
    <a href="<?= Url::toRoute('default/index') ?>" class="btn btn-primary">Reglamento de creditos</a>
</div>