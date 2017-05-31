<h1>Cuotas Fondo Mutuo</h1>

<?php $formatter = \Yii::$app->formatter; ?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Código de Concepto</th>
            <th>Descripción</th>
            <th>Valor</th>
        </tr>
    </thead>
    <tbody>
        <?php if (sizeof($datos) == 0): ?>
        <tr>
            <td colspan="3">
                <h3 class="text-center">Sin datos</h3>
            </td>
        </tr>
        <?php endif ?>
        <?php foreach ($datos as $key => $dato): ?>
            <tr>
                <td>
                    <?= $dato['codigoConcepto'] ?>
                </td>
                <td>
                    <?= $formatter->asDecimal($dato['valor'] ,2)?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>