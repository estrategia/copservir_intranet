<?php
use yii\helpers\Html;
?>

<!-- las noticias -->
<?=
Html::button('<i class="fa fa-pencil"></i> Publicar <i><small>Requiere Aprobación</small></i>', [
    //'id' => 'showFormPublications' . $linea->idLineaTiempo,
    'class' => 'btn btn-primary btn-lg btn-large',
    'data-role' => 'contenido-publicar',
    'data-linea' => $linea->idLineaTiempo
]);
?>

<?php foreach ($noticias as $noticia): ?>
    <span id='contenido_<?= $noticia->idContenido ?>'>
        <?php echo $this->render('_contenido', ['noticia' => $noticia, 'linea' => $linea]); ?>
    </span>
<?php endforeach; ?>
