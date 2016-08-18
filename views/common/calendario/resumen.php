<?php
use yii\helpers\Html;
?>
<?= $this->render("_encabezado_$vista", ['fInicio' => $fInicio, 'fFin' => $fFin]); ?>

<?php if (empty($listEventos)): ?>
    <p>No hay eventos</p>
<?php else: ?>
    <ul>
        <?php foreach ($listEventos as $objEvento): ?>
            <li>
              <?= Html::a($objEvento->tituloEvento, [$objEvento->url], ['style' => 'color:#ffffff; font-size:13px;']) ?>
            </li>
            <?php // $objEvento->descripcionEvento ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
