<?php

use yii\helpers\Url;
use yii\helpers\Html;
?>

<!-- las noticias -->
<?=
Html::button('<i class="fa fa-pencil"></i> Publicar <i><small>Requiere Aprobación</small></i>', [
    'id' => 'showFormPublications' . $linea->idLineaTiempo,
    'class' => 'btn btn-primary btn-lg btn-large',
    'data-role' => 'showFormPublications',
    'value' => Url::to(['sitio/form-noticia', 'lineaTiempo' => $linea->idLineaTiempo])
]);
?>

<?php foreach ($noticias as $noticia): ?>
    <span id='contenido_<?= $noticia->idContenido ?>'>
        <?php echo $this->render('_contenido', ['noticia' => $noticia, 'linea' => $linea]); ?>
    </span>
<?php endforeach; ?>

<?php
$this->registerJs(
        " //aria-expanded='true'

            $(document).on('click', '#showFormPublications" . $linea->idLineaTiempo . "', (function() {

                console.log('dio click')
                $('#modal').modal('show').find('#modal-content').load($(this).attr('value'));
                console.log($('#modal').modal('show').find('#modal-content').load($(this).attr('value')))
              }));
              "
);
?>
