<?= $this->render("_encabezado_$vista", ['fInicio' => $fInicio, 'fFin' => $fFin]); ?>

<?php if (empty($listEventos)): ?>
    <p>No hay eventos</p>
<?php else: ?>
    <ul>
        <?php foreach ($listEventos as $objEvento): ?>
            <li><?= $objEvento->descripcionEvento ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>