<?php

use yii\helpers\Html;
use \app\modules\intranet\models\Contenido;
?>

<div class="alert alert-block alert-info fade in">

  <h4 class="alert-heading"><i class="icon-warning-sign"></i> <?= $linea->nombreLineaTiempo ?></h4>
  <p> <?= $linea->descripcion ?> </p>

</div>
<!-- las noticias -->

<!-- Boton donde se despliega el modal  -->
<div class="col-md-12">
  <hr>
</div>
<?php
   echo $this->render('/contenido/formContenido', ['objLineaTiempo' => $linea, 'objContenido' => new Contenido]);
/*
Html::button('<i class="fa fa-pencil"></i> Crear publicaci&oacute;n '. ($linea->autorizacionAutomatica == 0 ? '<i><small>Requiere Aprobaci&oacute;n</small></i>':''), [
  'class' => 'btn btn-primary btn-lg btn-large',
  'data-role' => 'contenido-publicar',
  'data-linea' => $linea->idLineaTiempo,
]);*/
?>
<div class="col-md-12">
  <hr>
</div>
<div class="col-md-12">
  <?php foreach ($noticias as $noticia): ?>
    <span id='contenido_<?= $noticia->idContenido ?>'>
      <?php echo $this->render('/contenido/_contenido', ['noticia' => $noticia, 'linea' => $linea]); ?>
    </span>
  <?php endforeach; ?>
</div>


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
