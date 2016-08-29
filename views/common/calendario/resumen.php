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
                <?php if(empty($objEvento->url)): ?>
                    <?= $objEvento->tituloEvento ?>
                <?php else: ?>
                    <?= Html::a($objEvento->tituloEvento, [$objEvento->url], ['style' => 'color:#ffffff; font-size:13px;']) ?>
                <?php endif;?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
