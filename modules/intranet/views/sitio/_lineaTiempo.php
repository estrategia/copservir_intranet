<?php

use yii\helpers\Html;
?>

<!-- las noticias -->
<?=
Html::button('<i class="fa fa-pencil"></i> Publicar '. ($linea->autorizacionAutomatica == 0 ? '<i><small>Requiere Aprobación</small></i>':''), [
    //'id' => 'showFormPublications' . $linea->idLineaTiempo,
    'class' => 'btn btn-primary btn-lg btn-large',
    'data-role' => 'contenido-publicar',
    'data-linea' => $linea->idLineaTiempo
]);
?>

<?php foreach ($noticias as $noticia): ?>
    <span id='contenido_<?= $noticia->idContenido ?>'>
        <?php echo $this->render('/contenido/_contenido', ['noticia' => $noticia, 'linea' => $linea]); ?>
    </span>
<?php endforeach; ?>
<div class="row">
    <div class="col-md-6">
        <?=
        Html::a('Ver Noticas Mercadeo',  ['contenido/noticias','linea-tiempo' => $linea->idLineaTiempo], [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'class' => 'btn btn-block btn-success',
        ]);
        ?>
    </div>
    <div class="col-md-6">
        <?=
        Html::a('Ver Noticas Copservir',  ['contenido/noticias','lineaTiempo' => $linea->idLineaTiempo], [
            //'id' => 'showFormPublications' . $linea->idLineaTiempo,
            'class' => 'btn btn-block btn-warning',
        ]);
        ?>
    </div>
</div>