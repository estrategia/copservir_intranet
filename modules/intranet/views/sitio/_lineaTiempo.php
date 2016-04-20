<?php

use yii\helpers\Html;
?>

<div class="alert alert-block alert-info fade in">
  <!--<button type="button" class="close" data-dismiss="alert"></button> // para cerrar el alert -->
                  <h4 class="alert-heading"><i class="icon-warning-sign"></i> <?= $linea->nombreLineaTiempo ?></h4>
                  <p> <?= $linea->descripcion ?> </p>
                  <!--<div class="button-set">
                    <button class="btn btn-danger btn-cons" type="button">Do this</button>
                    <button class="btn btn-white btn-cons" type="button">Or this</button>
                  </div>-->
</div>
<!-- las noticias -->
<?=
Html::button('<i class="fa fa-pencil"></i> Crear publicaci&oacute;n '. ($linea->autorizacionAutomatica == 0 ? '<i><small>Requiere Aprobaci&oacute;n</small></i>':''), [
    //'id' => 'showFormPublications' . $linea->idLineaTiempo,
    'class' => 'btn btn-primary btn-lg btn-large',
    'data-role' => 'contenido-publicar',
    'data-linea' => $linea->idLineaTiempo,

]);
?>

<?php foreach ($noticias as $noticia): ?>
    <span id='contenido_<?= $noticia->idContenido ?>'>
        <?php echo $this->render('/contenido/_contenido', ['noticia' => $noticia, 'linea' => $linea]); ?>
    </span>
<?php endforeach; ?>
<div class="row">
    <div class="col-md-6">

    </div>
    <div class="col-md-6">
        <?=
        ($linea->autorizacionAutomatica == 0)? Html::a('Ver Noticas Copservir',  ['contenido/noticias','lineaTiempo' => $linea->idLineaTiempo], [
            'class' => 'btn btn-block btn-warning',
        ]):'';
        ?>
    </div>
</div>
